#  Proyecto RDS - API REST con Laravel

API REST desarrollada con **Laravel** para la administración de:

-  Cargos
- ‍ Empleados
-  Funciones de cada cargo

La autenticación se realiza mediante **Laravel Sanctum**, por lo que la mayoría de los endpoints requieren un token de acceso.

---

#  Tecnologías utilizadas

- PHP 8.3+
- Laravel
- Laravel Sanctum
- MySQL
- Composer
- Node.js
- npm
- Vite

---

#  Requisitos

Antes de ejecutar el proyecto debes tener instalado:

- PHP 8.3 o superior
- Composer
- MySQL
- Node.js
- npm
- Git

## Instalar Node.js y npm

1. Ingresa a: https://nodejs.org
2. Descarga la versión **LTS**.
3. Instálala.
4. Verifica que todo quedó correctamente:

```bash
node -v
npm -v
```

---

# Instalación del proyecto

## 1. Clonar el repositorio

```bash
git clone https://github.com/AndersonMarulanda/proyecto_rds_3066552_.git
cd proyecto_rds_3066552_
```

## 2. Instalar dependencias

```bash
composer install
npm install
```

## 3. Crear el archivo .env

Linux:

```bash
cp .env.example .env
```

Windows:

```powershell
Copy-Item .env.example .env
```

## 4. Configurar la base de datos

Editar el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_3066552
DB_USERNAME=root
DB_PASSWORD=
```

Crear la base de datos:

```sql
CREATE DATABASE db_3066552;
```

## 5. Generar la clave de Laravel

```bash
php artisan key:generate
```

## 6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Si deseas reiniciar toda la base de datos:

```bash
php artisan migrate:fresh --seed
```

---

# Ejecutar el proyecto

```bash
php artisan serve
```

La API quedará disponible en:

```text
http://127.0.0.1:8000/api
```

---

#  Autenticación

## Registrar usuario

```bash
curl -X POST http://127.0.0.1:8000/api/register 
-H "Accept: application/json" 
-H "Content-Type: application/json" 
-d "{"name":"Anderson","email":"anderson@example.com","password":"12345678","password_confirmation":"12345678"}"
```

---

## Iniciar sesión

```bash
curl -X POST http://127.0.0.1:8000/api/login 
-H "Accept: application/json" 
-H "Content-Type: application/json" 
-d "{"email":"anderson@example.com","password":"12345678"}"
```

La respuesta devolverá un token:

```json
{
  "user": { },
  "token": "TOKEN_GENERADO"
}
```

Reemplaza `TU_TOKEN` en las siguientes peticiones.

---

#  CRUD DE CARGOS

## Listar cargos

```bash
curl -X GET http://127.0.0.1:8000/api/cargos 
-H "Authorization: Bearer TU_TOKEN"
```

## Obtener un cargo

```bash
curl -X GET http://127.0.0.1:8000/api/cargos/1 
-H "Authorization: Bearer TU_TOKEN"
```

## Crear un cargo

```bash
curl -X POST http://127.0.0.1:8000/api/cargos 
-H "Authorization: Bearer TU_TOKEN" 
-H "Content-Type: application/json" 
-d "{"nombre_cargo":"Desarrollador Backend","salario_base":3000000,"estado":"activo"}"
```

## Actualizar un cargo

```bash
curl -X PUT http://127.0.0.1:8000/api/cargos/1 
-H "Authorization: Bearer TU_TOKEN" 
-H "Content-Type: application/json" 
-d "{"nombre_cargo":"Desarrollador Senior","salario_base":4500000,"estado":"activo"}"
```

## Eliminar un cargo

```bash
curl -X DELETE http://127.0.0.1:8000/api/cargos/1 
-H "Authorization: Bearer TU_TOKEN"
```

---

## Obtener las funciones de un cargo

```bash
curl -X GET http://127.0.0.1:8000/api/cargos/1/funciones 
-H "Authorization: Bearer TU_TOKEN"
```

---

# ‍ CRUD DE EMPLEADOS

## Listar empleados

```bash
curl -X GET http://127.0.0.1:8000/api/empleados 
-H "Authorization: Bearer TU_TOKEN"
```

## Obtener un empleado

```bash
curl -X GET http://127.0.0.1:8000/api/empleados/1 
-H "Authorization: Bearer TU_TOKEN"
```

## Crear un empleado

```bash
curl -X POST http://127.0.0.1:8000/api/empleados 
-H "Authorization: Bearer TU_TOKEN" 
-H "Content-Type: application/json" 
-d "{"nombres":"Juan","apellidos":"Perez","fecha_nacimiento":"2000-05-20","fecha_ingreso":"2026-06-01","salario":2500000,"estado":"activo","id_cargo":1}"
```

## Actualizar un empleado

```bash
curl -X PUT http://127.0.0.1:8000/api/empleados/1 
-H "Authorization: Bearer TU_TOKEN" 
-H "Content-Type: application/json" 
-d "{"salario":3000000}"
```

## Eliminar un empleado

```bash
curl -X DELETE http://127.0.0.1:8000/api/empleados/1 
-H "Authorization: Bearer TU_TOKEN"
```

---

#  CRUD DE FUNCIONES

## Listar funciones

```bash
curl -X GET http://127.0.0.1:8000/api/funciones 
-H "Authorization: Bearer TU_TOKEN"
```

## Obtener una función

```bash
curl -X GET http://127.0.0.1:8000/api/funciones/1 
-H "Authorization: Bearer TU_TOKEN"
```

## Crear una función

```bash
curl -X POST http://127.0.0.1:8000/api/funciones 
-H "Authorization: Bearer TU_TOKEN" 
-H "Content-Type: application/json" 
-d "{"descripcion_funcion":"Administrar servidores","estado":"activo","id_cargo":1}"
```

## Actualizar una función

```bash
curl -X PUT http://127.0.0.1:8000/api/funciones/1 
-H "Authorization: Bearer TU_TOKEN" 
-H "Content-Type: application/json" 
-d "{"descripcion_funcion":"Gestionar infraestructura"}"
```

## Eliminar una función

```bash
curl -X DELETE http://127.0.0.1:8000/api/funciones/1 
-H "Authorization: Bearer TU_TOKEN"
```

---

#  Ejecutar pruebas

```bash
php artisan test
```

---

#  Estructura de la API

| Método | Endpoint | Descripción |
|--------|-----------|-------------|
| POST | /api/register | Registrar usuario |
| POST | /api/login | Iniciar sesión |
| POST | /api/logout | Cerrar sesión |
| GET | /api/cargos | Listar cargos |
| GET | /api/cargos/{id} | Obtener cargo |
| POST | /api/cargos | Crear cargo |
| PUT | /api/cargos/{id} | Actualizar cargo |
| DELETE | /api/cargos/{id} | Eliminar cargo |
| GET | /api/cargos/{id}/funciones | Funciones del cargo |
| GET | /api/empleados | Listar empleados |
| POST | /api/empleados | Crear empleado |
| GET | /api/funciones | Listar funciones |
| POST | /api/funciones | Crear función |

---


