<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Caja Registradora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Caja Registradora</h2>
    <div class="mb-3">
        <input type="text" id="inputBuscar" class="form-control" placeholder="Escanea o escribe el código/nombre del producto">
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="tablaVenta"></tbody>
    </table>

    <div class="text-end mb-3">
        <h4>Total: S/ <span id="totalVenta">0.00</span></h4>
        <button class="btn btn-success" id="btnRegistrarVenta">Registrar Venta</button>
    </div>
</div>
<script>
    let productos = [];
    let carrito = [];

    // Buscar productos al escribir
    document.getElementById('inputBuscar').addEventListener('keyup', async (e) => {
        if (e.key === 'Enter') {
            const termino = e.target.value.trim();
            const producto = productos.find(p =>
                p.codigo_barras === termino || p.nombre.toLowerCase().includes(termino.toLowerCase())
            );
            if (producto) agregarProductoAlCarrito(producto);
            e.target.value = '';
        }
    });

    // Cargar productos desde backend
    async function cargarProductos() {
        const res = await fetch('/api/productos');
        productos = await res.json();
    }

    // Agregar producto al carrito
    function agregarProductoAlCarrito(producto) {
        const existente = carrito.find(p => p.id === producto.id);
        const precioNum = Number(producto.precio);

        if (existente) {
            existente.cantidad++;
            existente.subtotal = existente.cantidad * precioNum;
        } else {
            carrito.push({
                id: producto.id,
                nombre: producto.nombre,
                precio: precioNum,
                cantidad: 1,
                subtotal: precioNum
            });
        }

        renderTabla();
    }

    function renderTabla() {
        const cuerpo = document.getElementById('tablaVenta');
        cuerpo.innerHTML = '';
        let total = 0;

        carrito.forEach((item, index) => {
            total += item.subtotal;
            cuerpo.innerHTML += `
                <tr>
                    <td>${item.nombre}</td>
                    <td>${item.precio.toFixed(2)}</td>
                    <td>${item.cantidad}</td>
                    <td>${item.subtotal.toFixed(2)}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="eliminar(${index})">X</button></td>
                </tr>
            `;
        });

        document.getElementById('totalVenta').textContent = total.toFixed(2);
    }

    function eliminar(index) {
        carrito.splice(index, 1);
        renderTabla();
    }

    // Registrar venta
    document.getElementById('btnRegistrarVenta').addEventListener('click', async () => {
        if (carrito.length === 0) return alert('No hay productos');

        const data = {
            productos: carrito.map(item => ({
                producto_id: item.id,
                cantidad: item.cantidad
            }))
        };

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const res = await fetch('/ventas/registrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        });

        if (res.ok) {
            // Guardar la última venta para imprimir
            const total = carrito.reduce((sum, item) => sum + item.subtotal, 0);
            const venta = {
                detalles: carrito,
                total: total
            };
            localStorage.setItem('ultimaVenta', JSON.stringify(venta));

            alert('Venta registrada exitosamente');
            imprimirTicket(); // Llamar impresión
            carrito = [];
            renderTabla();
        } else {
            const err = await res.json();
            alert('Error: ' + (err.error ?? 'Algo falló'));
        }
    });

    cargarProductos();

    // Función de impresión
    function imprimirTicket() {
        const venta = JSON.parse(localStorage.getItem('ultimaVenta'));

        if (!venta) {
            alert("No hay venta reciente para imprimir.");
            return;
        }

        let contenido = `
            <div style="font-family: monospace; font-size: 12px;">
                <h3>🛒 TICKET DE VENTA</h3>
                <p>Fecha: ${new Date().toLocaleString()}</p>
                <hr>
        `;

        venta.detalles.forEach(item => {
            contenido += `<p>${item.nombre} x${item.cantidad} - S/ ${item.precio.toFixed(2)}</p>`;
        });

        contenido += `
                <hr>
                <p><strong>Total: S/ ${venta.total.toFixed(2)}</strong></p>
                <p>¡Gracias por su compra!</p>
            </div>
        `;

        const ventana = window.open('', '', 'width=300,height=500');
        ventana.document.write(contenido);
        ventana.document.close();
        ventana.focus();
        ventana.print();
        ventana.close();
    }
</script>
</body>
</html>