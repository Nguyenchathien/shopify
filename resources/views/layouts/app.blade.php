<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Products</title>

        <!-- Compiled and minified CSS -->
		{!! HTML::style('assets/css/bootstrap.min.css') !!}
		{!! HTML::style('assets/css/style.css') !!}
		{!! HTML::style('assets/css/font-awesome.min.css') !!}
		{!! HTML::style('assets/css/select2.min.css') !!}
		{!! HTML::style('assets/css/toastr.min.css') !!}
		{!! HTML::style('///cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css') !!}

		<!-- Compiled and minified JavaScript -->
		{!! HTML::script('assets/js/jquery-3.2.1.min.js') !!}
		{!! HTML::script('assets/ckeditor/ckeditor.js') !!}
		{!! HTML::script('assets/js/bootstrap.min.js') !!}
		{!! HTML::script('assets/js/select2.full.js') !!}
		{!! HTML::script('assets/js/jquery.min.js') !!}
		{!! HTML::script('assets/js/toastr.min.js') !!}
		{!! HTML::script('//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js') !!}
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

    </head>
    <body>
        <div class="app-container">
            <div class="content-container">
                <!-- Main Content -->
                <div class="container-fluid">
                    <div class="side-body padding-top">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>

	<script type="text/javascript">

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
		
		@if(Session::has('message'))
			var type = "{{ Session::get('alert-type', 'info') }}";
			switch(type){
				case 'info':
					toastr.info("{{ Session::get('message') }}");
					break;
				
				case 'warning':
					toastr.warning("{{ Session::get('message') }}");
					break;

				case 'success':
					toastr.success("{{ Session::get('message') }}");
					break;

				case 'error':
					toastr.error("{{ Session::get('message') }}");
					break;
			}
		@endif
		
    </script>
	@yield('scripts')
</html>
