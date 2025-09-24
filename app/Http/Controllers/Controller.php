<?php

namespace App\Http\Controllers;

// 1. Importa la clase de Atributos de OpenAPI
use OpenApi\Attributes as OA;

/**
 * 2. Añade aquí el bloque de información principal y el esquema de seguridad.
 *    Esta es la pieza que le falta al generador de Swagger.
 */
#[OA\Info(
    version: "1.0.0",
    title: "API de Proyectos de Pavimento",
    description: "Documentación de la API para la gestión de proyectos, abscisas, losas y patologías. Creada para la aplicación móvil y web."
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth", // Un nombre que le damos a nuestro esquema de seguridad
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Autenticación por Bearer Token (Laravel Sanctum). Incluir el token en el header 'Authorization'."
)]
abstract class Controller
{
    // No necesitas añadir nada dentro de la clase, las anotaciones van afuera.
}