<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site.name', config('app.name')) }}</title>

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcdn.net/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="https://cdn.bootcdn.net/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- <link rel="shortcut icon" type="image/icon" href="{{ asset() }}"> --}}
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
    <script>
        window.ADMIN_CONFIGS = {
            prefix: "{{ config('admin.route.prefix') }}",
            php_version: "{{ PHP_VERSION }}",
        };
    </script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('dist/js/app.js') }}"></script>
</body>
</html>
