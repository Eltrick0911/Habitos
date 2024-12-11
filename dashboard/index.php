<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['logged_in']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: ../src/Routes/views/login.html");
    exit();
}

require_once "vistas/parte_superior.php";
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row">
        <!-- Usuarios Totales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Usuarios Totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalUsuarios">Cargando...</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hábitos Totales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hábitos Totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalHabitos">Cargando...</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comentarios Totales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Comentarios Totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalComentarios">Cargando...</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de Navegación -->
    <ul class="nav nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab">
                <i class="fas fa-users"></i> Usuarios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="habitos-tab" data-toggle="tab" href="#habitos" role="tab">
                <i class="fas fa-check-circle"></i> Hábitos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="comentarios-tab" data-toggle="tab" href="#comentarios" role="tab">
                <i class="fas fa-comments"></i> Comentarios
            </a>
        </li>
    </ul>

    <!-- Contenido de las Pestañas -->
    <div class="tab-content" id="adminTabsContent">
        <!-- Pestaña de Usuarios -->
        <div class="tab-pane fade show active" id="usuarios" role="tabpanel">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gestión de Usuarios</h6>
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalUsuario">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaUsuarios" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>País/Región</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pestaña de Hábitos -->
        <div class="tab-pane fade" id="habitos" role="tabpanel">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Gestión de Hábitos</h6>
                    <button class="btn btn-success float-right" data-toggle="modal" data-target="#modalHabito">
                        <i class="fas fa-plus"></i> Nuevo Hábito
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaHabitos" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pestaña de Comentarios -->
        <div class="tab-pane fade" id="comentarios" role="tabpanel">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Gestión de Comentarios</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaComentarios" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Grupo</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Usuario -->
<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalUsuario">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUsuario">
                <div class="modal-body">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="correo_electronico" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" id="password" name="contrasena">
                            <small class="form-text text-muted">Dejar en blanco para mantener la contraseña actual</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Género</label>
                            <select class="form-control" id="genero" name="genero" required>
                                <option value="">Seleccionar...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>País/Región</label>
                            <input type="text" class="form-control" id="pais_region" name="pais_region" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nivel de Suscripción</label>
                            <select class="form-control" id="nivel_suscripcion" name="nivel_suscripcion" required>
                                <option value="basico">Básico</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hábito -->
<div class="modal fade" id="modalHabito" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalHabito">Nuevo Hábito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formHabito">
                <div class="modal-body">
                    <input type="hidden" id="id_habito" name="id_habito">
                    <div class="form-group">
                        <label>Usuario</label>
                        <select class="form-control" id="usuario_id" name="usuario_id" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Frecuencia</label>
                            <select class="form-control" id="frecuencia" name="frecuencia" required>
                                <option value="diario">Diario</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="completado">Completado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "vistas/parte_inferior.php"; ?>