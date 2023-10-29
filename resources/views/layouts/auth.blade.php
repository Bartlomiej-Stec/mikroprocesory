<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Bartłomiej Stec">
    <title>Zarządzanie mikrokontrolerem</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/sign-in.css')}}" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        @yield('content')
    </main>
    <script src="{{asset('dist/js/bootstrap.bundle.min.js')}}"></script>

</body>

</html>
