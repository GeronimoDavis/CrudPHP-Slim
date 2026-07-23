# Sistema de Gestión de Proyectos y Tareas

Una aplicación web para gestionar proyectos y sus tareas asociadas. Permite a los usuarios crear cuentas, gestionar proyectos, crear tareas dentro de cada proyecto y controlar el estado de las mismas.

## Descripción General

Este sistema implementa una arquitectura **MVC (Modelo-Vista-Controlador)** construido con el framework **Slim 4** y utiliza **MySQL** como base de datos. El proyecto está diseñado para facilitar la organización y seguimiento de tareas dentro de proyectos específicos.

### Características Principales

- **Autenticación de Usuarios**: Registro e inicio de sesión con contraseñas encriptadas
- **Gestión de Proyectos**: Crear, visualizar, editar y eliminar proyectos
- **Gestión de Tareas**: Crear, visualizar, editar y eliminar tareas dentro de proyectos
- **Control de Estado**: Las tareas pueden marcarse como "Pendiente" o "Completada"
- **Interfaz Intuitiva**: Navegación simple y fácil de usar

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Composer
- Navegador web moderno

## Estructura del Proyecto

```
Slim/
├── public/                 # Punto de entrada (index.php)
├── src/
│   ├── Config/            # Configuración (conexión a BD)
│   │   └── DB.php
│   ├── Controllers/       # Controladores MVC
│   │   ├── UsuarioControllers.php
│   │   ├── ProyectoControllers.php
│   │   └── TareaController.php
│   ├── Entities/          # Modelos de datos
│   │   ├── Usuario.php
│   │   ├── Proyecto.php
│   │   └── Tarea.php
│   ├── Services/          # Lógica de negocio
│   │   ├── UsuarioServices.php
│   │   ├── ProyectoServices.php
│   │   └── TareaServices.php
│   └── Routes/            # Definición de rutas
│       ├── UsuarioRoutes.php
│       ├── ProyectoRoutes.php
│       └── TareaRoutes.php
├── views/                 # Vistas HTML
│   ├── registroLogin.php
│   ├── verProyectos.php
│   └── verTareas.php
├── vendor/                # Dependencias (Composer)
└── composer.json
```

## Arquitectura y Componentes

### Entidades (Models)
Las entidades representan los objetos principales del sistema:

- **Usuario**: Contiene id, nombre, email y contraseña encriptada
- **Proyecto**: Contiene id, nombre, descripción y usuario_id (propietario)
- **Tarea**: Contiene id, descripción, estado y proyecto_id

### Servicios (Business Logic)
Los servicios manejan la lógica de negocio e interacción con la base de datos:

- **UsuarioServices**: Gestiona registro, login y validación
- **ProyectoServices**: Operaciones CRUD de proyectos
- **TareaServices**: Operaciones CRUD de tareas

### Controladores (Controllers)
Los controladores reciben solicitudes HTTP y coordinan entre servicios y vistas:

- **UsuarioControllers**: Maneja autenticación y registro
- **ProyectoControllers**: Gestiona operaciones de proyectos
- **TareaController**: Gestiona operaciones de tareas

### Vistas (Views)
Las vistas presentan la interfaz de usuario con HTML y CSS:

- **registroLogin.php**: Formularios de registro e inicio de sesión
- **verProyectos.php**: Lista de proyectos y formulario de creación
- **verTareas.php**: Lista de tareas y formulario de creación con modal de edición

## Flujo de la Aplicación

```
1. Autenticación
   ├─ Usuario se registra
   ├─ Usuario inicia sesión
   └─ Se guarda la sesión

2. Gestión de Proyectos
   ├─ Ver proyectos del usuario
   ├─ Crear nuevo proyecto
   ├─ Editar proyecto
   └─ Eliminar proyecto

3. Gestión de Tareas
   ├─ Ver tareas de un proyecto
   ├─ Crear tarea
   ├─ Editar descripción y estado
   └─ Eliminar tarea
```

## Base de Datos

### Tablas Principales

**usuarios**
- id (INT, PK, AUTO_INCREMENT)
- nombre (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR)

**proyectos**
- id (INT, PK, AUTO_INCREMENT)
- nombre (VARCHAR)
- descripcion (TEXT)
- usuario_id (INT, FK)

**tareas**
- id (INT, PK, AUTO_INCREMENT)
- descripcion (VARCHAR)
- estado (ENUM: 'pendiente', 'completada')
- proyecto_id (INT, FK)

## Configuración

### 1. Clonar o descargar el proyecto

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar la base de datos
Edita [src/Config/DB.php](src/Config/DB.php) con tus credenciales:
```php
private $host = 'localhost';
private $user = 'root';
private $pass = '';
private $dbname = 'practica_slim';
```

### 4. Crear la base de datos
Ejecuta el archivo [src/Config/sqlDb.sql](src/Config/sqlDb.sql) en MySQL para crear las tablas.

### 5. Iniciar el servidor
```bash
php -S localhost:8000 -t public
```

Accede a `http://localhost:8000` en tu navegador.

## Rutas Disponibles

### Autenticación
- `GET /usuarios/showForm/{action}` - Mostrar formularios de login/registro
- `POST /usuarios/register` - Registrar nuevo usuario
- `POST /usuarios/login` - Iniciar sesión

### Proyectos
- `GET /proyectos/show` - Ver todos los proyectos del usuario
- `POST /proyectos/create` - Crear nuevo proyecto
- `POST /proyectos/update/{id}` - Actualizar proyecto
- `POST /proyectos/delete/{id}` - Eliminar proyecto

### Tareas
- `GET /tareas/show/{proyecto_id}` - Ver tareas de un proyecto
- `POST /tareas/create` - Crear nueva tarea
- `POST /tareas/update/{tarea_id}` - Actualizar tarea
- `POST /tareas/delete/{proyecto_id}/{tarea_id}` - Eliminar tarea

## Características Técnicas

- **Middleware**: Parseo de solicitudes HTTP, manejo de errores y métodos override
- **Sesiones**: Gestión de sesiones para mantener usuarios autenticados
- **Seguridad**: Contraseñas hasheadas con BCRYPT, escape de caracteres especiales
- **Base de Datos**: Conexión PDO con consultas preparadas para prevenir SQL injection
- **Manejo de Errores**: Try-catch en todos los servicios con mensajes descriptivos

## Notas de Desarrollo

- Las contraseñas se hashean usando `PASSWORD_BCRYPT` para máxima seguridad
- Todas las solicitudes validadas antes de procesarse
- Las vistas incluyen protección de sesión para evitar accesos no autorizados
- Se utiliza output buffering en vistas para integración con Slim
- Los formularios de tareas incluyen modal interactivo para edición

## Flujo de Ejemplo

1. Usuario accede a `/usuarios/showForm/registro`
2. Completa el formulario y envía (POST a `/usuarios/register`)
3. Si es válido, redirige a login
4. Usuario inicia sesión y ve sus proyectos
5. Crea un nuevo proyecto
6. Dentro del proyecto, crea tareas
7. Puede editar tareas usando el modal interactivo
8. O eliminar tareas según sea necesario

---

**Última actualización**: Julio 2026
