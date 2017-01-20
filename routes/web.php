<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::get('produtos',function(){
   return App\Produto::all();
});

Route::post('produtos',function(Illuminate\Http\Request $request){

    $rules = array(
        'nome' => 'string|required',
        'preco' => 'numeric|required',
        'estoque' => 'numeric|required',
    );

    $v = Validator::make($request->all(), $rules);

    if ($v->passes())
    {
        $produto = App\Produto::create($request->all());
        return ($produto);
    }
    return 500;
});

Route::get('produtos/remover/{id}',function($id){
    if ($produto = App\Produto::findOrFail($id)->delete()){
        return 200;
    }
    return 500;
});

Route::post('produtos/update',function (Illuminate\Http\Request $request){
    $produto = App\Produto::findOrFail($request->input('id'));

    $v = Validator::make($request->all(), array('estoque' => 'numeric|required'));

    if ($v->passes())
    {
        $produto->estoque = $request->input('estoque');
        $produto->save();
        return 200;
    }
    return 500;
});