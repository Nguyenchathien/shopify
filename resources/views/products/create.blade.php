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
                                <h3 class="box-title">Add product</h3>

                                <div class="box-tools">
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a href="/" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
                                    </div> 
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a class="btn btn-sm btn-default" onclick="window.history.back();history.back();"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(array('url'=>'/product/store', 'class'=>'form-horizontal', 'files' => true)) !!}
                                {{ csrf_field() }}
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
                                                <input type="text" class="form-control" name="product[title]" placeholder="Short Sleeve T-Shirt" value="" required>
                                            </div>
                                        </div>

                                        <!-- ### CONTENT ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading" style="padding-left: 0px;">
                                                <h3 class="panel-title"><i class="icon wb-book"></i> Description</h3>
                                            </div>
                                            <textarea class="form-control" name="product[body_html]" id="body_html" style="border:0px;"></textarea>
                                        </div><!-- .panel -->

                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> Inventory</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-content">
                                                    <div class="col-md-6" style="padding-left: 0;">
                                                        <label class="small-title" for="name">SKU (Stock Keeping Unit)</label>
                                                        <input type="text" class="form-control" name="product[variant][sku]" placeholder="Sku" value="">
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 0;">
                                                        <label class="small-title" for="name">Barcode (ISBN, UPC, GTIN, etc.)</label>
                                                        <input type="text" class="form-control" name="product[variant][barcode]" placeholder="Barcode" value="">
                                                    </div>
                                                </div>
                                                <div class="col-content">
                                                    <div class="col-md-6" style="padding-left: 0;">
                                                        <label class="small-title">Inventory policy</label>
                                                        <select class="form-control" name="product[variant][inventory_management]" id="variant-inventory-management">
                                                            <option>Don't track inventory</option>
                                                            <option value="shopify">Shopify tracks this product's inventory</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 0;display: none;" id="product_variant_inventory_quantity">
                                                        <label class="small-title" for="name">Quantity</label>
                                                        <input type="text" class="form-control" name="product[variant][inventory_quantity]" value="1">
                                                    </div>
                                                </div>
                                                <div class="col-content" id="check-inventory-policy" style="display: none;">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" id=variant-inventory_policy>Allow customers to purchase this product when it's out of stock</label>
                                                        <input type="hidden" name="product[variant][inventory_policy]" id="product_variant_inventory_policy" value="deny">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> Shipping</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-content">
                                                    <div class="checkbox" style="margin-top: -15px;margin-bottom: 5px;">
                                                        <label><input type="checkbox" value="" id="variant-requires_shipping">This product requires shipping</label>
                                                        <input type="hidden" name="product[variant][requires_shipping]" id="product_variant_requires_shipping" value="false">
                                                    </div>
                                                </div>
                                                <div class="shipping-content" style="display:none;">
                                                    <div class="line"></div>
                                                    <div class="col-md-6" style="padding-left: 0;">
                                                        <h3 class="ui-subheading">WEIGHT</h3>
                                                        <label class="small-title">Inventory policy</label>
                                                        <!-- <input type="text" class="form-control" name="product[variant][weight]" value=""> -->
                                                        <div class="input-group">
													      	<input type="text" class="form-control" name="product[variant][weight]" placeholder="0.0">
													      	<div class="input-group-addon1" style="display: table-cell">
																<select name="product[variant][weight_unit]" class="form-control" style="width:50px" autocomplete="off">
														            <option value="lb">lb</option>
														            <option value="oz">oz</option>
														            <option value="kg">kg</option>
														            <option value="g">g</option>
														        </select>
													      	</div>
													    </div>
                                                        <p class="type--subdued">Used to calculate shipping rates at checkout.</p>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 0;">
                                                        <h3 class="ui-subheading">INTERNATIONAL CUSTOMS</h3>
                                                        <label class="small-title" for="name">HS tariff code (look up code)</label>
                                                        <input type="text" class="form-control" name="product[variant][metafields_global_harmonized_system_code]" value="">
                                                    </div>
                                                </div>
                                                <div class="col-content">
                                                    <div class="line"></div>
                                                    <div class="col-md-6 pull-left" style="padding-left: 0;padding-top: 15px;">
                                                        <label class="small-title">FULFILLMENT SERVICE</label>
                                                        <select class="form-control" name="product[variant][fulfillment_service]">
                                                            <option selected="selected" value="manual">Manual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ### SEO CONTENT ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> Variants</h3>
                                                <small style="color: #637381; font-weight: 350; float: left;margin-top: 5px;margin-bottom: 20px;">Add variants if this product comes in multiple versions, like different sizes or colors.</small>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-content block-variant" id="size_variants">
                                                    <div class="col-md-3" style="padding-left: 0;">
                                                        <label class="small-title" for="name">Option name</label>
                                                        <input type="text" class="form-control" name="size" value="Size" >
                                                    </div>
                                                    <div class="col-md-8" style="padding-left: 0;">
                                                        <label class="small-title" for="name">Option values</label>
                                                        <select id="size" name="sizes[]" class="form-control" multiple></select>

                                                    </div>
                                                    <button type="button" data-type="data-remove-variant" class="btn btn-sm btn-danger pull-right" style="margin-top: 23px;display: none;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </div>

                                                <div class="col-content block-variant" id="color_variants" style="display: none;">
                                                    <div class="col-md-3" style="padding-left: 0;">
                                                        <input type="text" class="form-control" name="color" value="Color" >
                                                    </div>
                                                    <div class="col-md-8" style="padding-left: 0;">
                                                        <!-- <input type="text" class="form-control" name="size_value" placeholder="Separate options with a comma" value="" > -->
                                                        <select id="color" name="colors[]" class="form-control" multiple></select>
                                                    </div>
                                                    <button type="button" data-type="data-remove-variant" class="btn btn-sm btn-danger pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </div>

                                                <div class="col-content block-variant" id="material_variants" style="display: none;">
                                                    <div class="col-md-3" style="padding-left: 0;">
                                                        <input type="text" class="form-control" name="marterial" value="Material" >
                                                    </div>
                                                    <div class="col-md-8" style="padding-left: 0;">
                                                        <!-- <input type="text" class="form-control" name="size_value" placeholder="Separate options with a comma" value="" > -->
                                                        <select id="material" name="materials[]" class="form-control" multiple></select>
                                                    </div>
                                                    <button type="button" data-type="data-remove-variant" class="btn btn-sm btn-danger pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </div>

                                                <div class="col-md-12" style="margin: 15px 0px;padding-left: 0px;">
                                                    <a class="btn btn-default" id="add-block-variant"><i class="fa fa-plus"></i>&nbsp;Add another option</a>
                                                </div>
                                                <div class="col-md-12" id="variants-list">
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ### SEO CONTENT ### -->
                                        <!-- <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> SEO Content</h3>
                                            </div>
                                            <div class="panel-body">
												<div class="col-content">
                                                    <label class="small-title" for="name">Page title <small class="pull-right notication">Maximum are 70 characters</small></label>
                                                    <input type="text" class="form-control" name="page_title" placeholder="Page Title" value="" maxlength="70">
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Meta Description <small class="pull-right notication" maxlength="160">Maximum are 160 characters</small></label>
                                                    <textarea class="form-control" name="meta_description"></textarea>
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">URL and handle</label>
													<input type="text" class="form-control" name="handle" placeholder="URL and handle" value="">
                                                </div>
                                            </div>
                                        </div> -->
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
													<select id="tags" name="product[tags][]" class="form-control" multiple></select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ### PRICE ### -->
                                        <div class="panel panel panel-bordered panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pricing</h3>
                                            </div>
                                            <div class="panel-body" id="price">
												<div class="col-content">
	                                            	<label class="small-title">Price</label>
	                                                <input type="text" class="form-control" name="product[variant][price]" placeholder="Price" value="">
	                                            </div>
	                                            <div class="col-content">
	                                            	<label class="small-title">Compare at price</label>
	                                                <input type="text" class="form-control" name="product[variant][compare_at_price]" placeholder="Compare at price" value="">
	                                            </div>
                                                <div class="col-content">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="">Charge taxes on this product</label>
                                                        <input type="hidden" name="product[variant][taxable]" id="product_variant_taxable" value="true" data-bind="taxable">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .panel -->

                                        <!-- ### IMAGE ### -->
                                        <div class="panel panel-bordered panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"></i> Post Image</h3>
                                            </div>
                                            <div class="panel-body">
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
        })

        $("#product_type").select2({
            placeholder: "Choose product type...",
            multiple: false,
            tags: true
        });
		
		$("#vendor").select2({
            placeholder: "Choose vendor...",
            multiple: false,
            tags: true
        });
		
		$("#tags").select2({
            placeholder: "Choose tags...",
            multiple: true,
            tags: true,
			tokenSeparators: [',', ' ']
        });

        $('#size').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data);
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

        //Here you add the bottom pixels you need. I added 200px.
        // $('.select2-selection__rendered').css({top:'200px',position:'relative'});
	});
</script>
@stop