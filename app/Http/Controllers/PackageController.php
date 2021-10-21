<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Package;
use App\Product;
use App\PackageProduct;
use App\PackageVariant;
use App\PackageVariantRedeemLocation;
use App\VoucherType;
use App\VariantVoucher;
use App\PatientVoucher;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Image;
use File;
use Illuminate\Support\Collection;

class PackageController extends Controller
{
    public function index()
    {
        //$packages = Package::PublishedDate()->with('variants')->paginate(10);
        $packages = Package::with('variants')->paginate(10);
        return view('package.index', compact('packages'));
    }

    public function create()
    {
        $products = Product::Shoponly()->get();
        return view('package.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
          'title' => 'required',
          'sku' => 'required|unique:packages,sku',
          'status' => 'required',
          'publish_date_start' => 'required',
          'publish_date_end' => 'required',
          'description' => '',
          'remark' => '',
          /*'productRes.*' => '',
          'filename' => '',
          'filename.*' => 'image',*/
        ]);


        $package = Package::create($data);

        if($request->hasFile('filename') && $request->file('filename')->isValid()){
            $package->addMediaFromRequest('filename')->toMediaCollection('PackageBanner');
        }

        /*if(isset($data['filename']))
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
        }*/

        /*
        $collection = collect($data['productRes']);
        $filtered = $collection->where('unit', '!=', 0);

        $package->products()->createMany($filtered->toarray());
        */

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
        //$packageProducts=$package->products;

        return view('package.edit', compact('products','package'));
    }

    public function update(Package $package, Request $request)
    {
        $data = request()->validate([
          'title' => 'required',
          'sku' => 'required',
          'status' => 'required',
          'publish_date_start' => 'required',
          'publish_date_end' => 'required',
          'description' => '',
          'remark' => '',
          //'productRes.*' => '',
          'filename' => '',
          'filename.*' => 'image',
        ]);

        $package->update($data);

        if($request->hasFile('filename') && $request->file('filename')->isValid()){
            $package->addMediaFromRequest('filename')->toMediaCollection('PackageBanner');
        }
        /*if(isset($data['filename']))
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
        }*/

        /*
        PackageProduct::where('package_id', $package->id)->delete();

        $collection = collect($data['productRes']);
        $filtered = $collection->where('unit', '!=', 0);

        $package->products()->createMany($filtered->toarray());
        */

        switch(request('submit')) {
          case 'save':
            return redirect()->route('packages.index');
          break;

          case 'new':
            return redirect()->route('packages.create');
          break;
        }

    }


    public function subVariants (Request $request)
    {
        //$variants = PackageVariant::where('package_id', $request->package_id)->Published()->get();
        //$variants = Package::where('id', $request->package_id)->with('variants')->get();
        $sortDirection = 'asc';
        $variants = Package::where('id', $request->package_id)->with(['variants' => function ($query) use ($sortDirection) {
            $query->orderBy('position', $sortDirection);
        }])->get();
        return response()->json([
            'variants' => $variants
        ]);
    }

    public function varaintDetail (Request $request)
    {
        //$variants = PackageVariant::where('package_id', $request->package_id)->Published()->get();

        //$maxVocuher = PatientVoucher::where('voucher_type_id', 2)->count();
        //$variant[0]['vouchers'][0]['test'] = 'test';
        //$maxVocuhers = $variant[0]['vouchers'][0]->put('third', 'I am third');
        $variant = PackageVariant::where('id', $request->variant_id)->with('vouchers.type')->get();
        foreach ($variant[0]->vouchers as $key => $voucher) {
          $count = PatientVoucher::where('voucher_type_id', $voucher->voucher_type_id)->count();
          $voucher->max = 10000+$count;
        }

        return response()->json([
            //'max' => $maxVocuhers,
            'variant' => $variant
        ]);
    }


    public function showPackageVariants(Package $package)
    {
        //dd($package->variants);
        $package->load('variants.vouchers.type');
        return view('package.variant.index', compact('package'));
    }

    public function indexVariant()
    {
        $variants = PackageVariant::get();
        dd($variants);
        return view('package.index', compact('packages'));
    }

    public function createVariant(Package $package)
    {
        $types = VoucherType::Published()->get();
        $vExpiry = config('ttm.expiry');
        return view('package.variant.create', compact('package', 'types', 'vExpiry'));
    }

    public function saveVariant(Package $package)
    {
        $data = request()->validate([
          'name' => 'required',
          'sku' => 'required|unique:package_variants,sku',
          'status' => 'required',
          'online' => 'required',
          'remark' => '',
          'stock' => '',
          'expiry' => 'required',
          'price' => 'required',
          'sell' => 'required',
          'voucherRes.*' => '',
        ]);


        $variant = $package->variants()->create($data);



        $collection = collect($data['voucherRes']);
        $filtered = $collection->where('quantity', '!=', 0);

        $variant->vouchers()->createMany($filtered->toarray());

        switch(request('submit')) {
          case 'save':
            return redirect()->route('packages.index');
          break;

          case 'new':
            return redirect()->route('packages.index');
          break;
        }

    }

    public function editVariant(Package $package, PackageVariant $variant)
    {
        $package->load(['variants' => function ($query) use ($variant) {
            $query->where('id', $variant->id);
        }])->first();

        $vTypes = VoucherType::Published()->get();
        $vExpiry = config('ttm.expiry');

        if($package->variants->isNotEmpty()) {
          return view('package.variant.edit', compact('variant', 'vTypes', 'vExpiry'));
        } else {
          return abort(404);
        }


    }

    public function updateVariant(Package $package,PackageVariant $variant,Request $request)
    {
        //dd(request()->all());
        $data = request()->validate([
          'name' => 'required',
          'sku' => 'required',
          'title' => '',
          //'banner_image' => '',
          'status' => 'required',
          'online' => 'required',
          'remark' => '',
          'stock' => '',
          'expiry' => 'required',
          'price' => 'required',
          'sell' => 'required',
          'description' => '',
          'redeem' => '',
          'will_get' => '',
          'tnc' => '',
          'voucherRes.*' => '',
          'location.*' => '',
        ]);

        $variant->update($data);

        VariantVoucher::where('variant_id', $variant->id)->delete();
        PackageVariantRedeemLocation::where('variant_id', $variant->id)->delete();

        if(isset($data['location'])) {
          $variant->redeemLocations()->createMany($data['location']);
        }

        $collection = collect($data['voucherRes']);
        $filtered = $collection->where('quantity', '!=', 0);

        $variant->vouchers()->createMany($filtered->toarray());

        if($request->hasFile('banner_image') && $request->file('banner_image')->isValid()){
            $variant->addMediaFromRequest('banner_image')->toMediaCollection('VariantBanner');
        }

        /*if(isset($data['banner_image']))
        {
          $image = $data['banner_image'];
          $name = $image->getClientOriginalName();
          $extensss = $image->getClientOriginalExtension();
          $newName = $variant->id.'_'.'_'.Carbon::now()->timestamp.'.'.$extensss;
          $image = Image::make($image)->resize(1280, null, function ($constraint) {
              $constraint->aspectRatio();
          });
          $local = public_path().'/banner_variant/';
          $savefile = $local.$newName;

          if (!file_exists($local)) {
              mkdir($local, 666, true);
          }

          $image->save($savefile,80);

          Storage::put('public/banner_variant/'.$newName, $image);

          File::delete($savefile);

          $variant->banner_image = $newName;
          $variant->save();
        }*/

        switch(request('submit')) {
          case 'save':
            //return redirect()->route('show.package.variants', $variant->package_id);
            return back();
          break;

          case 'new':
            return redirect()->route('packages.create');
          break;
        }

    }

    public function checkDuplicateCode(Request $request)
    {
      $code = PatientVoucher::where('code', $request->code)->first();
      if($code) {
        $status='yes';
      } else {
        $status='no';
      }
      return response()->json([
          'status' => $status
      ]);
    }

}
