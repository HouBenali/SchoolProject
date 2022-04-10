<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\Pokemon;

class CartController extends ApiResponseController
{
    
    public function getCart(){
        $id_user=\Auth::user()->id;
        $cart=Cart::where('user_id',$id_user)->get();
        
        $cart_poke = [];
        if (count($cart) > 0){
            for ( $x=0; $x < count($cart); $x++ ){
                $pokemon=getPokeById($cart[$x]->poke_id);
                //dd($pokemon);
                array_push($cart_poke,$pokemon);
            }
        }else{
            return $cart_poke;
        }

        return $this->successResponse($cart_poke);
    }

    public function addPoke(Request $request)
    {
        $id_user=\Auth::user()->id;
        $id_poke = $request->all()['id_poke'];
        
        $cart = new Cart();
        $cart->user_id = $id_user;
        $cart->poke_id = $id_poke;
        
        $stat = $cart->save();

        if (!$stat) {
            return $this->errorResponse("No se pudo añadir el pokemon");
        }
        // dd($cart);
        return $this->successResponse($cart);
    }

    public function delPoke(Request $request)
    {
        $id_user=\Auth::user()->id;
        $id_poke = $request->all()['id_poke'];
        
        $reg=Cart::where('user_id',$id_user)->where('poke_id',$id_poke)->delete();
        // dd($reg);

        if ($reg == 0) {
            return $this->errorResponse("No se escontro ese pokemon en el carrito");
        }
        // dd($cart);
        return $this->successResponse("pokemon eliminado del carrito");
    }
    
    public function save_poke (Request $request) {

        $total = $request->all()['price_total'];
        $pokes_id = $request->all()['pokes_id'];
        //dd($pokes_id);
        $user=userData();


        for ($x=0; $x<count($pokes_id); $x++){
            $poke = Pokemon::create([
                'user_id' => $user->id,
                'poke_id' => $pokes_id[$x]["id"],
            ]);

            $shop = new Shop();
            $shop->user_id = $user->id;
            $shop->poke_id = $pokes_id[$x]["id"];
            $shop->price = $total;
            $shop->save();
        }
        
        $this->resetCart();

        return "Compra realizada correctamente";
    }


    public function resetCart () {
        $id_user=\Auth::user()->id;
        $cart=Cart::where('user_id',$id_user)->delete();
    }

}
