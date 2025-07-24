<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Sobre el Proyecto
Este es un proyecto desarrollado en Laravel como parte del curso de Ingeniería De Software. 

## Instalación

Para instalar y configurar el proyecto, sigue los siguientes pasos:

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/OscarCastellanos01/sistema_encuesta_hospital

2. **Navega al directorio del proyecto:**
   ```bash
   cd sistema_encuesta_hospital

3. **Instala las dependencias del proyecto:**
   ```bash
   composer install

4. **Instala las liberías del proyecto:**
   ```bash
   npm install

5. **Copia el archivo de entorno de ejemplo y renómbralo:**
   ```bash
   cp .env.example .env

6. Configura tu archivo .env con las credenciales de tu base de datos y otras configuraciones necesarias.

7. **Genera la clave de la aplicación:**
   ```bash
   php artisan key:generate

8. **Ejecuta las migraciones y seeders para crear las tablas en la base de datos y sus registros:**
   ```bash
   php artisan migrate --seed

9. **Inicia Vite:**
   ```bash
   npm run dev

10. **Inicia el servidor:**
    ```bash
    php artisan serve

## Uso

Accede al proyecto en tu navegador en la siguiente dirección: http://localhost:8000