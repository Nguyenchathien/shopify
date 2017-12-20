<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Validator;
use Shopify;
use App\Image;
use \stdClass;
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
     * Get list product
     */
    public function index(Request $request)
    {
        //get list products on Shopify store
        $products = Shopify::api('products')->all();
		
        return view('products.index',[
                'products'    => $products["products"]
            ]);

    }

    public function create()
    {

        return view('products.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $this->validate($request, [
        //     'product[title]' => 'required',
        // ]);

		$notification = array(
			'message' => 'Product was successfully created', 
			'alert-type' => 'success'
		);

		$product = array();
        $product["product"] = array();
        $product["product"] = $request->product;
        $product["product"]["variants"] = $this->createVariants($request);

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
				// $imagick->borderImage(new ImagickPixel("red"), 50, 50);
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
		dd($product); 
        if($product) {

			$product_url = "/admin/products.json";
            $res = $this->sendRequest($product, $product_url, "POST");
            // dd($res);
            if($res) {

                //remove image after upload successful
                // dd($dir);
                // unlink($dir);
            }
        }

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
        // dd($images[1416133738537]);
        dd(gettype($product["product"]["tags"]));
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
    	// dd($request->all());
        // $this->validate($request, [
        //     'title' => 'required',
        // ]);
    	// $variants = $request->product["variants"]?$request->product["variants"]:'';
    	$product = array();
        $product["product"] = array();
        $product["product"] = $request->product;
        // $product["product"]["variants"] = $variants;

        $sizes      = $request->sizes?$request->sizes:'';
        $colors     = $request->colors?$request->colors:'';
        $materials  = $request->materials?$request->materials:'';

        //$product_type 		= $request->product["product_type"]?$request->product["product_type"]:'';
        // $product_vendor  	= $request->product["vendor"]?$request->product["vendor"]:'';
        // $product_tags  		= $request->product["tags"][]?$request->product["tags"][]:'';

        // dd($product_type);

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
				// $imagick->borderImage(new ImagickPixel("red"), 50, 50);
				$imagick->setCompressionQuality(20);
				$imagick->setImageDepth(8);
				$imagick->despeckleimage();
		        $imagick->writeImage($dir);
            }

            $product["product"]["images"] = array(
                array("src" => $url_image)
            );

            $product["product"]["image"] = array("src" => $url_image);

        } else {

        	$product["product"]["images"] = array(
                array("src" => $request->url_image)
            );

            $product["product"]["image"] = array("src" => $request->url_image);
        }

        // dd($product);

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

    public function destroy(Request $request)
    {
        $product_id = $request->input('id');
        dd($product_id);

        $res = Shopify::remove();

    }

    public function getImageVariant($images)
    {
        $res = array();
        foreach ((array)$images as $image) {
            $res[$image['id']] = $image['src'];
        }

        return $res;
    }

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
