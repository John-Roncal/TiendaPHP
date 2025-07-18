<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema POS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">POS Abarrotes</a>
            <a class="nav-link text-white" href="/productos">Productos</a>
            <a class="nav-link text-white" href="/categorias">Categorías</a>
            <a class="nav-link text-white" href="/venta">Ventas</a>
        </div>
    </nav>
    @yield('content')
</body>
</html>