const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
   

const JavaScriptObfuscator = require('webpack-obfuscator');
module.exports = {
  entry: {
    'abc': './test/input/index.js',
    'cde': './test/input/index1.js'
  },
  output: {
    path: 'dist',
    filename: '[name].js'
  },
  plugins: [
    new JavaScriptObfuscator({
      rotateUnicodeArray: true
      //The array contains files that need to be excluded
    }, ['abc.js'])
  ]
};