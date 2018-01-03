<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Validator;
use Shopify;
use App\Image;
use Imagick;
use ImagickPixel;
use Illuminate\Http\Request;

class ProductController extends AppController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show product list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get list products on Shopify store
        $products = Shopify::api('products')->all();
		
        return view('products.index',[
                'products'    => $products["products"]
            ]);

    }

	/**
     * Display create page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

	/**
     * Create the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$product = array();
        $product["product"] = array();
        $product["product"] = $request->product;
        $product["product"]["variants"] = $this->createVariants($request);

        $sizes      = $request->sizes?$request->sizes:'';
        $colors     = $request->colors?$request->colors:'';
        $materials  = $request->materials?$request->materials:'';

        if(!empty($sizes)) $product["product"]["options"][]     = array("name" => $request->size);
        if(!empty($colors)) $product["product"]["options"][]    = array("name" => $request->color);
        if(!empty($materials)) $product["product"]["options"][] = array("name" => $request->marterial);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = $product["product"]["title"].'.'.$photo->getClientOriginalExtension();
            // $filesize = $photo->getClientSize();
            $path = public_path().'/upload/img';

            $photo->move($path, $filename);
            $dir=$path.'/'.$filename;
        	$url_image = env('APP_URL').'/upload/img/'.$filename;

            if(file_exists($dir)) {
                $imagick = new Imagick($dir);
				$imagick->setCompressionQuality(20);
				$imagick->setImageDepth(8);
				$imagick->despeckleimage();
		        $imagick->writeImage($dir);
            }

            $product["product"]["images"] = array(
                array("src" => $url_image)
            );

            $product["product"]["image"] = array("src" => $url_image);
        }

        if($product) {

			$product_url = "/admin/products.json";
            $res = $this->sendRequest($product, $product_url, "POST");
            if($res) {

                //remove image after upload successful
                // dd($dir);
                // unlink($dir);
            }
        }
		
		$notification = array(
			'message' => 'Product was successfully created', 
			'alert-type' => 'success'
		);

        return redirect('/')->with($notification);

    }
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get product information
        $product = Shopify::api('products')->show($id);
        $images = $this->getImageVariant($product["product"]["images"]);
        if(!$product) {
            $notification = array(
                'message' => 'Product Not Found', 
                'alert-type' => 'error'
            );

            return redirect('/')->with($notification);
        }

        return view('products.update',[
                'product'   => $product["product"],
                'images'    => $images
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) 
    {
    	$product = array();
        $product["product"] = array();
        $product["product"] = $request->product;

        $sizes      = $request->sizes?$request->sizes:'';
        $colors     = $request->colors?$request->colors:'';
        $materials  = $request->materials?$request->materials:'';

        if(!empty($sizes)) $product["product"]["options"][]     = array("name" => $request->size);
        if(!empty($colors)) $product["product"]["options"][]    = array("name" => $request->color);
        if(!empty($materials)) $product["product"]["options"][] = array("name" => $request->material);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = $product["product"]["title"].'.'.$photo->getClientOriginalExtension();
            // $filesize = $photo->getClientSize();
            $path = public_path().'/upload/img';

            $photo->move($path, $filename);
            $dir=$path.'/'.$filename;
        	$url_image = env('APP_URL').'/upload/img/'.$filename;

            if(file_exists($dir)) {
                $imagick = new Imagick($dir);
				$imagick->setCompressionQuality(20);
				$imagick->setImageDepth(8);
				$imagick->despeckleimage();
		        $imagick->writeImage($dir);
            }

			$img_src = array("src" => $url_image);
            $product["product"]["image"] = $img_src;
            if(!empty($product["product"]["images"])) {
		        array_unshift($product["product"]["images"], $img_src);
            }else{
                $product["product"]["images"] = array($img_src);
            }

        } else {
			
			$img_id = array("id" => $request->image_id);
            $product["product"]["image"] = $img_id;
            if(!empty($product["product"]["images"])) {
                array_unshift($product["product"]["images"], $img_id);
            }else{
                $product["product"]["images"] = $img_id;
            }
        }

        if($product) {

            $notification = array(
                'message' => 'Product was successfully updated', 
                'alert-type' => 'success'
            );

        	$product_id = $request->product["id"];
            $product_url = "/admin/products/$product_id.json";
            $res = $this->sendRequest($product, $product_url, "PUT");
            if(!$res) {
                $notification = array(
                    'message' => 'Update fail!', 
                    'alert-type' => 'error'
                );

                return redirect('/')->with($notification);
            }

        }

        return redirect('/')->with($notification);
    }

	/**
     * Display create page
     *
     * @return \Illuminate\Http\Response
     */
    public function editVariant($product_id, $variant_id)
    {
		//get product and variant information
        $product 	= Shopify::api('products')->show($product_id);
		$variant 	= Shopify::api('variants')->show($variant_id);
		$variants 	= Shopify::api('variants')->product($product_id)->all();
		$images 	= $this->getImageVariant($product["product"]["images"]);
		
		return view('products.variants.update',[
                'variant'	=> $variant["variant"],
                'variants'	=> $variants["variants"],
                'product'	=> $product["product"],
                'images'	=> $images
            ]);
    }

    /**
     * Update variant information
     *
     * @return \Illuminate\Http\Response
     */
    public function updateVariant(Request $request, $variant_id)
    {
    	$variant = array();
        $variant["variant"] = array();
        $variant["variant"] = $request->variant;
        $variant["variant"]["inventory_management"]=($request->variant["inventory_management"]=="shopify")?"shopify":'';

        if ($request->hasFile('image')) {
            $photo 		= $request->file('image');
            // $filename 	= $request->variant["title"].'.'.$photo->getClientOriginalExtension();
            $filename 	= str_random(6).'.'.$photo->getClientOriginalExtension();
            $path 		= public_path().'/upload/img';
            $photo->move($path, $filename);
            $dir		=$path.'/'.$filename;
        	$url_image 	= env('APP_URL').'/upload/img/'.$filename;

            if(file_exists($dir)) {
                $imagick = new Imagick($dir);
				$imagick->setCompressionQuality(20);
				$imagick->setImageDepth(8);
				$imagick->despeckleimage();
		        $imagick->writeImage($dir);
            }

            // Update a product variant with an image
            $images = array();
            $images["image"] = array();
            $images["image"]["variant_ids"] = array($variant_id);
            $images["image"]["src"] = $url_image;
            $product_id = $request->product_id;
            $img_url = "/admin/products/$product_id/images.json";
            $result = $this->sendRequest($images, $img_url, "POST");

            if(!$result) {
                $notification = array(
                    'message' => 'Update fail!', 
                    'alert-type' => 'error'
                );

                return redirect('/')->with($notification);
            }

        } else {
        	$variant["variant"]["image_id"]=$request->image_id;
        }

        if($variant) {

            $notification = array(
                'message' => 'Variant was successfully updated', 
                'alert-type' => 'success'
            );

        	$variant_id = $request->variant["id"];
            $variant_url = "/admin/variants/$variant_id.json";
            $res = $this->sendRequest($variant, $variant_url, "PUT");
            if(!$res) {
                $notification = array(
                    'message' => 'Update fail!', 
                    'alert-type' => 'error'
                );

                return redirect('/')->with($notification);
            }

        }

        return redirect('/')->with($notification);
    }
	
	/**
     * delete product
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_url = "/admin/products/$id.json";
        $res = $this->sendRequest("", $product_url, "DELETE");
        if(!$res) {
            return response()->json([
                'status' => 'NO'
            ]);
        }

        return response()->json([
            'status' => 'YES'
        ]);

    }

    /**
     * delete product variant
     *
     * @return \Illuminate\Http\Response
     */
    public function variantDestroy(Request $request)
    {
		$product_id = $request->product_id;
		$variant_id = $request->variant_id;
		
        $product_url = "admin/products/$product_id/variants/$variant_id.json";
        $res = $this->sendRequest("", $product_url, "DELETE");
		
        if(!$res) {
            return response()->json([
                'status' => 'NO'
            ]);
        }

        return response()->json([
            'status' => 'YES'
        ]);

    }

    /**
     * get list variant images
     *
     * @return array()
     */
    public function getImageVariant($images)
    {
        $res = array();
        foreach ((array)$images as $image) {
            $res[$image['id']] = $image['src'];
        }

        return $res;
    }

	/**
     * Create product variant list
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array()
     */
    public function createVariants($request)
    {
        $sizes      = $request->sizes?$request->sizes:'';
        $colors     = $request->colors?$request->colors:'';
        $materials  = $request->materials?$request->materials:'';
        $variant    = $request->product["variant"]?$request->product["variant"]:'';

        $result = [];
        foreach ((array)$sizes as $s => $size) {

      			foreach ((array)$colors as $c => $color) {

	          			foreach ((array)$materials as $m => $material) {

	                        $result[] = array(

                                    "sku"                   => $variant["sku"]?$variant["sku"]:'',
                                    "barcode"               => $variant["barcode"]?$variant["barcode"]:'',
                                    "inventory_management"  => ($variant["inventory_management"]=="shopify")?"shopify":'',
                                    "inventory_quantity"    => $variant["inventory_quantity"]?$variant["inventory_quantity"]:'',
                                    "inventory_policy"      => $variant["inventory_policy"]?$variant["inventory_policy"]:'deny',
                                    "requires_shipping"     => $variant["requires_shipping"]?$variant["requires_shipping"]:'false',
                                    "fulfillment_service"   => $variant["fulfillment_service"]?$variant["fulfillment_service"]:'false',
                                    "price"                 => $variant["price"]?$variant["price"]:'0',
                                    "compare_at_price"      => $variant["compare_at_price"]?$variant["compare_at_price"]:'',
                                    "taxable"               => $variant["taxable"]?$variant["taxable"]:'',
    	                            "option1"               => $size,
    	                            "option2"               => $color, 
    	                            "option3"               => $material
	                        );
	                    }
	              	
	            }
        }

        return $result;
    }
}
