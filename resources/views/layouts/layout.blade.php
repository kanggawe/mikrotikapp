<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Tambahkan Bootstrap jika diperlukan -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">@yield('header', 'Customer Management')</h1>
        @yield('content')
    </div>
</body>
</html>
