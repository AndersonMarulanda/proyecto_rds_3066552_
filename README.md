# API REST - Proyecto RDS

API REST desarrollada en **Laravel 13** para gestionar empleados, cargos y funciones de cargo. Usa autenticación con tokens Bearer mediante **Laravel Sanctum**, por lo tanto primero se debe registrar o iniciar sesión para obtener un token y después consumir los endpoints protegidos.

---

## Tabla de contenido

- [Descripción](#descripción)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración de la base de datos](#configuración-de-la-base-de-datos)
- [Ejecutar el proyecto](#ejecutar-el-proyecto)
- [Autenticación](#autenticación)
- [Endpoints](#endpoints)
  - [Cargos](#cargos)
  - [Empleados](#empleados)
  - [Funciones de Cargo](#funciones-de-cargo)
- [Errores comunes](#errores-comunes)
- [Tests](#tests)
- [Tecnologías](#tecnologías)

---

## Descripción

Este proyecto permite realizar operaciones CRUD sobre:

- **Cargos**
- **Empleados**
- **Funciones de Cargo**

Incluye un endpoint especial para consultar el detalle completo de un empleado, mostrando su nombre, cargo asignado, salario y las funciones asociadas al cargo.

Todas las rutas están protegidas con Sanctum. Las únicas rutas públicas son:

```
POST /api/register
POST /api/login
```

---

## Requisitos

Antes de instalar el proyecto asegúrate de tener:

| Herramienta | Versión mínima |
|-------------|----------------|
| PHP | 8.3+ |
| Composer | 2.0+ |
| MySQL | 8.0+ |
| Git | cualquier versión |

---

## Instalación

**1. Clonar el repositorio**

```bash
git clone https://github.com/AndersonMarulanda/proyecto_rds_3066552_.git
cd proyecto_rds_3066552_
```

**2. Instalar dependencias**

```bash
composer install
```

**3. Copiar el archivo de entorno**

```bash
cp .env.example .env
```

En Windows con PowerShell:

```bash
Copy-Item .env.example .env
```

**4. Generar la llave de la aplicación**

```bash
php artisan key:generate
```

---

## Configuración de la base de datos

Abre el archivo `.env` y configura estas variables:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_rds_3066552_
DB_USERNAME=root
DB_PASSWORD=
```

Si la base de datos no existe, créala primero:

```sql
CREATE DATABASE proyecto_rds_3066552_ CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Luego ejecuta las migraciones y el seeder:

```bash
php artisan migrate --seed
```

Esto genera automáticamente:

- **40 cargos**
- **5 funciones por cargo** (200 funciones en total)
- **30 empleados** distribuidos entre los cargos

Si necesitas reiniciar la base de datos desde cero:

```bash
php artisan migrate:fresh --seed
```

---

## Ejecutar el proyecto

```bash
php artisan serve
```

La API quedará disponible en:

```
http://127.0.0.1:8000/api
```

---

## Autenticación

Todos los endpoints requieren el siguiente header:

```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

El token se obtiene al registrarse o iniciar sesión.

---

### Registro

```
POST /api/register
```

**Body:**
```json
{
    "name": "Anderson Marulanda",
    "email": "anderson@email.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}
```

**Respuesta exitosa `201`:**
```json
{
    "user": {
        "id": 1,
        "name": "Anderson Marulanda",
        "email": "anderson@email.com"
    },
    "token": "1|abc123xyz..."
}
```

---

### Login

```
POST /api/login
```

**Body:**
```json
{
    "email": "anderson@email.com",
    "password": "12345678"
}
```

**Respuesta exitosa `200`:**
```json
{
    "user": {
        "id": 1,
        "name": "Anderson Marulanda",
        "email": "anderson@email.com"
    },
    "token": "1|abc123xyz..."
}
```

**Respuesta error `401`:**
```json
{
    "message": "Credenciales incorrectas"
}
```

---

### Logout

```
POST /api/logout
Authorization: Bearer {token}
```

**Respuesta exitosa `200`:**
```json
{
    "message": "Sesión cerrada correctamente"
}
```

---

## Endpoints

### Resumen

| Módulo | Método | Ruta | Protegida | Descripción |
|--------|--------|------|-----------|-------------|
| Auth | POST | /api/register | No | Registrar usuario |
| Auth | POST | /api/login | No | Iniciar sesión |
| Auth | POST | /api/logout | ✅ | Cerrar sesión |
| Cargos | GET | /api/cargos | ✅ | Listar cargos |
| Cargos | POST | /api/cargos | ✅ | Crear cargo |
| Cargos | GET | /api/cargos/{id} | ✅ | Ver cargo |
| Cargos | PUT | /api/cargos/{id} | ✅ | Actualizar cargo |
| Cargos | DELETE | /api/cargos/{id} | ✅ | Eliminar cargo |
| Cargos | GET | /api/cargos/{id}/funciones | ✅ | Funciones de un cargo |
| Empleados | GET | /api/empleados | ✅ | Listar empleados |
| Empleados | POST | /api/empleados | ✅ | Crear empleado |
| Empleados | GET | /api/empleados/{id} | ✅ | Detalle de empleado |
| Empleados | PUT | /api/empleados/{id} | ✅ | Actualizar empleado |
| Empleados | DELETE | /api/empleados/{id} | ✅ | Eliminar empleado |
| Funciones | GET | /api/funciones | ✅ | Listar funciones |
| Funciones | POST | /api/funciones | ✅ | Crear función |
| Funciones | GET | /api/funciones/{id} | ✅ | Ver función |
| Funciones | PUT | /api/funciones/{id} | ✅ | Actualizar función |
| Funciones | DELETE | /api/funciones/{id} | ✅ | Eliminar función |

---

### Cargos

#### GET /api/cargos

Lista todos los cargos.

**Respuesta exitosa `200`:**
```json
[
    {
        "id": 1,
        "nombre_cargo": "Desarrollador",
        "salario_base": 3000000,
        "estado": "activo"
    }
]
```

**Sin registros:**
```json
{
    "message": "No se encontraron cargos registrados"
}
```

---

#### POST /api/cargos

**Body:**
```json
{
    "nombre_cargo": "Desarrollador",
    "salario_base": 3000000,
    "estado": "activo"
}
```

**Validaciones:**
- `nombre_cargo`: requerido, texto, máximo 255 caracteres
- `salario_base`: requerido, numérico, mayor o igual a 0
- `estado`: requerido, valores permitidos: `activo` o `inactivo`

**Respuesta exitosa `201`:**
```json
{
    "id": 1,
    "nombre_cargo": "Desarrollador",
    "salario_base": 3000000,
    "estado": "activo"
}
```

---

#### GET /api/cargos/{id}

**Respuesta exitosa `200`:**
```json
{
    "id": 1,
    "nombre_cargo": "Desarrollador",
    "salario_base": 3000000,
    "estado": "activo"
}
```

**No encontrado `404`:**
```json
{
    "message": "Recurso no encontrado"
}
```

---

#### PUT /api/cargos/{id}

Solo se envían los campos a modificar.

**Body:**
```json
{
    "nombre_cargo": "Senior Developer",
    "salario_base": 5000000
}
```

**Respuesta exitosa `200`:**
```json
{
    "id": 1,
    "nombre_cargo": "Senior Developer",
    "salario_base": 5000000,
    "estado": "activo"
}
```

---

#### DELETE /api/cargos/{id}

**Respuesta exitosa `200`:**
```json
{
    "message": "Cargo eliminado correctamente"
}
```

---

#### GET /api/cargos/{id}/funciones

Lista todas las funciones de un cargo específico.

**Respuesta exitosa `200`:**
```json
[
    {
        "id": 1,
        "descripcion_funcion": "Gestionar equipo de desarrollo",
        "estado": "activo",
        "id_cargo": 1
    }
]
```

---

### Empleados

#### GET /api/empleados

Lista todos los empleados con su cargo.

**Respuesta exitosa `200`:**
```json
[
    {
        "id": 1,
        "nombres": "Juan",
        "apellidos": "Pérez",
        "salario": 2500000,
        "estado": "activo",
        "cargo": {
            "id": 1,
            "nombre_cargo": "Desarrollador"
        }
    }
]
```

**Sin registros:**
```json
{
    "message": "No se encontraron empleados registrados"
}
```

---

#### POST /api/empleados

**Body:**
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

**Validaciones:**
- `nombres`, `apellidos`: requeridos, texto, máximo 255 caracteres
- `fecha_nacimiento`, `fecha_ingreso`: requeridos, formato `YYYY-MM-DD`
- `salario`: requerido, numérico, mayor o igual a 0
- `estado`: requerido, valores permitidos: `activo` o `inactivo`
- `id_cargo`: requerido, debe existir en la tabla `cargos`

**Respuesta exitosa `201`:**
```json
{
    "id": 1,
    "nombres": "Juan",
    "apellidos": "Pérez",
    "salario": 2500000,
    "estado": "activo",
    "cargo": {
        "id": 1,
        "nombre_cargo": "Desarrollador"
    }
}
```

---

#### GET /api/empleados/{id}

Detalle completo del empleado: nombre, cargo, salario y funciones del cargo.

**Respuesta exitosa `200`:**
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
        },
        {
            "id": 2,
            "descripcion_funcion": "Revisar código",
            "estado": "activo"
        }
    ]
}
```

---

#### PUT /api/empleados/{id}

Solo se envían los campos a modificar.

**Body:**
```json
{
    "nombres": "Carlos",
    "apellidos": "González"
}
```

**Respuesta exitosa `200`:**
```json
{
    "id": 1,
    "nombres": "Carlos",
    "apellidos": "González",
    "salario": 2500000,
    "estado": "activo"
}
```

---

#### DELETE /api/empleados/{id}

**Respuesta exitosa `200`:**
```json
{
    "message": "Empleado eliminado correctamente"
}
```

---

### Funciones de Cargo

#### GET /api/funciones

Lista todas las funciones con su cargo.

**Sin registros:**
```json
{
    "message": "No se encontraron funciones registradas"
}
```

---

#### POST /api/funciones

**Body:**
```json
{
    "descripcion_funcion": "Gestionar equipo de desarrollo",
    "estado": "activo",
    "id_cargo": 1
}
```

**Validaciones:**
- `descripcion_funcion`: requerido, texto
- `estado`: requerido, valores permitidos: `activo` o `inactivo`
- `id_cargo`: requerido, debe existir en la tabla `cargos`

**Respuesta exitosa `201`:**
```json
{
    "id": 1,
    "descripcion_funcion": "Gestionar equipo de desarrollo",
    "estado": "activo",
    "cargo": {
        "id": 1,
        "nombre_cargo": "Desarrollador"
    }
}
```

---

#### DELETE /api/funciones/{id}

**Respuesta exitosa `200`:**
```json
{
    "message": "Función eliminada correctamente"
}
```

---

## Errores comunes

| Código | Descripción | Solución |
|--------|-------------|----------|
| 401 | Token ausente o inválido | Agrega `Authorization: Bearer {token}` |
| 404 | Recurso no encontrado | Verifica que el ID exista |
| 422 | Error de validación | Revisa los campos enviados |

**Ejemplo error de validación `422`:**
```json
{
    "message": "The nombre cargo field is required.",
    "errors": {
        "nombre_cargo": ["The nombre cargo field is required."]
    }
}
```

---

## Flujo recomendado para probar la API

1. Clona el repositorio
2. Instala dependencias con `composer install`
3. Copia `.env.example` como `.env`
4. Configura las credenciales de base de datos en `.env`
5. Crea la base de datos si no existe
6. Ejecuta `php artisan key:generate`
7. Ejecuta `php artisan migrate --seed`
8. Levanta el servidor con `php artisan serve`
9. Regístrate en `POST /api/register`
10. Guarda el token recibido
11. Usa el token en el header `Authorization: Bearer {token}`
12. Prueba los endpoints de cargos, empleados y funciones

---

## Tests

```bash
php artisan test
```

Para ejecutar tests específicos:

```bash
php artisan test --filter=CargoTest
php artisan test --filter=EmpleadoTest
php artisan test --filter=FuncionCargoTest
```

Resultado esperado:

```
Tests: 22 passed (60 assertions)
```

---

## Tecnologías

| Tecnología | Uso |
|------------|-----|
| Laravel 13 | Framework principal |
| Sanctum | Autenticación con tokens |
| MySQL | Base de datos en producción |
| SQLite | Base de datos en tests |
| PHPUnit / Pest | Framework de testing |
