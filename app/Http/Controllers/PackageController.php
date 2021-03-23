<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Package;
use App\Product;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;


class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::PublishedDate()->paginate(10);
        return view('package.index', compact('packages'));
    }

    public function create()
    {
        $products = Product::Shoponly()->get();
        return view('package.create', compact('products'));
    }

    public function store()
    {
        $data = request()->validate([
          'title' => 'required',
          'total' => 'required',
          'sell' => 'required',
          'percentage' => 'required',
          'status' => 'required',
          'publish_date_start' => 'required',
          'publish_date_end' => 'required',
          'description' => '',
          'productRes.*' => '',
        ]);

        $package = Package::create($data);

        $collection = collect($data['productRes']);
        $filtered = $collection->where('unit', '!=', 0);

        $package->products()->createMany($filtered->toarray());

        switch(request('submit')) {
          case 'save':
            return redirect()->route('packages.index');
          break;

          case 'new':
            return redirect()->route('packages.create');
          break;
        }

    }

    public function show(Request $request,$slug)
    {
      $package=Package::where('slug',$slug)->load('products.product')->firstorfail();
      $package->load('products.product');
      $products = $package->products->toarray();
      dd($package);
    }

}
