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

### Cargos

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/cargos | Listar todos |
| POST | /api/cargos | Crear |
| GET | /api/cargos/{id} | Ver uno |
| PUT | /api/cargos/{id} | Actualizar |
| DELETE | /api/cargos/{id} | Eliminar |

**Campos:**

```json
{
    "nombre_cargo": "Desarrollador",
    "salario_base": 3000000,
    "estado": "activo"
}
```

### Empleados

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/empleados | Listar todos |
| POST | /api/empleados | Crear |
| GET | /api/empleados/{id} | Ver uno |
| PUT | /api/empleados/{id} | Actualizar |
| DELETE | /api/empleados/{id} | Eliminar |

**Campos:**

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

### Funciones de Cargo

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/funciones | Listar todas |
| POST | /api/funciones | Crear |
| GET | /api/funciones/{id} | Ver una |
| PUT | /api/funciones/{id} | Actualizar |
| DELETE | /api/funciones/{id} | Eliminar |

**Campos:**

```json
{
    "descripcion_funcion": "Gestionar equipo de desarrollo",
    "estado": "activo",
    "id_cargo": 1
}
```

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
