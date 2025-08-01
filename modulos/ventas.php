<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<style>
    .modern-title {
        font-family: 'Nunito Sans', sans-serif;
        font-weight: 600;
        /* un poco más grueso para destacar */
        font-size: 1.6rem;
        color: #2c3e50;
        /* un azul oscuro moderno */
        display: flex;
        align-items: center;
        gap: 0.75rem;
        /* espacio entre icono y texto */
        text-transform: uppercase;
        letter-spacing: 1.5px;
        /* espacio entre letras */
        border-left: 4px solid #3498db;
        /* barra lateral color azul */
        padding-left: 12px;
        transition: color 0.3s ease;
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
                <i class="bi bi-cash-coin"></i> Gestión de Ventas
            </h2>

        </div>
    </div>

    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Módulo de Ventas</h4>
        <p>Este módulo está en desarrollo. Aquí podrás gestionar todas las ventas.</p>
        <hr>
        <p class="mb-0">Funcionalidades: Registrar ventas, consultar historial, generar reportes.</p>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Registro de Ventas</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Contenido del módulo de ventas...</p>
                    <button class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Nueva Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>