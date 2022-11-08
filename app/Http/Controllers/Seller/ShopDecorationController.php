<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Product;
use App\ShopDecoration;
use App\ShopDecorationImage;
use App\ShopDecorationProduct;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopDecorationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellerId = Auth::user()->seller->id;
        $shopDecoration = ShopDecoration::with('products', 'images')->where('seller_id', $sellerId)->get();

        foreach ($shopDecoration as $content) {
            $productIds = [];
            if ($content->type == 'product') {
                $products = $content->products;
                foreach ($products as $productId) {
                    $productIds[] = $productId['product_id'];
                }
                $content['productIds'] = $productIds;
            }
        }
        $sellerId = Auth::user()->seller->id;
        $products = Product::where('seller_id', $sellerId)->where('is_deleted', '0')->where('status', 'active')->get();
        $sequence = ShopDecoration::max('sequence');
        $order = $sequence > 1 ? $sequence + 1 : 1;
        return view('seller.shopdecoration.index')->with('shopDecoration', $shopDecoration)->with('products', $products)->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShopDecoration  $shopDecoration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->has('products_ids') && !$request->has('form') && !$request->has('products_idsnew')) {
            return redirect()->back()->with('error', 'Atleast one content is required');
        }

        if (($request->has('content_id') && count($request->content_id) > 0)) {
            $contents = ShopDecoration::whereNotIn('id', $request->content_id)->get();
            foreach ($contents as $content) {
                if ($content->products->count() > 0) {
                    $content->products()->delete();
                }
                if ($content->images->count() > 0) {
                    $content->images()->delete();
                }
                $content->delete();
            }
        }

        if (($request->has('remove_img') && count($request->remove_img) > 0)) {
            foreach ($request->remove_img as $key => $image) {
                if ($image != null) {
                    $removeImage = explode(",", $image);
                    foreach ($removeImage as $img) {
                        $existingImage = ShopDecorationImage::find($img);
                        $originalmage = $existingImage->image;
                        $s3path = parse_url($originalmage);
                        if (Storage::disk('s3')->exists($s3path['path'])) {
                            Storage::disk('s3')->delete($s3path['path']);
                        }
                        $existingImage->delete();
                    }
                }
                $hasImage = ShopDecoration::with('images')->has('images')->where('id', $key)->get();
                if (count($hasImage) < 1) {
                    ShopDecoration::where('id', $key)->delete();
                }
            }
        }

        $sequence = ShopDecoration::max('sequence');
        $order = $sequence > 1 ? $sequence + 1 : 1;

        for ($i = $order; $i <= $request->order; $i++) {
            if ($request->has('form') && isset($request->form) && isset($request->form[$i])) {
                // return $request->form[$i];
                $shopDecoration = new ShopDecoration();
                $shopDecoration->seller_id = Auth::user()->seller->id;
                $shopDecoration->type = 'image';
                $shopDecoration->sequence = $i;
                $shopDecoration->save();

                foreach ($request->form[$i] as $file) {
                    $image_parts = explode(';base64,', $file);
                    $image_type_aux = explode(
                        'image/',
                        $image_parts[0]
                    );
                    $image_type = key_exists(1, $image_type_aux)
                    ? $image_type_aux[1]
                    : time();
                    $image_base64 = base64_decode($image_parts[1]);
                    $renamed = time() . rand() . '.' . $image_type;
                    $path = "images/shopdecoration/" . $renamed;
                    $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                    $fileURL = Storage::disk('s3')->url($path);
                    $deecorImage = new ShopDecorationImage();
                    $deecorImage->shop_decoration_id = $shopDecoration->id;
                    $deecorImage->image = $fileURL;
                    $deecorImage->save();
                }
            }
            if ($request->has('products_idsnew') && isset($request->products_idsnew) && isset($request->products_idsnew[$i])) {
                // return $request->form[$i];
                $shopDecoration = new ShopDecoration();
                $shopDecoration->seller_id = Auth::user()->seller->id;
                $shopDecoration->type = 'product';
                $shopDecoration->sequence = $i;
                $shopDecoration->save();

                foreach ($request->products_idsnew[$i] as $product) {
                    $deecorProduct = new ShopDecorationProduct();
                    $deecorProduct->shop_decoration_id = $shopDecoration->id;
                    $deecorProduct->product_id = $product;
                    $deecorProduct->save();
                }
            }
        }

        if ($request->has('content_id') && count($request->content_id) > 0) {
            foreach ($request->content_id as $content) {
                if (isset($request->form) && isset($request->form[$content])) {
                    foreach ($request->form[$content] as $file) {
                        $image_parts = explode(';base64,', $file);
                        $image_type_aux = explode(
                            'image/',
                            $image_parts[0]
                        );
                        $image_type = key_exists(1, $image_type_aux)
                        ? $image_type_aux[1]
                        : time();
                        $image_base64 = base64_decode($image_parts[1]);
                        $renamed = time() . rand() . '.' . $image_type;
                        $path = "images/shopdecoration/" . $renamed;
                        $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                        $fileURL = Storage::disk('s3')->url($path);

                        $deecorImage = new ShopDecorationImage();
                        $deecorImage->shop_decoration_id = $content;
                        $deecorImage->image = $fileURL;
                        $deecorImage->save();
                    }
                }
            }
        }

        if ($request->has('products_ids') && count($request->products_ids) > 0) {
            foreach ($request->products_ids as $key => $product) {
                $decorationId = ShopDecorationProduct::where('shop_decoration_id', $key)->delete();
                foreach ($product as $productID) {
                    $deecorProduct = new ShopDecorationProduct();
                    $deecorProduct->shop_decoration_id = $key;
                    $deecorProduct->product_id = $productID;
                    $deecorProduct->save();
                }
            }
        }
        return redirect()->route('seller.shop-decorations.index')->with('success', 'Shop decoration added successfully');
    }
}
