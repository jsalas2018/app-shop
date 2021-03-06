<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::paginate(10);
    	return view('admin.products.index')->with(compact('products'));//listado
    }

    public function create()
    {
    	return view('admin.products.create');//formulario de registro
    }

    public function store(Request $request)
    {
    	//registrar el nuevo producto en la db
    	// return dd($request->all());
    	$rules = [
    		'name' => 'required|min:3',
    		'description' => 'required|max:200',
    		'price' => 'required|numeric|min:0'
    	];
    	$messages = [
    		'name.required' => 'El nombre es requerido',
    		'name.min' => 'El nombre debe tener almenos 3 caracteres',
    		'description.required' => 'El nombre debe tener almenos 3 caracteres',
    		'description.max' => 'La descripcion corta solo admite hasta 200 caracteres',
    		'price.required' => 'Es obligatorio definir un precio para el producto',
    		'price.numeric' => 'Ingrese un precio valido',
    		'price.min' => 'No se admiten valores negativos',
    	];

    	$this->validate($request, $rules, $messages);

    	$product = new Product();
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');
    	$product->save();

    	return redirect('admin/products');

    }

    public function edit($id)
    {
    	$product = Product::find($id);
    	return view('admin.products.edit')->with(compact('product'));
    }

    public function update($id,Request $request)
    {
    	$rules = [
    		'name' => 'required|min:3',
    		'description' => 'required|max:200',
    		'price' => 'required|numeric|min:0'
    	];
    	$messages = [
    		'name.required' => 'El nombre es requerido',
    		'name.min' => 'El nombre debe tener almenos 3 caracteres',
    		'description.required' => 'El nombre debe tener almenos 3 caracteres',
    		'description.max' => 'La descripcion corta solo admite hasta 200 caracteres',
    		'price.required' => 'Es obligatorio definir un precio para el producto',
    		'price.numeric' => 'Ingrese un precio valido',
    		'price.min' => 'No se admiten valores negativos',
    	];

    	$this->validate($request, $rules, $messages);
    	
    	$product = Product::find($id);
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');
    	$product->save();
    	return redirect('admin/products');
    }
    public function destroy($id)
    {
    	$product = Product::find($id);
    	$product->delete();
    	return back();
    }
}
