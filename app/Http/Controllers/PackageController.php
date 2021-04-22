<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Package;
use App\Product;
use App\PackageProduct;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Image;
use File;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::PublishedDate()->with('products.product')->paginate(10);
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
          'filename' => '',
          'filename.*' => 'image',
        ]);


        $package = Package::create($data);

        if(isset($data['filename']))
        {
          $image = $data['filename'];
          $name = $image->getClientOriginalName();
          $extensss = $image->getClientOriginalExtension();
          $newName = $package->id.'_'.'_'.Carbon::now()->timestamp.'.'.$extensss;
          $image = Image::make($image)->resize(1280, null, function ($constraint) {
              $constraint->aspectRatio();
          });
          $local = public_path().'/image/';
          $savefile = $local.$newName;

          if (!file_exists($local)) {
              mkdir($local, 666, true);
          }

          $image->save($savefile,80);

          Storage::put('public/'.$newName, $image);

          File::delete($savefile);

          $package->image_url = $newName;
          $package->save();
        }

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

    public function show($slug)
    {
      $package=Package::where('slug',$slug)->firstorfail();
      $package->load('products.product');
      $products = $package->products->toarray();
      dd($package);
    }

    public function edit(Package $package)
    {
        //dd($package);
        $products = Product::Shoponly()->get();
        $package->load('products');
        $packageProducts=$package->products;

        return view('package.edit', compact('products','package', 'packageProducts'));
    }

    public function update(Package $package)
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
          'filename' => '',
          'filename.*' => 'image',
        ]);

        $package->update($data);



        if(isset($data['filename']))
        {
          $image = $data['filename'];
          $name = $image->getClientOriginalName();
          $extensss = $image->getClientOriginalExtension();
          $newName = $package->id.'_'.'_'.Carbon::now()->timestamp.'.'.$extensss;
          $image = Image::make($image)->resize(1280, null, function ($constraint) {
              $constraint->aspectRatio();
          });
          $local = public_path().'/image/';
          $savefile = $local.$newName;

          if (!file_exists($local)) {
              mkdir($local, 666, true);
          }

          $image->save($savefile,80);

          Storage::put('public/'.$newName, $image);

          File::delete($savefile);

          $package->image_url = $newName;
          $package->save();
        }
        
        PackageProduct::where('package_id', $package->id)->delete();

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

}
