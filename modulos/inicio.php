<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Inventario</title>
  <link rel="stylesheet" href="/VERTEX-INV/modulos/estilos/inicio.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


</head>

<body>
  <div class="grid">

    <div class="card-inventario" data-page="productos">
      <i class="bi bi-grid"></i>
      <div>
        <p class="card-title">Productos</p>
      </div>
    </div>

    <div class="card-inventario" data-page="categorias">
      <i class="bi bi-tags"></i>
      <div>
        <p class="card-title">Categorías</p>
      </div>
    </div>

    <div class="card-inventario" data-page="proveedores">
      <i class="bi bi-truck"></i>
      <div>
        <p class="card-title">Proveedores</p>
      </div>
    </div>

    <div class="card-inventario" data-page="clientes">
      <i class="bi bi-person"></i>
      <div>
        <p class="card-title">Clientes</p>
      </div>
    </div>

    <div class="card-inventario" data-page="ventas">
      <i class="bi bi-cash-coin"></i>
      <div>
        <p class="card-title">Ventas</p>
      </div>
    </div>

    <div class="card-inventario" data-page="pedidos">
      <i class="bi bi-receipt"></i>
      <div>
        <p class="card-title">Pedidos</p>
      </div>
    </div>

  </div>


  <script src="../script.js"></script>
</body>

</html>