@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit product</h3>

                                <div class="box-tools">
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a href="/" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
                                    </div> 
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a class="btn btn-sm btn-default" onclick="window.history.back();history.back();"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::model($product, array('url'=>'product/update/' . $product["id"], 'class'=>'form-horizontal', 'files' => true, 'method'=>'PUT')) !!}
                                {{ csrf_field() }}
                                <input type="hidden" name="url_image" @if(isset($product["image"])) value="{{ $product["image"]["src"]}}" @else value=" " @endif>
                                <input type="hidden" name="product[id]" value="{{ $product["id"]}}">
                                <div class="box-body">
                                    <div class="col-md-8">
                                        <!-- ### TITLE ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <span class="panel-desc"> Title</span>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <input type="text" class="form-control" name="product[title]" placeholder="Short Sleeve T-Shirt" value="{{ $product["title"] }}" required>
                                            </div>
                                        </div>

                                        <!-- ### CONTENT ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading" style="padding-left: 0px;">
                                                <h3 class="panel-title"><i class="icon wb-book"></i> Description</h3>
                                            </div>
                                            <textarea class="form-control" name="product[body_html]" id="body_html" style="border:0px;">{{ $product["body_html"] }}</textarea>
                                        </div><!-- .panel -->

                                        <!-- ### SEO CONTENT ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> Variants</h3>
                                                <small style="float: left;margin: 2rem 0;">Select:</small>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-wrapper">
								                        <table id="all-products" class="table table-responsive" cellspacing="0" width="100%">
								                            <thead>
								                                <!-- <th><input type="checkbox" id="checkall" /></th> -->
                                                                <td>No.</td>
								                                <th></th>
                                                                @if(!empty($product["options"]))
                                                                    @foreach($product["options"] as $op => $option)
    								                                <th>{{$option["name"]}}</th>
                                                                    @endforeach
                                                                @endif
								                                <th>Inventory</th>
								                                <th>Price</th>
								                                <th>Sku</th>
								                                <th></th>
								                                <th></th>
								                           </thead>
								                           <tbody>
								                            @foreach($product["variants"] as $var => $variant)
								                                <tr>
                                                                    <input type="hidden" name="product[variants][{{$var}}][id]" value="{{$variant["id"]}}">
                                                                    <input type="hidden" name="product[variants][{{$var}}][src]" @if(array_key_exists($variant["image_id"],$images)) value="{{$images[$variant["image_id"]]}} " @else value=""@endif>
                                                                    <td>{{$var+1}}</td>
								                                    <!-- <td style="width: 25px; text-align: center;"><input type="checkbox" class="checkthis" /></td> -->
								                                    <td style="width: 90px;">
								                                        <a href="/product/edit/{{ $variant["id"] }}"><img class="product-img" @if(array_key_exists($variant["image_id"],$images)) src="{{$images[$variant["image_id"]]}} " @else src="/images/noimage.png" height="60px" @endif alt="{{ $variant["title"] }}" style="max-width: 70px;" /></a>
								                                    </td>
                                                                    @if(!empty($variant["option1"]))
								                                    <td><input type="text" class="form-control" name="product[variants][{{$var}}][option1]" value="{{ $variant["option1"] }}"></td>
                                                                    @endif
                                                                    @if(!empty($variant["option2"]))
								                                    <td><input type="text" class="form-control" name="product[variants][{{$var}}][option2]" value="{{ $variant["option2"] }}"></td>
                                                                    @endif
                                                                    @if(!empty($variant["option3"]))
                                                                    <td><input type="text" class="form-control" name="product[variants][{{$var}}][option3]" value="{{ $variant["option3"] }}"></td>
                                                                    @endif
                                                                    <td><input type="text" class="form-control" name="product[variants][{{$var}}][inventory_quantity]" value="{{ $variant["inventory_quantity"] }}"></td>
								                                    <td>
                                                                        <input type="text" name="product[variants][{{$var}}][price]" class="form-control" value="{{ $variant["price"] }}">
                                                                    </td>
								                                    <td><input type="text" class="form-control" name="product[variants][{{$var}}][sku]" value="{{ $variant["sku"] }}"></td>
								                                    <td style="text-align: right;"><a href="/product/edit/{{ $product["id"] }}"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></td>
								                                    <td><p data-placement="top" data-toggle="tooltip" title="Delete" style="margin:0;"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button></p></td>
								                                </tr>
								                            @endforeach
								                           </tbody>
								                        </table>
                                            	</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- ### DETAILS ### -->
                                        <div class="panel panel panel-bordered panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Organization</h3>
                                            </div>
                                            <div class="panel-body" id="organization">
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Product type</label>
                                                    <select id="product_type" name="product[product_type]" class="form-control"></select>
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Vendor</label>
                                                    <select id="vendor" name="product[vendor]" class="form-control"></select>
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Tags</label>
                                                    <select id="product_tags" name="product[tags][]" class="form-control" multiple="multiple"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ### IMAGE ### -->
                                        <div class="panel panel-bordered panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"></i> Post Image</h3>
                                            </div>
                                            <div class="panel-body">
                                            	@if(isset($product["image"]))
                                                    <img src="{{ $product["image"]["src"] }}" style="width: 100%;margin-bottom: 15px;" />
                                                @endif
                                                <input type="file" name="image">
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="btn-actions">
                                    <button class="btn btn-danger pull-left" onclick="window.history.back();">Cancel</button>
                                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>

<script id="product-variant-template" type="text/template">
    <h3>Modify the variants to be created:</h3>
    <div class="table-wrapper">
        <table class="table-responsive">
            <thead>
              <tr>
                <th>#</th>
                <th>Variant</th>
                <th>Price</th>
                <th>SKU</th>
                <th>Barcode</th>
              </tr>
            </thead>
            <tbody id="tbody-variant-record"></tbody>
        </table>
    </div>
</script>

<script id="variant-record-template" type="text/template">
    <tr>
        <td>#</td>
        <td><<title>></td>
        <td><input type="text" class="form-control" name="price"></td>
        <td><input type="text" class="form-control" name="sku"></td>
        <td><input type="text" class="form-control" name="barcode"></td>
    </tr>
</script>

    {!! HTML::script('assets/js/select2.min.js') !!}

<script>
    $(function() {
        CKEDITOR.replace( 'body_html' );

        var btn_remove_block = $("button[data-type=\"data-remove-variant\"]");
        var btn_add_block = $("#add-block-variant");

        var checkBtnAddBlock = function() {

            if($("#size_variants").css('display') !== 'none'
                && $("#color_variants").css('display') !== 'none'
                && $("#material_variants").css('display') !== 'none') {

                btn_add_block.hide();
                return;
            }

            btn_add_block.show();
        }

        var checkbtnRemoveblock = function() {

            return $(".block-variant").filter(function() {
                return $(this).css('display') !== 'none';
            }).length;
        }


        btn_add_block.click(function() {

            btn_remove_block.show();

            if($("#size_variants").css('display') === 'none') {
                $("#size").val('');
                $("#size_variants").show();
                checkBtnAddBlock();
                return;
            }

            if($("#color_variants").css('display') === 'none') {
                $("#color_variants").show();
                checkBtnAddBlock();
                return;
            }

            if($("#material_variants").css('display') === 'none') {
                $("#material_variants").show();
                checkBtnAddBlock();
                return;
            }


        });

        btn_remove_block.click(function(e) {

            var elm = $(this);
            var block = elm.parent(".col-content");
            var count_block = checkbtnRemoveblock();
            if(count_block == 2) btn_remove_block.hide();
            block.hide();
            btn_add_block.show();

            return;
        });

        //allow customer to purchase..
        $("#variant-inventory_policy").click(function(){
            if($(this).prop("checked") == true){
                $("#product_variant_inventory_policy").val("continue");
            }
            else if($(this).prop("checked") == false){
                $("#product_variant_inventory_policy").val("deny");
            }
        })

        //shipping
        $("#variant-requires_shipping").click(function(){
            if($(this).prop("checked") == true){
                $("#product_variant_requires_shipping").val("true");
                $(".shipping-content").show();
            }
            else if($(this).prop("checked") == false){
                $("#product_variant_requires_shipping").val("false");
                $(".shipping-content").hide();
            }
        })

        //customer policy
        $("#variant-inventory-management").change(function(){
            if($(this).val() == "shopify") {
                $("#product_variant_inventory_quantity").show();
                $("#check-inventory-policy").show();
            }
            else if($(this).val() !== "shopify") {
                $("#product_variant_inventory_quantity").hide();
                $("#check-inventory-policy").hide();
            }
        });

        var pro_type = [
            {
                id: "{{$product["product_type"]}}",
                text: "{{$product["product_type"]}}"
            }
        ];

        var vendor = [
            {
                id: "{{$product["vendor"]}}",
                text: "{{$product["vendor"]}}"
            }
        ];

        //var tags = [];
        // if($product["tags"].length > 0) {
        //     $($product["tags"].each(function(k,val) {

        //     });
        // }

        var tags = [
            {
                id: 0,
                text: 'enhancement'
            },
            {
                id: 1,
                text: 'bug'
            },
            {
                id: 2,
                text: 'duplicate'
            },
            {
                id: 3,
                text: 'invalid'
            },
            {
                id: 4,
                text: 'wontfix'
            }
        ];

        
        $("#product_type").select2({
            data: pro_type,
            multiple: false,
            tags: true
        });
        
        $("#vendor").select2({
            data: vendor,
            multiple: false,
            tags: true
        });
        
        $("#product_tags").select2({
            tags:["red", "green", "blue"],
        });

        $("#size").select2({
            placeholder: "Separate options with a comma",
            multiple: true,
            tags: true,
            tokenSeparators: [',', ' ']
        });

        $("#color").select2({
            placeholder: "Separate options with a comma",
            multiple: true,
            tags: true,
            tokenSeparators: [',', ' ']
        });

        $("#material").select2({
            placeholder: "Separate options with a comma",
            multiple: true,
            tags: true,
            tokenSeparators: [',', ' ']
        });
    });
</script>
@stop