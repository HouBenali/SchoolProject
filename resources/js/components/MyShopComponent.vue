<template>
<div class="myshop">
    <div class="chooseArea">MY SHOPPING RECORDS</div>
    <!-- {{pedidos}} -->
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Pokemon</th>
                <th scope="col">Fecha</th>
                <th scope="col">Precio</th>
            </tr>
        </thead>
            <tbody  v-for="pedido in pedidos" :key="pedido.id">
                <tr>
                    <th scope="row">{{pedido.id}}</th>
                    <!-- <td>{{pedido.pokemon.name}}</td> -->
                    <td><img class="poke_icon" :src="pedido.poke_id.image_path" alt=""></td>
                    <td>{{pedido.created_at}}</td>
                    <td>{{pedido.price}}</td>
                </tr>
            </tbody>
    </table>
</div>
</template>

<script>

    export default {
        
        name: 'MyShopComponent',
        created () {
            this.getMyShop () 
        },
        data: function () {
            return {
                pedidos:"",     
            }
        },
        methods:{
            async getMyShop () {
                // this.$awn.asyncBlock(fetch('/api/pokemon?page='+this.currentPage)
                await axios.get('/api/user/getMyShops')
                .then(response => {
                    //console.log(response.data,"MIS COMPRAS")
                    this.pedidos = response.data;
                    })

                for ( let x=0; x<this.pedidos.length; x++ ) {
                    var date = new Date(this.pedidos[x].created_at);
                    this.pedidos[x].created_at = date.toDateString()
                }
    
            },
        },

    }
</script>
<style scoped>
.myshop{
    color: white;
}


.poke_icon{
    width: 50px;
    height: 50px;
}
</style>