<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::with('user')->where('status', 'active')->latest()->get();

        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('banner'))
        {
            $file = $request->file('banner');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/banner/'), $filename);
        }

        $product_id = NULL;
        $product = Product::where('product_name', $request->product)->first();
        if($product) {
            $product_id = $product->id;
        }
        Banner::create([
            'user_id'      => Auth::id(),
            'product_name' => $request->product,
            'product_id'   => $product_id,
            'menu'         => $request->menu,
            'submenu'      => $request->submenu,
            'type'         => $request->type,
            'size'         => $request->size,
            'banner_image' => isset($filename) ? 'uploads/banner/'.$filename : NULL
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner saved successfully'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::where('id', $id)->first();

        return view('banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::where('id', $id)->first();
        $oldBanner = NULL;
        if($banner != '') {
            $oldBanner = $banner->banner_image;
        } 
        if ($request->hasFile('banner'))
        {
            $file = $request->file('banner');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/banner/'), $filename);
        }

        $product_id = NULL;
        $product = Product::where('product_name', $request->product)->first();
        if($product) {
            $product_id = $product->id;
        }

        $banner->update([
            'user_id'      => Auth::id(),
            'product_name' => $request->product,
            'product_id'   => $product_id,
            'menu'         => $request->menu,
            'submenu'      => $request->submenu,
            'type'         => $request->type,
            'size'         => $request->size,
            'banner_image' => isset($filename) ? 'uploads/banner/'.$filename : $oldBanner
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Banner::where('id', $id)->update([
            'status' => 'deactive'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.'
        ]);
    }
}
