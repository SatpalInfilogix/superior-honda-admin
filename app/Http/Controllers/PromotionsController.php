<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotions;
use App\Models\PromotionProducts;
use App\Models\PromotionServices;
use App\Models\PromotionImages;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('view promotions')) {
            abort(403);
        }

        $promotions = Promotions::latest()->get();
        return view('promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('create promotions')) {
            abort(403);
        }

        $products = Product::where('status', 1)->select('id', 'product_name')->latest()->get();
        
        $services = Service::select('id', 'name')->latest()->get();
        
        return view('promotions.create', compact('products', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('create promotions')) {
            abort(403);
        }

        $request->validate([
            'heading'    => 'required',
            'promotion_product_id' => 'required',
            'promotion_service_id' => 'required',
        ]);

        $promotion_exists = Promotions::where('heading', $request->heading)->where('deleted_at', NULL)->first();

        if(!empty($promotion_exists))
        {
            return redirect()->route('promotions.index')->with('error', 'This promotion heading already exists.'); 
        }else{

            $promotionMainImageFile = $request->file('main_image');
            $promotionMainImageFilename = time().'.'.$promotionMainImageFile->getClientOriginalExtension();
            $promotionMainImageFile->move(public_path('uploads/promotions/'), $promotionMainImageFilename);

            $promotion = Promotions::create([
                'heading'          => $request->heading,
                'main_image'      => isset($promotionMainImageFilename) ? 'uploads/promotions/'.$promotionMainImageFilename : NULL
            ]);

            $promotion_products = $request->promotion_product_id;

            foreach($promotion_products as $promotion_product)
            {
                $promotion_products_data = [];
                $promotion_products_data['promotion_id'] = $promotion->id;
                $promotion_products_data['product_id'] = $promotion_product;
                
                PromotionProducts::create($promotion_products_data);
            }

            $promotion_services = $request->promotion_service_id;

            foreach($promotion_services as $promotion_service)
            {
                $promotion_services_data = [];
                $promotion_services_data['promotion_id'] = $promotion->id;
                $promotion_services_data['service_id'] = $promotion_service;
                
                PromotionServices::create($promotion_services_data);
            }

            $images = $request->images;

            if ($images) {
                $files = [];
                if($request->hasfile('images'))
                {
                    foreach($request->file('images') as $file)
                    {
                        $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

                        $file->move(public_path('uploads/promotions/'), $filename);
                        PromotionImages::create([
                            'promotion_id' => $promotion->id,
                            'image'     => 'uploads/promotions/'. $filename,
                        ]);
                    }
                }
            }
    
            return redirect()->route('promotions.index')->with('success', 'Promotions saved successfully'); 
        }
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
    public function edit(string $promotion)
    {
        if (! Gate::allows('edit promotions')) {
            abort(403);
        }

        $promotion = Promotions::where('id', $promotion)
                                ->with('promotion_products', 'promotion_services', 'promotion_images')
                                ->first();

        $products = Product::where('status', 1)->select('id', 'product_name')->latest()->get();
        
        $services = Service::select('id', 'name')->latest()->get();

        return view('promotions.edit', compact('promotion', 'products', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $promotion)
    {
        if (! Gate::allows('edit promotions')) {
            abort(403);
        }

        $request->validate([
            'heading'    => 'required',
            'promotion_product_id' => 'required',
            'promotion_service_id' => 'required',
        ]);

        $promotion_exists = Promotions::where('heading', $request->heading)->where('deleted_at', NULL)->where('id', '!=', $promotion)->first();

        if(!empty($promotion_exists))
        {
            return redirect()->route('promotions.index')->with('error', 'This Promotion Heading Already Exists.'); 
        }else{

            $promotion_data = Promotions::where('id', $promotion)->first();

            $oldPromotionImage = NULL;
            if($promotion_data != '') {
                $oldPromotionImage = $promotion_data->main_image;
            }

            if(!empty($request->file('main_image')))
            {
                $promotionImageFile = $request->file('main_image');
                $promotionImageFilename = time().'.'.$promotionImageFile->getClientOriginalExtension();
                $promotionImageFile->move(public_path('uploads/promotions/'), $promotionImageFilename);
            }

            Promotions::where('id', $promotion)->update([
                'heading'        => $request->heading,
                'main_image'     => isset($promotionImageFilename) ? 'uploads/promotions/'.$promotionImageFilename : $oldPromotionImage
            ]);

            // old promotion products
            $old_promotion_products = PromotionProducts::where('promotion_id', $promotion)->get()->pluck('product_id')->toArray();

            // new promotion products
            $new_promotion_products = $request->promotion_product_id;

            // promotion products to add (new but not in old)
            $promotion_products_to_add = array_diff($new_promotion_products, $old_promotion_products);

            // promotion products to delete (old but not in new)
            $promotion_products_to_delete = array_diff($old_promotion_products, $new_promotion_products);

            // Add new promotion products
            foreach ($promotion_products_to_add as $promotion_product_to_add) {
                PromotionProducts::create([
                    'promotion_id' => $promotion,
                    'product_id' => $promotion_product_to_add
                ]);
            }

            // Delete removed promotion product
            foreach ($promotion_products_to_delete as $promotion_product_to_delete) {
                PromotionProducts::where('promotion_id', $promotion)
                    ->where('product_id', $promotion_product_to_delete)
                    ->delete();
            }

            // old promotion services
            $old_promotion_services = PromotionServices::where('promotion_id', $promotion)->get()->pluck('service_id')->toArray();

            // new promotion services
            $new_promotion_services = $request->promotion_service_id;

            // promotion services to add (new but not in old)
            $promotion_services_to_add = array_diff($new_promotion_services, $old_promotion_services);

            // promotion services to delete (old but not in new)
            $promotion_services_to_delete = array_diff($old_promotion_services, $new_promotion_services);

            // Add new promotion services
            foreach ($promotion_services_to_add as $promotion_service_to_add) {
                PromotionServices::create([
                    'promotion_id' => $promotion,
                    'service_id' => $promotion_service_to_add
                ]);
            }

            // Delete removed promotion product
            foreach ($promotion_services_to_delete as $promotion_service_to_delete) {
                PromotionServices::where('promotion_id', $promotion)
                    ->where('service_id', $promotion_service_to_delete)
                    ->delete();
            }

            $images = $request->images;

            if ($images) {
                $files = [];
                if($request->hasfile('images'))
                {
                    foreach($request->file('images') as $file)
                    {
                        $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

                        $file->move(public_path('uploads/promotions/'), $filename);
                        PromotionImages::create([
                            'promotion_id' => $promotion,
                            'image'     => 'uploads/promotions/'. $filename,
                        ]);
                    }
                }
            }

            // delete images
            if(!empty($request->image_id))
            {
                PromotionImages::whereIn('id', $request->image_id)->delete();
            }
        }

        return redirect()->route('promotions.index')->with('success', 'Promotion updated successfully');
    }

    public function disablePromotion(Request $request)
    {
        $promotion = Promotions::where('id', $request->id)->first();
        $status = 1;
        $message = 'Promotion disabled successfully.';
        if($request->disable_promotion == 'disabled'){
            $status = 'active';
            $message = 'Promotion enabled successfully.';
        }else{
            $status = 'inactive';
            $message = 'Promotion disabled successfully.';
        }

        Promotions::where('id', $request->id)->update([
          'status' => $status  
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $promotion)
    {
        if(!Gate::allows('delete promotions')) {
            abort(403);
        }

        $promotion_id = $promotion;
        $promotion = Promotions::where('id', $promotion_id)->delete();

        if(PromotionProducts::where('promotion_id', $promotion_id)->exists())
        {
            $promotion_products = PromotionProducts::where('promotion_id', $promotion_id)->delete();
        }

        if(PromotionServices::where('promotion_id', $promotion_id)->exists())
        {
            $promotion_services = PromotionServices::where('promotion_id', $promotion_id)->delete();
        }

        if(PromotionImages::where('promotion_id', $promotion_id)->exists())
        {
            $promotion_images = PromotionImages::where('promotion_id', $promotion_id)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Promotion deleted successfully.'
        ]);
    }
}
