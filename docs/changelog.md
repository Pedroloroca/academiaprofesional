# Historial de Cambios (Changelog)

Registro de cambios y progreso del desarrollo de Academia Profesional.

## [Fase 1] Base de Datos y Fundamentos - *Completado*
**Fecha:** 18 de Enero de 2026

Se ha establecido la base sÃ³lida del sistema, incluyendo el esquema de base de datos, modelos Eloquent y configuraciÃ³n de librerÃ­as esenciales.

### Cambios Realizados:
- **DiseÃ±o de Base de Datos**: DefiniciÃ³n de esquema relacional para Usuarios, Profesores, Estudiantes, Cursos, Lecciones, MatrÃ­culas y Pagos.
- **Migraciones**:
    - CreaciÃ³n de tablas personalizadas: `teachers`, `students`, `courses`, `lessons`, `enrollments`, `payments`.
    - IntegraciÃ³n de tablas de librerÃ­as: `roles`, `permissions`, `media`.
- **Modelos Eloquent**:
    - ImplementaciÃ³n de relaciones (1:1, 1:N, N:M).
    - ConfiguraciÃ³n de atributos `fillable` y `casts`.
    - IntegraciÃ³n de Traits:
        - `HasRoles` (Spatie) en `User`.
        - `InteractsWithMedia` (Spatie) en `User`, `Course`, `Lesson`.
- **Factories**: GeneraciÃ³n de fÃ¡bricas para todos los modelos para facilitar el testing y seeding.
- **LibrerÃ­as**:
    - InstalaciÃ³n y configuraciÃ³n de `spatie/laravel-permission`.
    - InstalaciÃ³n y configuraciÃ³n de `spatie/laravel-medialibrary`.
    - PublicaciÃ³n de archivos de configuraciÃ³n y assets.
- **ConfiguraciÃ³n**: Ajuste de variables de entorno (`DB_CONNECTION`, `DB_DATABASE`).

---

## [Fase 2 y 3] Estructura, AutenticaciÃ³n y Seguridad - *Completado*
**Fecha:** 03 de Febrero de 2026

ImplementaciÃ³n de la estructura del proyecto, configuraciÃ³n de autenticaciÃ³n y sistema de roles/permisos.

### Cambios Realizados:
- **Estructura de Directorios**: CreaciÃ³n de carpetas `Controllers/Web` y `Controllers/Api` para separaciÃ³n lÃ³gica.
- **Rutas**:
    - **Web**: SeparaciÃ³n en grupos `public` y `middleware(['auth', 'verified'])`.
    - **API**: InstalaciÃ³n de Laravel Sanctum y configuraciÃ³n de `routes/api.php` con middleware `auth:sanctum`.
- **AutenticaciÃ³n**:
    - IntegraciÃ³n con el stack existente (Inertia + Fortify).
    - AÃ±adido trait `HasApiTokens` al modelo `User`.
- **Roles y Permisos**:
    - CreaciÃ³n de `RolesAndPermissionsSeeder` con roles: `admin`, `manager`, `teacher`, `student`, `api_client`.
    - DefiniciÃ³n de permisos bÃ¡sicos (`manage courses`, etc.).
    - CreaciÃ³n de usuarios de prueba (Admin y Manager) en el seeder.
- **PolÃ­ticas (Policies)**:
    - CreaciÃ³n de `CoursePolicy` y `EnrollmentPolicy` con lÃ³gica de autorizaciÃ³n basada en roles.

---

## [Fase 4 - Revisión] Auditoría Técnica y Refactorización de Testing
**Fecha:** 25 de Abril de 2026

Auditoría completa de las fases 1-4, corrección de errores críticos en arquitectura y puesta en marcha de un entorno de pruebas robusto con Pest.

### Cambios Realizados:
- **Auditoría de Modelos**:
    - Corregido modelo Enrollment (cambiado de Pivot a Model) para habilitar Factories.
    - Añadido trait HasFactory en Lesson y Payment.
- **Seguridad y Autorización**:
    - Registro de CoursePolicy y EnrollmentPolicy en AppServiceProvider.
    - Refactorización de lógica en CoursePolicy (null-checks y visibilidad pública).
- **Rutas API**:
    - Registrada ruta para TeacherController en api.php.
- **Datos de Demo**:
    - Creación de DemoDataSeeder para poblar el sistema con datos reales de prueba.
- **Entorno de Testing (Pest)**:
    - Creación de base de datos de testing academiaprofesional_testing.
    - Reorganización total de tests en carpetas: Api, Web (Auth, Settings, General) y Authorization.
    - Corrección de tests de boilerplate (rutas public.home, CSRF y aserciones de Fortify).
    - Verificación de 69 tests pasando al 100%.

---

## [Fase 7 y 8] Frontend, Navegación, Blade Auth y Procesos Asíncronos - *Completado*
**Fecha:** 1 de Mayo de 2026

Migración total del frontend de Vue a Blade Auth, eliminación de Inertia, creación de navegación y landing page, y desarrollo de lógica de eventos, listeners y jobs.

### Cambios Realizados:
- **Rediseño Frontend & Navegación**:
    - Creación del componente HomePage para landing page.
    - Creación de barra de navegación dinámica en Livewire.
- **Migración a Blade Auth**:
    - Eliminación completa de `@inertiajs/vue3` y `vue` para acelerar compilación.
    - Eliminación de plantillas Vue y reemplazo de autenticación por vistas Blade en `/login` y `/register`.
- **Eventos y Listeners (5 de cada uno por regla 2.5x)**:
    - `StudentEnrolled` -> `SendWelcomeEmail`
    - `CoursePublished` -> `NotifyStudentsAboutNewCourse`
    - `LessonCompleted` -> `UpdateCourseProgress`
    - `PaymentReceived` -> `GenerateInvoicePDF`
    - `TeacherAssigned` -> `NotifyTeacherOfAssignment`
- **Jobs de Fondo (5 en total, 3 en cola + 2 síncronos)**:
    - **Background:** `ProcessVideoUpload`, `GenerateCourseCertificate`, `BulkEmailStudents`.
    - **Síncronos:** `CalculateStudentGPA`, `UpdateCourseStats`.

---

## [Fase 8 - Refuerzo y WYSIWYG] Correcciones Avanzadas y SoftDeletes
**Fecha:** 2 de Mayo de 2026

### Cambios Realizados:
- **WYSIWYG Trix Editor**: Integración de editor rico para el campo `explanation` en Cursos y Lecciones.
- **SafeDelete / SoftDeletes**: Implementación de borrado suave para recuperar o borrar permanentemente cursos desde un Recycle Bin accesible solo a administradores.
- **Corrección de Rendimiento y Bloqueos (Hydration/Roles loops)**:
    - Eliminación de Eloquent Collections de las propiedades públicas en Livewire para evitar tiempos de espera excesivos (30s exceeded).
    - Optimización en el cálculo de roles (`isAdminOrManager`, `$isTeacher`, `$isStudent`) en el componente PHP una sola vez para prevenir recursividad del motor Blade/Spatie.

---

## [Fase 9] Comandos de Consola - *Completado*
**Fecha:** 3 de Mayo de 2026

### Cambios Realizados:
- **8 Comandos Artisan Personalizados**:
    - `academy:recalculate-stats`: Calcula estadísticas de cursos.
    - `academy:sync-external-data`: Sincroniza datos con un API externa real.
    - `academy:cleanup-old-enrollments`: Limpia matrículas antiguas según el número de días.
    - `academy:generate-monthly-report`: Genera un reporte mensual de actividad.
    - `academy:seed-demo-data`: Genera datos de prueba de manera rápida.
    - `academy:notify-teachers`: Notifica a los profesores de sus alumnos matriculados.
    - `academy:archive-old-courses`: Archiva cursos antiguos.
    - `academy:unpublish-empty-courses`: Comando alternativo para despublicar cursos con cero alumnos.
- **Invocación interna desde el código**:
    - `academy:recalculate-stats` se invoca dentro del Job `UpdateCourseStats`.
    - `academy:cleanup-old-enrollments` se invoca dentro del Job `CalculateStudentGPA`.
- **Tests de Consola**: Creación de tests automáticos en Pest para verificar el correcto funcionamiento de todos los comandos Artisan.

---

## [Fase 10] Emails y Notificaciones - *Completado*
**Fecha:** 3 de Mayo de 2026

### Cambios Realizados:
- **4 Mailables creadas en `app/Mail`**:
    - `EnrollmentConfirmation`: Confirmación de matrícula.
    - `LessonReminder`: Recordatorio de lección.
    - `PaymentReceived`: Confirmación de pago recibido.
    - `MonthlySummary`: Resumen mensual para profesores y administradores.
- **4 Plantillas Blade para correos creadas** en `resources/views/emails/`.
- **Integración de envío automático** en los listeners:
    - Al registrar una matrícula (`StudentEnrolled` -> `SendWelcomeEmail`).
    - Al realizar un pago (`PaymentReceived` -> `GenerateInvoicePDF`).
- **Tests**: Pruebas automáticas Pest creadas y pasando al 100%.

---

## [Fase 11] Generación de PDF - *Completado*
**Fecha:** 3 de Mayo de 2026

### Cambios Realizados:
- **Instalación y configuración de `barryvdh/laravel-dompdf`**.
- **Creación de 5 plantillas Blade para PDFs** (`resources/views/pdfs/`).
- **Creación del `PdfController`** con rutas para:
    - Descargar Carta de Bienvenida (`pdf.welcome`).
    - Descargar Factura de Matrícula (`pdf.invoice`).
    - Descargar Certificado del Curso (`pdf.certificate`).
    - Descargar Catálogo de Cursos (`pdf.course-catalog`).
    - Descargar Reporte para Profesores (`pdf.teacher-report`).
- **Integración de envío automático** de la factura en PDF adjunta al correo de confirmación de matrícula (`EnrollmentConfirmation`).
- **Tests**: Pruebas automáticas Pest creadas y pasando al 100%.





