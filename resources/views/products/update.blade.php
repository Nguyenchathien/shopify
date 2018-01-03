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
                                <input type="hidden" name="image_id" @if(isset($product["image"]["id"])) value="{{ $product["image"]["id"] }}" @endif>
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
                                                <!--<small style="float: left;margin: 2rem 0;">Select:</small>-->
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-wrapper table-responsive dataTables_wrapper">
													<table id="all-products" class="table dataTable table-striped" cellspacing="0" width="100%">
														<thead>
															<!-- <th><input type="checkbox" id="checkall" /></th> -->
															<td style="padding: 10px 2px;">No.</td>
															<th></th>
															@if(!empty($product["options"]))
																@foreach($product["options"] as $opt => $option)
																<th>{{$option["name"]}}</th>
																@endforeach
															@endif
															<th>Inventory</th>
															<th>Price</th>
															<th>Sku</th>
															<th>Edit</th>
															<!--<th></th>-->
													   </thead>
													   <tbody>
														@foreach($product["variants"] as $var => $variant)
															<tr data-id="{{$variant["id"]}}">
																<input type="hidden" name="product[variants][{{$var}}][id]" value="{{$variant["id"]}}">
																@if(!empty($variant["image_id"]))
																<input type="hidden" name="product[variants][{{$var}}][image_id]" value="{{ $variant["image_id"] }}" >
																<input type="hidden" name="product[images][{{$var+1}}][id]" value="{{ $variant["image_id"] }}" >
																@endif
																<td>{{$var+1}}</td>
																<!-- <td style="width: 25px; text-align: center;"><input type="checkbox" class="checkthis" /></td> -->
																<td style="width: 90px; text-align: center;">
																	<img class="product-img" @if(array_key_exists($variant["image_id"],$images)) src="{{$images[$variant["image_id"]]}} " @else src="/images/no_image.png" height="45px" @endif alt="{{ $variant["title"] }}" style="max-width: 70px;" />
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
																<td style="text-align: center;padding-right: 0px;"><a href="{{ route('variant.edit', ['product_id' => $product["id"], 'variant_id' => $variant["id"]]) }}"><i class="fa fa-edit"></i></a></td>
																<!--<td><a data-toggle="modal" href="#deleteModal" data-product-id="{{$product["id"]}}" data-variant-id="{{$variant["id"]}}" class="grid-row-delete"><i class="fa fa-trash"></i></a></td>-->
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
                                                    <select id="product_tags" name="product[tags][]" class="form-control" multiple="multiple">
														@if (!empty($product["tags"]))
															@foreach(explode(',', $product["tags"]) as $tag) 
																<option selected>{{$tag}}</option>
															@endforeach
														@endif
													</select>
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
                                    <a class="btn btn-danger btn-remove-product pull-left" data-toggle="modal" href="#deleteModal" data-title="Delete" data-product-id="{{ $product["id"] }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete product</a>
                                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                </div>
                            {!! Form::close() !!}
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
                <h2 class="modal-title">Delete product?</h2>
            </div>
            <div class="modal-body">
                <p><i class="voyager-trash"></i> Deleted products cannot be recovered. Do you still want to continue?</p>  
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
        CKEDITOR.replace( 'body_html' );

        function stopRKey(evt) { 
            var evt = (evt) ? evt : ((event) ? event : null); 
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
        } 

        document.onkeypress = stopRKey;

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

        //remove
        $(".btn-remove-product").click(function(e) {

            var product_id=$(this).attr("data-product-id");
            $(".delete-confirm").click(function(e) {
                $.ajax({
                    url: "/product/destroy/" + product_id,
                    type:"GET",
                    dataType: 'json',
                    data: { id : product_id },
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function(res) {
                        if(res["status"] === "YES" ) {

                            document.location.href="/";
                            $('#deleteModal').modal('hide');
                            toastr.success('Product was successfully deleted');
                        }
                    },
                    error: function( data ) {
                        if ( data["status"] === "NO" ) {
                            toastr.error('Cannot delete the category');
                            $('#deleteModal').modal('hide');
                        }
                    }
                });
            });
        });
		
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

        //remove
        $(".grid-row-delete").click(function(e) {
            var product_id=$(this).attr("data-product-id");
            var variant_id=$(this).attr("data-variant-id");
            $(".delete-confirm").click(function(e) {
                $.ajax({
                    url: "/product/" + product_id + "/variant/destroy/" + variant_id,
                    type:"GET",
                    dataType: 'json',
                    data: { product_id : product_id , variant_id : variant_id},
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function(res) {

                        console.log(res);


                        // if(res["status"] === "YES" ) {

                        //     var tr = $("#all-products").find("tr[data-id=" + product_id + "]");
                        //     tr.remove();
                        //     $('#deleteModal').modal('hide');
                        //     toastr.success('Product was successfully deleted');
                        // }
                    },
                    error: function( data ) {
                        if ( data["status"] === "NO" ) {
                            toastr.error('Cannot delete the category');
                            $('#deleteModal').modal('hide');
                        }
                    }
                });
            });
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