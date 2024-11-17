# API de Catálogo de Productos con Laravel 11

API RESTful para la gestión de productos en un catálogo de tienda online, implementada con Laravel 11 siguiendo los principios de Clean Architecture.

[Las secciones anteriores se mantienen igual...]

## Arquitectura y Decisiones de Diseño

### Clean Architecture

Este proyecto implementa Clean Architecture, una arquitectura en capas que promueve la separación de preocupaciones y la independencia de frameworks. La estructura se organiza en las siguientes capas:

#### 1. Capa de Dominio (Domain Layer)
La capa más interna que contiene la lógica de negocio central.

- **Entities/**
  - Contiene los modelos de dominio puros
  - No dependen de ninguna implementación externa
  - Definen las reglas de negocio fundamentales
  - Ejemplo: `Product.php` define la estructura y comportamiento básico de un producto

- **Repositories/Interfaces/**
  - Define contratos para el acceso a datos
  - Permite la inversión de dependencias
  - Facilita el testing mediante mocking
  - Ejemplo: `ProductRepositoryInterface.php` define métodos estándar CRUD

- **UseCases/**
  - Implementa la lógica de negocio específica
  - Cada caso de uso representa una operación del sistema
  - Mantiene el principio de responsabilidad única
  - Ejemplos:
    - `CreateProduct.php`
    - `UpdateProduct.php`
    - `DeleteProduct.php`
    - `GetProducts.php`

#### 2. Capa de Infraestructura (Infrastructure Layer)
Contiene implementaciones concretas y detalles técnicos.

- **Persistence/**
  - Implementaciones concretas de los repositorios
  - Manejo de la base de datos usando Eloquent
  - Ejemplo: `ProductRepository.php` implementa `ProductRepositoryInterface`

- **Framework/**
  - Adaptadores para el framework Laravel
  - Controllers que manejan las solicitudes HTTP
  - Transformación de datos entre la API y el dominio

#### 3. Capa de Aplicación (Application Layer)
Orquesta el flujo de datos entre las capas externas e internas.

- **Services/**
  - Coordina múltiples casos de uso
  - Maneja transacciones
  - Implementa lógica de aplicación específica

### Patrones de Diseño Implementados

1. **Repository Pattern**
   - Abstrae la capa de persistencia
   - Permite cambiar la implementación de almacenamiento sin afectar la lógica de negocio
   - Facilita el testing mediante mocking

2. **Factory Pattern**
   - Creación de instancias de entidades
   - Encapsula la lógica de creación
   - Mantiene la consistencia en la creación de objetos

3. **DTO (Data Transfer Objects)**
   - Transferencia de datos entre capas
   - Validación de datos de entrada
   - Transformación de datos para respuestas API

### Decisiones de Diseño

1. **Autenticación JWT**
   - Token stateless para mejor escalabilidad
   - Facilita la autenticación en arquitecturas distribuidas
   - Implementación mediante tymon/jwt-auth para seguridad robusta

2. **Validación**
   - Validación en múltiples capas:
     - Request Validation para datos de entrada
     - Domain Validation para reglas de negocio
     - Database Validation para integridad de datos

3. **Manejo de Errores**
   - Excepciones personalizadas por dominio
   - Middleware para transformación consistente de errores
   - Respuestas HTTP estandarizadas

4. **Estructura de Base de Datos**
   - Uso de migraciones para control de versiones
   - Relaciones definidas en modelos Eloquent

5. **API Versioning**
   - Prefijo v1 para control de versiones
   - Facilita la evolución de la API
   - Permite mantener múltiples versiones simultáneamente

### Beneficios de la Arquitectura

1. **Mantenibilidad**
   - Código organizado y predecible
   - Fácil de entender y modificar
   - Separación clara de responsabilidades

2. **Testabilidad**
   - Fácil de escribir pruebas unitarias
   - Mocking simplificado
   - Cobertura de código efectiva

3. **Flexibilidad**
   - Fácil de extender con nuevas funcionalidades
   - Cambios con mínimo impacto
   - Adaptable a nuevos requerimientos

4. **Escalabilidad**
   - Preparado para crecimiento
   - Fácil de distribuir en microservicios
   - Performance optimizada

## Requisitos

- PHP >= 8.2
- Composer
- MySQL
- Laravel 11
- JWT Auth Package

## Instalación

1. Clonar el repositorio:
```bash
git clone <repository-url>
cd <project-folder>
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar el archivo .env:
```bash
cp .env.example .env
```
Actualizar las siguientes variables:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

JWT_SECRET=your_jwt_secret
```

4. Generar la clave de la aplicación:
```bash
php artisan key:generate
```

5. Generar la clave secreta JWT:
```bash
php artisan jwt:secret
```

6. Ejecutar las migraciones:
```bash
php artisan migrate
```

## Estructura del Proyecto

```
app/
├── Domain/
│   ├── Entities/
│   │   └── Product.php
│   ├── Repositories/
│   │   └── ProductRepositoryInterface.php
│   └── UseCases/
│       ├── CreateProduct.php
│       ├── UpdateProduct.php
│       ├── DeleteProduct.php
│       └── GetProducts.php
├── Infrastructure/
│   ├── Persistence/
│   │   └── ProductRepository.php
│   └── Framework/
│       └── Laravel/
│           └── Controllers/
│               └── ProductController.php
├── Providers/
│   └── RepositoryServiceProvider.php
routes/
├── api.php
```

## Autenticación

### Login
```http
POST /api/v1/auth/login
```

**Request Body:**
```json
{
    "username": "string",
    "password": "string"
}
```

**Response:**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### Registro
```http
POST /api/v1/auth/register
```

**Request Body:**
```json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}
```

**Response:**
```json
{
    "message": "Usuario registrado exitosamente",
    "user": {
        "id": 1,
        "name": "string",
        "email": "string",
        "created_at": "timestamp"
    },
    "token": "ASDF@#$@#GFDDSF"
}
```

### Obtener Información del Usuario
```http
GET /api/v1/auth/me
```

**Headers requeridos:**
```
Authorization: Bearer <token>
```

**Response:**
```json
{
    "id": 1,
    "name": "string",
    "email": "string",
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```

### Refrescar Token
```http
POST /api/v1/auth/refresh
```

**Headers requeridos:**
```
Authorization: Bearer <token>
```

**Response:**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "bearer",
    "expires_in": 3600
}
```

## Endpoints de Productos

Todos los endpoints de productos requieren autenticación JWT. Incluir el token en el header:
```
Authorization: Bearer <token>
```

### Crear Producto
```http
POST /api/v1/products
```

**Request Body:**
```json
{
    "name": "string",
    "description": "string",
    "price": "number",
    "category": "string"
}
```

### Listar Productos
```http
GET /api/v1/products
```

### Obtener Producto por ID
```http
GET /api/v1/products/{id}
```

### Actualizar Producto
```http
PUT /api/v1/products/{id}
```

**Request Body:**
```json
{
    "name": "string",
    "description": "string",
    "price": "number",
    "category": "string"
}
```

### Eliminar Producto
```http
DELETE /api/v1/products/{id}
```

## Códigos de Respuesta

- `200 OK`: Solicitud exitosa
- `201 Created`: Recurso creado exitosamente
- `400 Bad Request`: Datos inválidos en la solicitud
- `401 Unauthorized`: Token JWT inválido o expirado
- `404 Not Found`: Recurso no encontrado
- `500 Internal Server Error`: Error del servidor

## Validaciones

### Validaciones de Autenticación
- `name`: Requerido, string, máximo 255 caracteres
- `email`: Requerido, debe ser un email válido, único en la tabla users
- `password`: Requerido, mínimo 8 caracteres, debe contener al menos una mayúscula y un número
- `password_confirmation`: Debe coincidir con el campo password

### Validaciones de Productos
- `name`: Requerido, string, máximo 255 caracteres
- `description`: Requerido, string
- `price`: Requerido, numérico, mayor que 0
- `category`: Requerido, string, máximo 100 caracteres

## Middleware

- `auth:api`: Protege las rutas verificando el token JWT
- `validate`: Valida los datos de entrada según las reglas definidas

## Base de Datos

### Tabla Users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabla Products
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Test (En construccion)

Para ejecutar los tests:
```bash
php artisan test
```

## License

[MIT](https://opensource.org/licenses/MIT)

## Autor

**Dairo Facundo**

* LinkedIn: [Dairo Facundo](https://www.linkedin.com/in/dairo-facundo/)
* GitHub: [@dairofacundo](https://github.com/dairof7)

## Licencia

Copyright © 2024 Dairo Facundo
