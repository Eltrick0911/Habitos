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

    // Atributos de usuario con expresiones regulares
    private static $validar_texto = '/^[a-zA-Z]+$/'; // Validamos texto (a-z y A-Z)
    private static $validar_numero = '/^[0-9]+$/'; // Validamos números (0-9)
    private static $validar_email = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/'; // Validamos formato de correo electrónico

    public function __construct($method, $route, $params, $data, $headers) {
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    // Método que recibe un endpoint (ruta a un recurso)
    final public function post($endpoint) {
        // Validamos method y endpoint
        if ($this->method == 'post' && $endpoint == $this->route) {
            // Validamos que los campos no vengan vacíos
            if (empty($this->data['nombre']) || empty($this->data['apellidos']) || empty($this->data['correo_electronico']) || 
                empty($this->data['contrasena']) || empty($this->data['fecha_nacimiento']) || empty($this->data['genero']) || 
                empty($this->data['pais_region']) || empty($this->data['nivel_suscripcion']) || empty($this->data['preferencias_notificacion'])) {
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos, proceda a llenarlos.'));
            } 
            // Validamos que los campos de texto sean de texto mediante preg_match evaluamos expresiones regulares
            else if (!preg_match(self::$validar_texto, $this->data['nombre'])) {
                echo json_encode(responseHTTP::status400('En el campo nombre debe ingresar solo texto.'));
            } 
            else if (!preg_match(self::$validar_texto, $this->data['apellidos'])) {
                echo json_encode(responseHTTP::status400('En el campo apellidos debe ingresar solo texto.'));
            } 
            // Validamos que el correo tenga el formato correcto
            else if (!filter_var($this->data['correo_electronico'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(responseHTTP::status400('El correo debe tener el formato correcto.'));
            } 
            // Validamos que la fecha de nacimiento tenga el formato correcto
            else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->data['fecha_nacimiento'])) {
                echo json_encode(responseHTTP::status400('La fecha de nacimiento debe tener el formato YYYY-MM-DD.'));
            } 
            // Validamos que el género sea válido
            else if (!in_array($this->data['genero'], ['Masculino', 'Femenino', 'Otro'])) {
                echo json_encode(responseHTTP::status400('El género es inválido.'));
            } 
            // Validamos que el nivel de suscripción sea válido
            else if (!in_array($this->data['nivel_suscripcion'], ['gratuita', 'premium'])) {
                echo json_encode(responseHTTP::status400('El nivel de suscripción es inválido.'));
            } 
            else {
                new userModel($this->data);
                echo json_encode(userModel::post());
            }
            exit;
        }
    }
}