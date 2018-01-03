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
                                <h3 class="box-title">Edit variant</h3>
                                <div class="box-tools">
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a href="/" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
                                    </div> 
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a class="btn btn-sm btn-default" onclick="window.history.back();history.back();"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                                    </div>
                                </div>
                            </div>
							<div class="box-body">
								<div class="col-md-4">
									<div class="panel">
										@if (count($errors) > 0)
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
										<div class="panel-body" style="position: relative">
											@if(isset($product["image"]))
												<img src="{{ $product["image"]["src"] }}" style="max-width: 90px;" />
											@else
												<img src="/images/noimage.png" height="60px" />
											@endif
											<p class="product_type">{{ $product["title"] }}</p>
											<p class="product_count_variant">
											@if(count($product["variants"]) > 0)
												{{ count($product["variants"]) }} variants
											@endif
											</p>
											<p class="product_list">
												<a href="/product/edit/{{ $product["id"] }}">Back to product</a>
											</p>
										</div>
									</div>

									<!-- ### CONTENT ### -->
									<div class="panel">
										<div class="panel-heading" style="padding: 0px 15px 15px 15px">
											<h3 class="panel-title"><i class="icon wb-book"></i> Variants</h3>
										</div>
										<div class="panel-body" style="padding: 0px;">
											@if(!empty($product["variants"]))
											<ul class="variants-list">
												@foreach($product["variants"] as $var => $_variant)
												<a href="{{ route('variant.edit', ['product_id' => $product["id"], 'variant_id' => $_variant["id"]]) }}">
													<li @if(Request::segment(4) == $_variant["id"]) class="active" @endif >
														<img class="product-img" @if(array_key_exists($_variant["image_id"],$images)) src="{{$images[$_variant["image_id"]]}} " @else src="/images/no_image.png" height="" @endif alt="{{ $_variant["title"] }}" style="max-width: 70px;" />
														{{$_variant["title"]}}
													</li>
												</a>
												@endforeach
											</ul>
											@endif
										</div>
									</div><!-- .panel -->
								</div>
								{!! Form::model($variant, array('url'=>'variant/update/' . $variant["id"], 'class'=>'form-horizontal', 'files' => true, 'method'=>'PUT')) !!}
								{{ csrf_field() }}
                                <input type="hidden" name="variant[id]" value="{{ $variant["id"] }}">
                                <input type="hidden" name="variant[title]" value="{{ $variant["title"] }}">
                                <input type="hidden" name="image_id" value="{{$variant["image_id"] }}">
                                <input type="hidden" name="product_id" value="{{ $product["id"] }}">
                                <div class="col-md-8">
									<!-- ### CONTENT ### -->
									<div class="panel">
										<div class="panel-heading" style="padding: 0px 15px 15px 15px">
											<h3 class="panel-title"><i class="icon wb-book"></i> Options</h3>
										</div>
										<div class="panel-body">
											<div class="col-md-7">
												@foreach($product["options"] as $opt_key => $opt_val)
												@php $key =  $opt_key + 1 @endphp
												<div class="form-group">
													<label class="small-title">{{ $opt_val["name"] }}:</label>
													<input type="text" class="form-control" name="variant[option{{$key}}]" value="{{ $variant["option$key"] }}">
												</div>
												@endforeach
											</div>
										
											<div class="col-md-5" style="text-align: center;">
												<img class="product-img" @if(array_key_exists($variant["image_id"],$images)) src="{{$images[$variant["image_id"]]}} " @else src="/images/noimage.png" @endif alt="{{ $variant["title"] }}" style="max-width: 100%;margin-bottom: 15px;" />
                                                <input type="file" name="image">
											</div>
										</div>
									</div><!-- .panel -->
									
									<div class="panel" style="padding: 0px 15px 15px 15px">
										<div class="panel-heading">
											<h3 class="panel-title"> Pricing</h3>
										</div>
										<div class="panel-body">
											<div class="col-content">
												<div class="col-md-6" style="padding-left: 0;">
													<label class="small-title" for="name">Pricing</label>
													<input type="text" class="form-control" name="variant[price]" placeholder="0" value="{{ $variant["price"] }}">
												</div>
												<div class="col-md-6">
													<label class="small-title" for="name">Compare at price</label>
													<input type="text" class="form-control" name="variant[compare_at_price]" placeholder="0" value="{{ $variant["compare_at_price"] }}">
												</div>
											</div>
											<div class="col-content">
												<div class="checkbox">
													<label><input type="checkbox" id="product-variant_taxable" @if($variant["taxable"] == true) checked @endif>Charge taxes on this product</label>
													<input type="hidden" name="variant[taxable]" id="product_variant_taxable" value="true">
												</div>
											</div>
										</div>
									</div><!---end pricing-->
									
									<div class="panel" style="padding: 0px 15px 15px 15px">
										<div class="panel-heading">
											<h3 class="panel-title"> Inventory</h3>
										</div>
										<div class="panel-body">
											<div class="col-content">
												<div class="col-md-6" style="padding-left: 0;">
													<label class="small-title" for="name">SKU (Stock Keeping Unit)</label>
													<input type="text" class="form-control" name="variant[sku]" placeholder="Sku" value="{{$variant["sku"]}}">
												</div>
												<div class="col-md-6">
													<label class="small-title" for="name">Barcode (ISBN, UPC, GTIN, etc.)</label>
													<input type="text" class="form-control" name="variant[barcode]" placeholder="Barcode" value="{{$variant["barcode"]}}">
												</div>
											</div>
											<div class="col-content">
												<div class="col-md-6" style="padding-left: 0;">
													<label class="small-title">Inventory policy</label>
													<select class="form-control" name="variant[inventory_management]" id="variant-inventory-management">
														<option @if($variant["inventory_management"] == "") selected @endif>Don't track inventory</option>
														<option @if($variant["inventory_management"] == "shopify") selected @endif value="shopify">Shopify tracks this product's inventory</option>
													</select>
												</div>
												<div class="col-md-6" @if($variant["inventory_management"] !== "shopify") style="padding-left: 0;display: none;" @endif id="product_variant_inventory_quantity">
													<label class="small-title" for="name">Quantity</label>
													<input type="text" class="form-control" name="variant[inventory_quantity]" value="{{ $variant["inventory_quantity"] }}">
												</div>
											</div>
											<div class="col-content" id="check-inventory-policy" @if($variant["inventory_management"] !== "shopify") style="padding-left: 0;display: none;" @endif >
												<div class="checkbox">
													<label><input type="checkbox" @if($variant["inventory_policy"] === "continue") checked @endif id="variant-inventory_policy">Allow customers to purchase this product when it's out of stock</label>
													<input type="hidden" name="variant[inventory_policy]" id="product_variant_inventory_policy" @if($variant["inventory_policy"] === "continue") value="continue" @else value="deny" @endif>
												</div>
											</div>
										</div>
									</div><!---end inventory-->

                                    <div class="panel" style="padding: 0px 15px 15px 15px">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"> Shipping</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-content">
                                                <div class="checkbox" style="margin-top: -15px;margin-bottom: 5px;">
                                                    <label><input type="checkbox" value="" id="variant-requires_shipping" @if($variant["requires_shipping"] == true) checked="checked" @endif>This product requires shipping</label>
                                                    <input type="hidden" name="variant[requires_shipping]" id="product_variant_requires_shipping" @if($variant["requires_shipping"] == true)  value="true" @endif>
                                                </div>
                                            </div>
                                            <div class="shipping-content" @if($variant["requires_shipping"] !== true) style="display:none;" @endif>
                                                <div class="line"></div>
                                                <div class="col-md-6" style="padding-left: 0;">
                                                    <h3 class="ui-subheading">WEIGHT</h3>
                                                    <label class="small-title">Inventory policy</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="variant[weight]" placeholder="0.0" value="{{$variant["weight"]}}">
                                                        <div class="input-group-addon1" style="display: table-cell">
                                                            <select name="variant[weight_unit]" class="form-control" style="width:50px" autocomplete="off">
                                                                <option value="lb" @if($variant["weight_unit"] == 'lb') selected="selected" @endif>lb</option>
                                                                <option value="oz" @if($variant["weight_unit"] == 'oz') selected="selected" @endif>oz</option>
                                                                <option value="kg" @if($variant["weight_unit"] == 'kg') selected="selected" @endif>kg</option>
                                                                <option value="g" @if($variant["weight_unit"]  == 'g')  selected="selected" @endif>g</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <p class="type--subdued">Used to calculate shipping rates at checkout.</p>
                                                </div>
                                                <div class="col-md-6" style="padding-left: 0;">
                                                    <h3 class="ui-subheading">INTERNATIONAL CUSTOMS</h3>
                                                    <label class="small-title" for="name">HS tariff code <a href="http://hts.usitc.gov/" target="_blank">(look up code)</a></label>
                                                    <input type="text" class="form-control" name="variant[metafields_global_harmonized_system_code]" value="">
                                                </div>
                                            </div>
                                            <div class="col-content">
                                                <div class="line"></div>
                                                <div class="col-md-6 pull-left" style="padding-left: 0;padding-top: 15px;">
                                                    <label class="small-title">FULFILLMENT SERVICE</label>
                                                    <select class="form-control" name="variant[fulfillment_service]">
                                                        <option @if($variant["fulfillment_service"] == 'manual') selected="selected" @endif value="manual">Manual</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!---end shipping-->
                                    <div class="">
                                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                    </div>
                                </div>
								{!! Form::close() !!}  
								<div class="clearfix"></div>
							</div>
							<button class="btn btn-danger pull-left" onclick="window.history.back();" style="margin-top: -45px;margin-left: 25px;"><i class="fa fa-close"></i> Cancel</button>
							
                            <!--<button class="btn btn-danger pull-left btn-remove-variant" style="margin-top: -45px;margin-left: 25px;" data-product-id="{{ $product["id"] }}" data-variant-id="{{ $variant["id"] }}" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Variant</button>-->
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>

<div class="modal modal-danger fade" tabindex="-1" id="deleteModal" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h2 class="modal-title">Delete variant?</h2>
            </div>
            <div class="modal-body">
                <p><i class="voyager-trash"></i> Deleted variant cannot be recovered. Do you still want to continue?</p>  
            </div>
            <div class="modal-footer">
                <form id="delete_form">
                    <input type="button" class="btn btn-danger pull-right delete-confirm" value="Yes, Delete it!">
                </form>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

{!! HTML::script('assets/js/select2.min.js') !!}
<script>
    $(function() {
        
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

        //taxable
        $("#product-variant_taxable").click(function(){
            if($(this).prop("checked") == true){
                $("#product_variant_taxable").val("true");
            }
            else if($(this).prop("checked") == false){
                $("#product_variant_taxable").val("false");
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

        //remove
        $(".btn-remove-variant").click(function(e) {

            var product_id=$(this).attr("data-product-id");
            var variant_id=$(this).attr("data-variant-id");
            $(".delete-confirm").click(function(e) {
                $.ajax({
                    url: "/product/" + product_id +"/variant/destroy/" + variant_id,
                    type:"POST",
                    dataType: 'json',
                    data: { product_id : product_id, variant_id : variant_id},
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function(res) {
						console.log(res);
                        if(res["status"] === "YES" ) {

                            document.location.href="/";
                            $('#deleteModal').modal('hide');
                            toastr.success('Product variant was successfully deleted');
                        }
                    },
                    error: function( data ) {
                        if ( data["status"] === "NO" ) {
                            toastr.error('Cannot delete the product variant');
                            $('#deleteModal').modal('hide');
                        }
                    }
                });
            });
        });

        $("#product_type").select2({
            multiple: false,
            tags: true
        });
        
        $("#vendor").select2({
            multiple: false,
            tags: true
        });
        
        $("#product_tags").select2({
            multiple: true,
            tags: true,
            tokenSeparators: [',', ' ']
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