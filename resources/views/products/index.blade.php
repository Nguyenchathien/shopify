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
                        <div class="filter-title"><h3>All</h3></div>
                        <div class="filter-search">
                            <div class="col-md-12">
                                <div class="input-group" id="adv-search">
                                    <input type="text" class="form-control" placeholder="Search for products" />
                                    <div class="input-group-btn">
                                        <div class="btn-group" role="group">
                                            <div class="dropdown dropdown-lg">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <form class="form-horizontal" role="form">
                                                        <div class="form-group">
                                                            <label for="filter">Filter by</label>
                                                            <select class="form-control">
                                                                <option value="0" selected>All Snippets</option>
                                                                <option value="1">Featured</option>
                                                                <option value="2">Most popular</option>
                                                                <option value="3">Top rated</option>
                                                                <option value="4">Most commented</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="contain">Author</label>
                                                            <input class="form-control" type="text" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="contain">Contains the words</label>
                                                            <input class="form-control" type="text" />
                                                        </div>
                                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                                    </form>
                                                </div>
                                            <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                    <div class="table-responsive products-results col-md-12">
                        <table id="all-products" class="table table-bordred table-striped">
                            <thead>
                                <th><input type="checkbox" id="checkall" /></th>
                                <th>Product</th>
                                <th>Inventory</th>
                                <th>Type</th>
                                <th>Vendor</th>
                                <th>Edit</th>
                                <th>Delete</th>
                           </thead>
                           <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td><input type="checkbox" class="checkthis" /></td>
                                    <td>
                                        <a href=""><img class="product-img" src="{{ $product["image"]["src"] }}" alt="{{ $product["title"] }}" />
                                        <span class="product-name">{{ $product["title"] }}</span></a>
                                    </td>
                                    <td>Irshad</td>
                                    <td>Pakistan</td>
                                    <td>{{ $product["vendor"] }}</td>
                                    <td><a href="/product/edit/{{ $product["id"] }}"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></td>
                                    <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
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
            
    
    <script type="text/javascript">
    $(document).ready(function(){
        $("#mytable #checkall").click(function () {
                if ($("#mytable #checkall").is(':checked')) {
                    $("#mytable input[type=checkbox]").each(function () {
                        $(this).prop("checked", true);
                    });

                } else {
                    $("#mytable input[type=checkbox]").each(function () {
                        $(this).prop("checked", false);
                    });
                }
            });
            
            // $("[data-toggle=tooltip]").tooltip();
        });

    </script>
@endsection
