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
                                        <a href="/admin/post" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
                                    </div> 
                                    <div class="btn-group pull-right" style="margin-right: 10px">
                                        <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(array('url'=>'/product/store', 'class'=>'form-horizontal', 'files' => true)) !!}
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="col-md-8">
                                        <!-- ### TITLE ### -->
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

                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <span class="panel-desc"> Title</span>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <input type="text" class="form-control" name="title" placeholder="Short Sleeve T-Shirt" value="">
                                            </div>
                                        </div>

                                        <!-- ### CONTENT ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading" style="padding-left: 0px;">
                                                <h3 class="panel-title"><i class="icon wb-book"></i> Description</h3>
                                            </div>
                                            <textarea class="form-control" name="body_html" style="border:0px;"></textarea>
                                        </div><!-- .panel -->

                                        <!-- ### SEO CONTENT ### -->
                                        <div class="panel" style="padding: 0px 15px 15px 15px">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="icon wb-search"></i> SEO Content</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Meta Description</label>
                                                    <textarea class="form-control" name="meta_description"></textarea>
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Meta Keywords</label>
                                                    <textarea class="form-control" name="meta_keywords"></textarea>
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Seo Title</label>
                                                    <input type="text" class="form-control" name="seo_title" placeholder="SEO Title" value="">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <!-- ### DETAILS ### -->
                                        <div class="panel panel panel-bordered panel-warning">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Organization</h3>
                                            </div>
                                            <div class="panel-body" id="organization">
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Product type</label>
                                                    <select id="product_type" name="product_type[]" class="form-control" multiple></select>
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Vendor</label>
                                                    <input type="input" name="vendor" class="form-control">
                                                </div>
                                                <div class="col-content">
                                                    <label class="small-title" for="name">Tags</label>
                                                    <input type="input" name="tag[]" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ### PRICE ### -->
                                        <div class="panel panel panel-bordered panel-warning">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pricing</h3>
                                            </div>
                                            <div class="panel-body" id="price">
												<div class="col-content">
	                                            	<label class="small-title">Price</label>
	                                                <input type="text" class="form-control" name="price" placeholder="Price" value="">
	                                            </div>
	                                            <div class="col-content">
	                                            	<label class="small-title">Compare at price</label>
	                                                <input type="text" class="form-control" name="compare_price" placeholder="Compare at price" value="">
	                                            </div>
                                            </div>
                                        </div><!-- .panel -->

                                        <!-- ### PRICE ### -->
                                        <div class="panel panel panel-bordered panel-warning">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Inventory</h3>
                                            </div>
                                            <div class="panel-body" id="inventory">
												<div class="col-content">
	                                            	<label class="small-title">SKU (Stock Keeping Unit)</label>
	                                                <input type="text" class="form-control" name="sku" placeholder="Sku" value="">
	                                            </div>
	                                            <div class="col-content">
	                                            	<label class="small-title">Barcode (ISBN, UPC, GTIN, etc.)</label>
	                                                <input type="text" class="form-control" name="barcode" placeholder="Barcode" value="">
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
                                    <button type="submit" class="btn btn-danger pull-left">Cancel</button>
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
<script>
    
        CKEDITOR.replace( 'body_html' );

        $('#product_type').select2({
            placeholder: "Choose tags...",
            minimumInputLength: 2,
            ajax: {
                url: '/tags/find',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
</script>
@stop