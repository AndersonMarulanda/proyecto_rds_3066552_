# Proyecto RDS - API REST con Laravel

API REST desarrollada con Laravel 11 y Sanctum para la gestión de cargos, empleados y funciones de cargo.

## Requisitos

- PHP 8.2+
- Composer
- MySQL

## Instalación

```bash
git clone https://github.com/AndersonMarulanda/proyecto_rds_3066552_.git
cd proyecto_rds_3066552_
composer install
cp .env.example .env
php artisan key:generate
```

Configura tu base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_rds_3066552_
DB_USERNAME=root
DB_PASSWORD=
```

Luego ejecuta:

```bash
php artisan migrate --seed
```

Esto crea: **40 cargos**, **30 empleados distribuidos** y **5 funciones por cargo**.

## Autenticación

Todos los endpoints requieren un token Bearer. Primero regístrate o inicia sesión.

### Registro

```
POST /api/register
```

```json
{
    "name": "Anderson",
    "email": "anderson@email.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}
```

**Respuesta:**
```json
{
    "user": { "id": 1, "name": "Anderson", "email": "anderson@email.com" },
    "token": "1|abc123..."
}
```

### Login

```
POST /api/login
```

```json
{
    "email": "anderson@email.com",
    "password": "12345678"
}
```

**Respuesta:**
```json
{
    "user": { "id": 1, "name": "Anderson", "email": "anderson@email.com" },
    "token": "1|abc123..."
}
```

### Logout

```
POST /api/logout
Authorization: Bearer {token}
```

## Endpoints

Todos los endpoints requieren el header:

```
Authorization: Bearer {token}
```

---

### Cargos

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/cargos | Listar todos los cargos |
| POST | /api/cargos | Crear un cargo |
| GET | /api/cargos/{id} | Ver un cargo |
| PUT | /api/cargos/{id} | Actualizar un cargo |
| DELETE | /api/cargos/{id} | Eliminar un cargo |
| GET | /api/cargos/{id}/funciones | Listar funciones de un cargo |

**Campos para crear/actualizar:**
```json
{
    "nombre_cargo": "Desarrollador",
    "salario_base": 3000000,
    "estado": "activo"
}
```

**Validaciones:**
- `nombre_cargo`: requerido, texto
- `salario_base`: requerido, numérico, mayor a 0
- `estado`: requerido, `activo` o `inactivo`

---

### Empleados

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/empleados | Listar todos los empleados |
| POST | /api/empleados | Crear un empleado |
| GET | /api/empleados/{id} | Ver detalle de un empleado |
| PUT | /api/empleados/{id} | Actualizar un empleado |
| DELETE | /api/empleados/{id} | Eliminar un empleado |

**Campos para crear/actualizar:**
```json
{
    "nombres": "Juan",
    "apellidos": "Pérez",
    "fecha_nacimiento": "1995-05-20",
    "fecha_ingreso": "2024-01-15",
    "salario": 2500000,
    "estado": "activo",
    "id_cargo": 1
}
```

**Detalle de empleado (GET /api/empleados/{id}):**
```json
{
    "id": 1,
    "nombre": "Juan Pérez",
    "salario": 2500000,
    "estado": "activo",
    "cargo": {
        "id": 1,
        "nombre_cargo": "Desarrollador",
        "salario_base": 3000000
    },
    "funciones": [
        {
            "id": 1,
            "descripcion_funcion": "Gestionar equipo de desarrollo",
            "estado": "activo"
        }
    ]
}
```

**Validaciones:**
- `nombres`, `apellidos`: requeridos, texto
- `fecha_nacimiento`, `fecha_ingreso`: requeridos, fecha
- `salario`: requerido, numérico, mayor a 0
- `estado`: requerido, `activo` o `inactivo`
- `id_cargo`: requerido, debe existir en la tabla cargos

---

### Funciones de Cargo

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/funciones | Listar todas las funciones |
| POST | /api/funciones | Crear una función |
| GET | /api/funciones/{id} | Ver una función |
| PUT | /api/funciones/{id} | Actualizar una función |
| DELETE | /api/funciones/{id} | Eliminar una función |

**Campos para crear/actualizar:**
```json
{
    "descripcion_funcion": "Gestionar equipo de desarrollo",
    "estado": "activo",
    "id_cargo": 1
}
```

**Validaciones:**
- `descripcion_funcion`: requerido, texto
- `estado`: requerido, `activo` o `inactivo`
- `id_cargo`: requerido, debe existir en la tabla cargos

---

## Errores comunes

| Código | Descripción |
|--------|-------------|
| 401 | No autenticado — falta el token |
| 404 | Recurso no encontrado |
| 422 | Error de validación |

## Tests

```bash
php artisan test
```

22 tests, 60 assertions, todos en verde.

## Tecnologías

- Laravel 11
- Sanctum
- SQLite (tests)
- MySQL (producción)
