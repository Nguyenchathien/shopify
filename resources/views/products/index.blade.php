@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="products-index">
                <header class="title">
                    <div class="ui-title-bar">
                        <h1>Products</h1>
                        <a href="/product/create" class="btn btn-primary btn-add">Add product</a>
                    </div>
                </header>
                <div class="product-content">
                    <div class="filter">
                        <div class="filter-title"><h3>All products</h3></div>
                    </div>
                    <div class="table-responsive products-results col-md-12">
                        {{ csrf_field() }}
                        <table id="all-products" class="table table-bordred table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <th><input type="checkbox" id="checkall" /></th>
                                <th></th>
                                <th>Product</th>
                                <th>Inventory</th>
                                <th>Type</th>
                                <th>Vendor</th>
                                <th></th>
                                <th></th>
                           </thead>
                           <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td style="width: 25px; text-align: center;"><input type="checkbox" class="checkthis" /></td>
                                    <td style="width: 90px;">
                                        <a href="/product/edit/{{ $product["id"] }}"><img class="product-img" @if($product["image"]["src"]) src="{{ $product["image"]["src"] }} " @else src="/images/noimage.png" height="50px" @endif alt="{{ $product["title"] }}" style="max-width: 70px;"/></a>
                                        <!-- <span class="product-name">{{ $product["title"] }}</span></a> -->
                                    </td>
                                    <td><a href="/product/edit/{{ $product["id"] }}">{{ $product["title"] }}</a></td>
                                    <td>
										@if($product["variants"][0]["old_inventory_quantity"] > 1 )
											{{ $product["variants"][0]["old_inventory_quantity"] }} in stock for {{ count($product["variants"]) }} variants
										@else
											N/A
										@endif
									
									</td>
                                    <td>{{ $product["product_type"] }}</td>
                                    <td>{{ $product["vendor"] }}</td>
                                    <td style="text-align: right;"><a href="/product/edit/{{ $product["id"] }}"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></td>
                                    <td><p data-placement="top" data-toggle="tooltip" title="Delete" style="margin: 0px;"><button class="btn btn-danger btn-xs btn-remove-product" data-title="Delete" data-toggle="modal" data-target="#delete" data-product-id="{{ $product["id"] }}"><span class="glyphicon glyphicon-trash"></span></button></p></td>
                                </tr>
                            @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-danger fade" tabindex="-1" id="delete" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="voyager-trash"></i> Deleted products cannot be recovered. Do you still want to continue?</h4>
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

<script type="text/javascript">
    $(function() {

        $('#all-products').DataTable({
            "columnDefs": [
               { 
                    "orderable": false, 
                    "targets": [0, 1, 6, 7], 
                }
            ]
        });

        $("#all-products #checkall").click(function () {
            if ($("#all-products #checkall").is(':checked')) {
                $("#all-products input[type=checkbox]").each(function () {
                    $(this).prop("checked", true);
                });

            } else {
                $("#all-products input[type=checkbox]").each(function () {
                    $(this).prop("checked", false);
                });
            }
        });

        //remove
        $(".btn-remove-product").click(function(e) {
            var product_id=$(this).attr("data-product-id");
            console.log(product_id);
            $(document).on("click", ".delete-confirm", function(e) {
                $.ajax({
                    url: "{{ route('product.destroy') }}",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();

                        if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: { id : product_id },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        // $('#remove').modal('hide');
                        // elm.parents(".comment").first().remove();
                    }
                });
            });
        });
            
            // $("[data-toggle=tooltip]").tooltip();
	});

</script>

@endsection
