<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Validator;
use Shopify;
use App\Image;
use \stdClass;
use Illuminate\Http\Request;

class ProductController extends AppController
{

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $shopify;


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
        // dd(Shopify::api('types')->all());
        //get list products on Shopify store
        $products = Shopify::api('products')->all();
        // dd($products["products"]);

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
        $this->validate($request, [
            'title' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = $request->title.'.'.$photo->getClientOriginalExtension();
            $filesize = $photo->getClientSize();
            $path = public_path().'/upload/img';
            $photo->move($path, $filename);
            $dir=$path.'/'.$filename;
            $url_image = env('APP_URL').'/upload/img/'.$filename;
            //get the extension of the image file
            $tumbnailExtention = preg_replace('/^.*\.([^.]+)$/D', '$1', $dir);
            $postFile = "@$dir;type=image/$tumbnailExtention";
             
            if(file_exists($dir)) {
                // exec(" magick convert $dir -fuzz 0% -transparent none -quality 20 -depth 8 ");
                // exec("magick convert $path'/123.jpg' -resize 50% $path'/123.png'");
            }

        }


        $product = $this->setFormatDatas($request, $url_image);

        // dd($product );

        $data_string = json_encode($product);
        $url = 'https://chathienstore.myshopify.com/admin/products.json';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");     
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "a786358691674f05f5b85ced9fff16e1:32b5acb980ce193f4a81fc406e6348cd");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
                                                                                                                             
        $result = curl_exec($curl);

        return redirect('/');

    }

    public function setFormatDatas($request, $url_image)
    {
        $res=array();
        $res["product"] = array(

                "title"         => $request->title,
                "body_html"     => $request->title?$request->title:'',
                "vendor"        => $request->vendor?$request->vendor:'',
                "product_type"  => $request->product_type?$request->product_type:'',
                "published"     => true ,
                "options"       =>array(
                                    array("name" => "Size"),
                                    array("name" => "Color"),
                                    array("name" => "Style"),
                                ),
                "images"        => array(
                                    array("src" => $url_image),
                                    array("attachment" => $url_image),
                                    // array("src" => "https://www.google.com.vn/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png"),
                                ),
                "variants"      =>array(
                                    array(
                                        "sku"=>"4321CL571LRB",
                                        "price"=>20.00,
                                        "grams"=>200,
                                        "taxable"=>false,
                                        "required_shipping" => true,
                                        "option1" => "Large",
                                        "option2" => "Royal",
                                        "option3" => "Women's Shirt",
                                    ),
                                    array(
                                        "sku"=>"1234CL621SBL",
                                        "price"=>20.00,
                                        "grams"=>200,
                                        "taxable"=>false,
                                        "required_shipping" => true,
                                        "option1" => "Small",
                                        "option2" => "Black",
                                        "option3" => "Shirt",
                                    ),
                                )
        );

        dd($res);

        return $res;

    }

    public function store1(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            ]);

        $product = Shopify::getProduct();

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = $request->title.'.'.$photo->getClientOriginalExtension();
            $filesize = $photo->getClientSize();
            $path = public_path().'/upload/img';
            $photo->move($path, $filename);
            $dir=$path.'/'.$filename;
            if(file_exists($dir)) {
                // exec(" magick convert $dir -fuzz 0% -transparent none -quality 20 -depth 8 ");
                // exec("magick convert $path'/123.jpg' -resize 50% $path'/123.png'");
            }

            // $data=[];
            // $data['image'] = ([

            //     'src' => $path
            // ]);

            // $product->createImage($id, $data);
            
        }
        //  $data = array(
        //     "product" => array(
        //         "title" => "Mau cho",
        //         "vendor" => "abc",
        //         "product_type" => "Olie",
        //         "body_html" => "Body",
        //         "options" => array(
        //             [
        //                 "name" => "Finish",
        //                 "position" => 1,
        //             ]
        //         ),
        //         "variants" => array(
        //             [
        //                 "option1" => "Op1",
        //                 "price" => 10.00
        //             ]
        //         ),
        //         /*"images" => array(
        //             [
        //                 "attachment" => $pngdata
        //             ]
        //         )*/
        //         "images"=> array(
        //             array(
        //                 "attachment" => "R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==\n"
                         
        //             )
        //         )    
        //     )
        // );
        // 
        
        // print_r($product);

        $images = array(
                                array("src" => "https://www.google.com.vn/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png"),
                                array("src" => "https://www.google.com.vn/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png"),
                                );
        // $image = 
        //             array(
        //                 "attachment" => "R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==\n"
                         
        //         ) ;
        // $product->setImage([$image]);
        $product->setTitle($request->title);
        // $product->setBodyHtml($request->body_html);
        // $product->setVendor($request->vendor);
        $product->setImages($image);
        // $product->setImage($path);
        // $product->setProductType($request->product_type);
        // $product->setHandle($request->handle);
        // $product->setUpdatedAt($request->handle);
        // $product->setTemplateSuffix($request->template_suffix);
        // $product->setPublishedScope($request->published_scope);
        // $product->setTags($request->tag);
        // $product->setVariants($request->variants);
        // $product->setOptions($request->options);
        // dd($product);
        $product->save();

        return redirect('/');
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
        // dd($product = Shopify::getProduct());
        //get product information
        $product = Shopify::api('products')->show($id);
        dd($product);

        return view('products.update',[
                'product' => $product["product"]
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
        $this->validate($request, [
            'title' => 'required',
        ]);

        $product = Shopify::getProduct($id);
        dd($product);

        if(!$product) {

        }


        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = $request->title.'.'.$photo->getClientOriginalExtension();
            $filesize = $photo->getClientSize();
            $path = public_path().'/upload/img';
            $photo->move($path, $filename);
            $dir=$path.'/'.$filename;
            if(file_exists($dir)) {
                exec(" magick convert $dir -fuzz 0% -transparent none -quality 20 -depth 8 ");
                // exec("magick convert $path'/123.jpg' -resize 50% $path'/123.png'");
            }

            $data=array(
                'position' => 4
            );

            $product->updateImage(1475057483819, $data);
        }

        $product->setTitle($request->title);
        $product->setBodyHtml($request->body_html);
        $product->setVendor($request->vendor);
        $product->setProductType($request->product_type);
        $product->setHandle($request->handle);
        $product->setUpdatedAt($request->handle);
        $product->setTemplateSuffix($request->template_suffix);
        $product->setPublishedScope($request->published_scope);
        $product->setTags($request->tag);
        $product->setVariants($request->variants);
        $product->setOptions($request->options);
        
        $product->save();

        return redirect('/');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductTypes(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $categories = Tag::search($term)->limit(5)->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->name];
        }

        return \Response::json($formatted_tags);
    }

    public function destroy($id)
    {
        $res = Shopify::remove($id);

    }
}
