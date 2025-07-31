<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



<style>
    .modern-title {
        font-family: 'Nunito Sans', sans-serif;
        font-weight: 300;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #2c3e50;
        border-left: 4px solid #3498db;
        
        padding-left: 10px;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .modern-title i {
        font-size: 1.8rem;
        color: #3498db;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .modern-title:hover {
        color: #2980b9;
    }

    .modern-title:hover i {
        color: #2980b9;
        transform: scale(1.1) rotate(10deg);
    }
</style>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="modern-title mb-4">
                <i class="bi bi-receipt"></i> Gestión de Pedidos
            </h2>

        </div>
    </div>

    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Módulo de Pedidos</h4>
        <p>Este módulo está en desarrollo. Aquí podrás gestionar todos los pedidos.</p>
        <hr>
        <p class="mb-0">Funcionalidades: Crear pedidos, seguimiento, gestión de estados.</p>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lista de Pedidos</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Contenido del módulo de pedidos...</p>
                    <button class="btn btn-warning">
                        <i class="bi bi-plus-circle"></i> Nuevo Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>