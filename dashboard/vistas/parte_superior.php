<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION["s_usuario"])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel de Administración - GOOD HABITS</title>

    <!-- Custom fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .sidebar { background-color: #4e73df; }
        .sidebar-brand { padding: 1.5rem 1rem; }
        .sidebar-heading { padding: 0.75rem 1rem; font-size: 0.75rem; }
        .nav-item .nav-link { padding: 0.75rem 1rem; }
        .nav-item .nav-link i { margin-right: 0.25rem; }
        .topbar { height: 4.375rem; }
        .topbar .nav-item .nav-link { height: 4.375rem; }
        .card-header { background-color: #f8f9fc; }
        .btn-icon-split .icon { padding: .375rem .75rem; }
        .btn-icon-split .text { padding: .375rem .75rem; }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="sidebar-brand-text mx-3">GOOD HABITS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Gestión
            </div>

            <!-- Nav Item - Usuarios -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#usuarios">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>

            <!-- Nav Item - Hábitos -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#habitos">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span>Hábitos</span>
                </a>
            </li>

            <!-- Nav Item - Comentarios -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#comentarios">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Comentarios</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle">
                    <i class="fas fa-angle-left"></i>
                </button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['nombre_completo']; ?>
                                </span>
                                <i class="fas fa-user-circle fa-2x"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <div class="user-info">
                    Bienvenido, <?php echo $_SESSION['nombre_completo']; ?> 
                    <a href="../bd/logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
                </div>
