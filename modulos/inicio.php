<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="bi bi-house-door"></i> Panel de Control
            </h2>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card-inventario" data-page="productos">
                <i class="bi bi-grid"></i>
                <div>
                    <p class="card-title">Productos</p>
                    <small class="text-muted">Gestionar inventario</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-inventario" data-page="categorias">
                <i class="bi bi-tags"></i>
                <div>
                    <p class="card-title">Categorías</p>
                    <small class="text-muted">Organizar productos</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-inventario" data-page="proveedores">
                <i class="bi bi-truck"></i>
                <div>
                    <p class="card-title">Proveedores</p>
                    <small class="text-muted">Gestionar proveedores</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-inventario" data-page="clientes">
                <i class="bi bi-person"></i>
                <div>
                    <p class="card-title">Clientes</p>
                    <small class="text-muted">Base de clientes</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-inventario" data-page="ventas">
                <i class="bi bi-cash-coin"></i>
                <div>
                    <p class="card-title">Ventas</p>
                    <small class="text-muted">Registro de ventas</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-inventario" data-page="pedidos">
                <i class="bi bi-receipt"></i>
                <div>
                    <p class="card-title">Pedidos</p>
                    <small class="text-muted">Gestionar pedidos</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas rápidas -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-3">
                <i class="bi bi-graph-up"></i> Resumen Rápido
            </h4>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-box"></i>
                    </h5>
                    <h3 class="text-primary">--</h3>
                    <p class="card-text">Total Productos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="bi bi-people"></i>
                    </h5>
                    <h3 class="text-success">--</h3>
                    <p class="card-text">Clientes Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-warning">
                        <i class="bi bi-truck"></i>
                    </h5>
                    <h3 class="text-warning">--</h3>
                    <p class="card-text">Proveedores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-info">
                        <i class="bi bi-currency-dollar"></i>
                    </h5>
                    <h3 class="text-info">$--</h3>
                    <p class="card-text">Ventas del Mes</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-inventario {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    height: 120px;
}

.card-inventario:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.card-inventario i {
    font-size: 2.5rem;
    opacity: 0.9;
}

.card-inventario .card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.card-inventario small {
    opacity: 0.8;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
