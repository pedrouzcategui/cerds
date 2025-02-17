# Sistema de administración de cursos CERDS

El sistema de administración para cursos de CERDS permite gestionar estudiantes, cursos, instructores y laboratorios de manera eficiente.

## Características

- **Gestión de Estudiantes**: Crear, editar y eliminar perfiles de estudiantes.
- **Gestión de Cursos**: Crear, editar y eliminar cursos, asignar instructores y laboratorios, y definir el estado del curso.
- **Gestión de Instructores**: Crear, editar y eliminar perfiles de instructores.
- **Gestión de Laboratorios**: Crear, editar y eliminar laboratorios donde se dictan los cursos.
- **Autenticación**: Verificación de usuarios para acceder a las funcionalidades del sistema.
- **Interfaz de Usuario Intuitiva**: Diseño amigable y fácil de usar con navegación lateral.

## Instrucciones de Instalación

1. Clonar el repositorio en el directorio deseado:

   ```bash
   git clone https://github.com/pedrouzcategui/sistema-cursos.git
   ```

2. Navegar al directorio del proyecto:

   ```bash
   cd sistema-cursos
   ```

3. Configurar la base de datos en el archivo `config/database.php`.

4. Ejecutar las migraciones para crear las tablas necesarias:

   ```bash
   php artisan migrate
   ```

5. Iniciar el servidor local:

   ```bash
   php -S localhost:8000
   ```

6. Acceder al sistema a través del navegador:
   ```
   http://localhost:8000
   ```

## Requisitos del Sistema

- PHP >= 7.4
- MySQL
- Composer

## Contribuciones

Las contribuciones son bienvenidas. Por favor, envía un pull request o abre un issue para discutir los cambios que deseas realizar.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.
