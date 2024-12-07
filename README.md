# Proyecto UD2 - Cliente para una API Rest

## Resumen del Proyecto
Este proyecto tiene como finalidad crear un cliente que interactúe con una API REST construida con Laravel. Cuenta con dos partes principales:

Backend (Laravel): Ofrece endpoints para realizar operaciones CRUD sobre diversos recursos.
Frontend (Vue.js): Consume los endpoints del backend y muestra una interfaz de usuario clara e intuitiva.
## Organización del Proyecto
La estructura del proyecto es:

```
practica2BrunoRuiz/
├── backend/     # Código del backend en Laravel
└── frontend/    # Código del frontend en Vue.Js
```

- **`backend/`**: Incluye el código de Laravel junto con las rutas para `Storage`, `Json` y `CSV`.
- **`frontend/`**: Contiene el proyecto en Vue.js que se comunica con el backend.

## Requerimientos del Proyecto

### Backend
- **PHP**: Versión 8.2 o superior
- **Composer**: Para gestionar dependencias en Laravel
- **Docker**: Para levantar el entorno del backend sin complicaciones

### Frontend
- **Node.js**: Versión 16 o superior
- **NPM**: Para manejar dependencias de la aplicación Vue.js
- **Vue CLI**: Para crear y ejecutar el proyecto Vue.js

## Pasos para Iniciar el Entorno de Desarrollo

### 1. Clonar el Repositorio
Clona el repositorio desde GitHub:

```sh
git clone https://github.com/brunoruizlafuente/practica2BrunoRuiz.git
```

### 2. Iniciar el Backend con Docker

**Ir a la carpeta raíz del proyecto**:

```sh
cd practica2BrunoRuiz
```

**Levantar el Backend**:

```sh
docker-compose up -d --build
```

Esto iniciará el contenedor del backend en el puerto `8000`.

**Verificar el Backend**:

Comprueba que el contenedor se esté ejecutando:
```sh
docker ps
```

Abre tu navegador en `http://localhost:8000/api/hello` para confirmar que el backend funciona correctamente.

### 3. Iniciar el Frontend con Vue.js

**Ingresar a la carpeta `frontend`**:

```sh
cd frontend
```

**Instalar dependencias**:

```sh
npm install
```

**Levantar el servidor de desarrollo**:

```sh
npm run serve
```

Por defecto, se ejecuta en `http://localhost:8080`. Asegúrate de que el backend esté activo antes de probar el frontend.

### 4. Probar la Aplicación

Abre `http://localhost:8080` en tu navegador.
Selecciona una opción del desplegable (`Json`, `Storage`, `Csv`).
Prueba las operaciones (`Mostrar archivos`, `Buscar por ID`, etc.) para interactuar con el backend.

## Configuración del Entorno

### Archivos de Configuración

- **`Dockerfile`**: Define el entorno Docker para el `backend` (Laravel/PHP).
- **`docker-compose.yml`**: Configura y levanta el contenedor del `backend`.
- **`vue.config.js`**: Ajusta el puerto `8080` y otras opciones para el frontend en `Vue.js`.

## Comandos de Referencia

### Iniciar Backend:

```sh
docker-compose up -d --build
```

### Iniciar Frontend (desde la carpeta frontend):

```sh
npm run serve
```

### Limpiar Caché de Laravel:

```sh
docker-compose exec backend php artisan config:cache
```

## Consideraciones
- Mantén el `backend` y el `frontend` corriendo simultáneamente para ver la aplicación completa.