<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Products</title>

        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/select2.min.css"/>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

        <!-- Compiled and minified JavaScript -->
        <script src="/js/jquery.min.js"></script>
        <script src="/ckeditor/ckeditor.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/select2.min.js"></script>
    </head>
    <body>
        <div class="app-container">
            <div class="row content-container">
                <!-- Main Content -->
                <div class="container-fluid">
                    <div class="side-body padding-top">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
