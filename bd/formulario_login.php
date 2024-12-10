<?php
session_start();

if(isset($_SESSION["s_usuario"])) {
    if($_SESSION["tipo_usuario"] == 'admin') {
        header("Location: ../dashboard/pag_admin.php");
    } else {
        header("Location: ../vistas/pag_usuario.php");
    }
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Iniciar Sesión - Control de Hábitos</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            :root {
                --primary-color: #4e73df;
                --primary-dark: #224abe;
            }
            
            body {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .container-login {
                background: white;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.2);
                padding: 2rem;
                width: 100%;
                max-width: 400px;
            }
            
            .login-form-title {
                text-align: center;
                font-size: 1.5rem;
                margin-bottom: 2rem;
                color: var(--primary-color);
                font-weight: bold;
            }
            
            .form-control {
                border-radius: 30px;
                padding: 0.75rem 1.25rem;
            }
            
            .btn-login {
                background: var(--primary-color);
                color: white;
                border-radius: 30px;
                padding: 0.75rem 1.25rem;
                font-weight: bold;
                width: 100%;
                margin-top: 1rem;
            }
            
            .btn-login:hover {
                background: var(--primary-dark);
                color: white;
            }
            
            .back-link {
                display: block;
                text-align: center;
                margin-top: 1rem;
                color: var(--primary-color);
                text-decoration: none;
            }
            
            .back-link:hover {
                color: var(--primary-dark);
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container-login">
            <form id="formLogin" class="login-form" action="" method="post">
                <div class="text-center mb-4">
                    <i class="fas fa-check-circle fa-3x text-primary"></i>
                    <h1 class="login-form-title mt-3">Control de Hábitos</h1>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>
                
                <a href="../index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Volver al Inicio
                </a>
            </form>
        </div>

        <script src="../jquery/jquery-3.3.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#formLogin").submit(function(e){
                    e.preventDefault();
                    
                    var usuario = $.trim($("#usuario").val());
                    var password = $.trim($("#password").val());
                    
                    if(usuario.length == 0 || password.length == 0){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Debe ingresar un usuario y contraseña'
                        });
                        return false;
                    }
                    
                    $.ajax({
                        url: "login.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            usuario: usuario,
                            password: password
                        },
                        success: function(data){
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Conexión exitosa!',
                                    text: 'Bienvenido ' + data.nombre_completo,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ingresar'
                                }).then((result) => {
                                    if(result.value){
                                        window.location.href = data.redirect_url;
                                    }
                                });
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.error
                                });
                            }
                        },
                        error: function(){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ha ocurrido un error en el servidor'
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>
<a class="nav-link" href="frontend/src/views/formulario_login.php">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="frontend/src/views/formulario_registro.php">
                                <i class="fas fa-user-plus"></i> Registrarse