<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Product;

class ProductController extends Controller
{
  public function index()
  {
      $products = Product::paginate(10);
      return view('product.index', compact('products'));
  }

  public function create()
  {
      return view('product.create');
  }

  public function store()
  {
      $data = request()->validate([
        'name' => 'required',
        'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'status' => 'required',
        'shop' => 'required',
        'description' => '',
      ]);

      $product = Product::create($data);
      switch(request('submit')) {
        case 'save':
          return redirect()->route('products.index');
        break;

        case 'new':
          return redirect()->route('products.create');
        break;
      }

  }

  public function edit(Product $product)
  {
      return view('product.edit', compact('product'));
  }

  public function update(Product $product)
  {
      $data = request()->validate([
        'name' => 'required',
        'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'status' => 'required',
        'type' => 'required',
        'shop' => 'required',
        'description' => '',
      ]);

      $product->update($data);

      switch(request('submit')) {
        case 'save':
          return redirect()->route('products.index');
        break;

        case 'new':
          return redirect()->route('products.create');
        break;
      }

  }

}
