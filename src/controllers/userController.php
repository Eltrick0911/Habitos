<?php

namespace App\controllers;

use App\config\responseHTTP;
use App\models\userModel;

class userController {
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers; 

    // ... expresiones regulares ...

    public function __construct($method, $route, $params, $data, $headers) {
        // ... inicialización de propiedades ...
    }

    final public function post() {
        if ($this->method == 'post' && $this->route == '/api/usuarios') {
            // Validar que los campos no estén vacíos
            if (empty($this->data['nombre']) || empty($this->data['apellidos']) || empty($this->data['correo_electronico']) || 
                empty($this->data['contrasena']) || empty($this->data['fecha_nacimiento']) || empty($this->data['genero']) || 
                empty($this->data['pais_region']) || empty($this->data['nivel_suscripcion']) || empty($this->data['preferencias_notificacion'])) {
                
                return responseHTTP::status400('Todos los campos son requeridos.');
            }

            // Validar que la contraseña y la confirmación de contraseña coincidan
            if ($this->data['contrasena'] !== $this->data['confirmaClave']) {
                return responseHTTP::status400('Las contraseñas no coinciden.');
            }

            // ... otras validaciones ...

            try {
                $userModel = new userModel($this->data);
                $response = $userModel->crearUsuario();
                echo json_encode($response); 

            } catch (\InvalidArgumentException $e) {
                return responseHTTP::status400($e->getMessage());
            } catch (\Exception $e) {
                error_log('userController::post -> ' . $e);
                return responseHTTP::status500();
            }

            exit;
        }
    }

    final public function put() {
        if ($this->method == 'put' && preg_match('/^\/api\/usuarios\/(\d+)$/', $this->route, $matches)) {
            $id_usuario = $matches[1];

            // Validar los datos (algunos campos pueden ser opcionales)
            if (empty($this->data['nombre'])) {
                return responseHTTP::status400('El nombre es requerido.');
            }

            // ... otras validaciones ...

            try {
                $usuario = userModel::obtenerUsuarioPorId($id_usuario);
                if (!$usuario) {
                    return responseHTTP::status404('Usuario no encontrado.');
                }

                // Actualizar las propiedades del usuario con los nuevos datos
                $usuario->setNombre($this->data['nombre']);
                // ... actualizar otras propiedades ...

                $response = $usuario->modificarUsuario();
                echo json_encode($response);

            } catch (\InvalidArgumentException $e) {
                return responseHTTP::status400($e->getMessage());
            } catch (\Exception $e) {
                error_log('userController::put -> ' . $e);
                return responseHTTP::status500();
            }

            exit;
        }
    }

    final public function delete() {
        if ($this->method == 'delete' && preg_match('/^\/api\/usuarios\/(\d+)$/', $this->route, $matches)) {
            $id_usuario = $matches[1];

            try {
                $response = userModel::eliminarUsuario($id_usuario);
                echo json_encode($response);

            } catch (\Exception $e) {
                error_log('userController::delete -> ' . $e);
                return responseHTTP::status500();
            }

            exit;
        }
    }
    final public function get() {
        // Verificar si la solicitud es GET y la ruta es /api/usuarios/{id}
        if ($this->method == 'get' && preg_match('/^\/api\/usuarios\/(\d+)$/', $this->route, $matches)) {
            // Obtener el ID del usuario
            $id_usuario = $matches[1];
    
            try {
                // Obtener el usuario de la base de datos
                $usuario = userModel::obtenerUsuarioPorId($id_usuario);
    
                if ($usuario) {
                    // Devolver la información del usuario con código 200
                    echo json_encode(responseHTTP::status200('Usuario Encontrado'));
                } else {
                    // Devolver un error 404 si el usuario no existe
                    echo json_encode(responseHTTP::status404());
                }
    
            } catch (\Exception $e) {
                error_log('userController::get -> ' . $e);
                return responseHTTP::status500();
            }
    
            exit;
        }
    }
}