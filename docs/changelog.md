# Historial de Cambios (Changelog)

Registro de cambios y progreso del desarrollo de Academia Profesional.

## [Fase 1] Base de Datos y Fundamentos - *Completado*
**Fecha:** 18 de Enero de 2026

Se ha establecido la base sólida del sistema, incluyendo el esquema de base de datos, modelos Eloquent y configuración de librerías esenciales.

### Cambios Realizados:
- **Diseño de Base de Datos**: Definición de esquema relacional para Usuarios, Profesores, Estudiantes, Cursos, Lecciones, Matrículas y Pagos.
- **Migraciones**:
    - Creación de tablas personalizadas: `teachers`, `students`, `courses`, `lessons`, `enrollments`, `payments`.
    - Integración de tablas de librerías: `roles`, `permissions`, `media`.
- **Modelos Eloquent**:
    - Implementación de relaciones (1:1, 1:N, N:M).
    - Configuración de atributos `fillable` y `casts`.
    - Integración de Traits:
        - `HasRoles` (Spatie) en `User`.
        - `InteractsWithMedia` (Spatie) en `User`, `Course`, `Lesson`.
- **Factories**: Generación de fábricas para todos los modelos para facilitar el testing y seeding.
- **Librerías**:
    - Instalación y configuración de `spatie/laravel-permission`.
    - Instalación y configuración de `spatie/laravel-medialibrary`.
    - Publicación de archivos de configuración y assets.
- **Configuración**: Ajuste de variables de entorno (`DB_CONNECTION`, `DB_DATABASE`).

---

## [Fase 2 y 3] Estructura, Autenticación y Seguridad - *Completado*
**Fecha:** 03 de Febrero de 2026

Implementación de la estructura del proyecto, configuración de autenticación y sistema de roles/permisos.

### Cambios Realizados:
- **Estructura de Directorios**: Creación de carpetas `Controllers/Web` y `Controllers/Api` para separación lógica.
- **Rutas**:
    - **Web**: Separación en grupos `public` y `middleware(['auth', 'verified'])`.
    - **API**: Instalación de Laravel Sanctum y configuración de `routes/api.php` con middleware `auth:sanctum`.
- **Autenticación**:
    - Integración con el stack existente (Inertia + Fortify).
    - Añadido trait `HasApiTokens` al modelo `User`.
- **Roles y Permisos**:
    - Creación de `RolesAndPermissionsSeeder` con roles: `admin`, `manager`, `teacher`, `student`, `api_client`.
    - Definición de permisos básicos (`manage courses`, etc.).
    - Creación de usuarios de prueba (Admin y Manager) en el seeder.
- **Políticas (Policies)**:
    - Creación de `CoursePolicy` y `EnrollmentPolicy` con lógica de autorización basada en roles.

---
