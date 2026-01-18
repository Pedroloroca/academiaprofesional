Guía de desarrollo para IA – Aplicación web de academia
Esta guía está pensada para que una IA de desarrollo implemente una aplicación web de una academia usando Laravel + Vue + Livewire, cumpliendo todos los requisitos indicados.

1. Contexto general del proyecto
Objetivo:  
Desarrollar una aplicación web para una academia con:

Parte pública (sin autenticación).

Parte privada (con autenticación y roles).

API paralela documentada.

Uso intensivo de características avanzadas de Laravel.

Stack obligatorio:

Backend: Laravel (versión actual LTS).

Frontend: Vue + Blade + Livewire.

Base de datos: MySQL o PostgreSQL.

Colas: database o Redis.

Tests: Pest.

2. Modelado del dominio
2.1. Modelos mínimos (7)
Definir al menos estos 7 modelos con sus migraciones:

User

Student

Teacher

Course

Lesson

Enrollment (pivot entre Student y Course, con columnas extra)

Payment (o Exam, pero elegir uno y usarlo de forma coherente)

2.2. Relaciones
Implementar:

1:n

Teacher → Course

Course → Lesson

n:n con pivot especial

Student ↔ Course mediante Enrollment

La tabla pivot enrollments debe tener columnas adicionales, por ejemplo:

enrolled_at (datetime)

status (string)

final_grade (decimal o integer)

Estas columnas deben ser gestionadas desde el código (formularios, validación, lógica).

3. Estructura del proyecto y organización
3.1. Estructura de carpetas
Organizar el código de forma explícita:

Controladores web:

App/Http/Controllers/Web/...

Controladores API:

App/Http/Controllers/Api/...

Componentes Livewire:

App/Http/Livewire/...

Policies:

App/Policies/...

Jobs:

App/Jobs/...

Events:

App/Events/...

Listeners:

App/Listeners/...

Comandos:

App/Console/Commands/...

3.2. Autenticación
Usar Laravel Breeze o Jetstream (elegir uno) para:

Registro, login, logout, reset de contraseña.

Proteger la parte privada con middleware auth (y verified si aplica).

4. Rutas públicas y privadas
4.1. Rutas públicas (sin autenticación)
En routes/web.php:

Definir un grupo de rutas públicas, por ejemplo con name('public.').

Ejemplos:

Página de inicio.

Listado de cursos públicos.

Detalle de curso.

Formulario de contacto.

4.2. Rutas privadas (con autenticación)
En routes/web.php:

Definir un grupo con middleware auth.

Secciones típicas:

Gestión de cursos.

Gestión de alumnos.

Gestión de profesores.

Gestión de matrículas.

Panel de administración.

Las rutas deben estar ordenadas y agrupadas por contexto (por ejemplo, usando Route::prefix('courses') y name('courses.')).

5. Roles, permisos y policies
5.1. Roles y permisos (laravel-permission)
Instalar y configurar spatie/laravel-permission.

Definir 5 roles, por ejemplo:

admin

manager

teacher

student

api_client (o similar)

Definir permisos, por ejemplo:

manage courses

manage students

manage teachers

manage enrollments

view reports

Crear seeders para:

Crear roles y permisos.

Asignar un usuario administrador inicial.

5.2. Policies (2 con contenido real)
Crear al menos 2 policies con lógica de autorización:

CoursePolicy

Métodos: view, create, update, delete.

Usar roles y/o permisos para decidir acceso.

EnrollmentPolicy

Métodos: view, create, update, delete.

Controlar quién puede gestionar matrículas (por ejemplo, admin/manager/teacher).

Registrar las policies en AuthServiceProvider.

6. API paralela
6.1. Modelos y CRUDs
Usar los 7 modelos definidos.

Implementar 5 CRUDs completos en la API (REST), por ejemplo:

Course

Student

Teacher

Lesson

Enrollment

Cada CRUD debe tener:

index, show, store, update, destroy.

Validación mediante FormRequest cuando haya más de 2 campos.

6.2. Autenticación en la API
Usar Laravel Sanctum (o Passport, pero elegir uno).

Al menos uno de los CRUDs debe requerir autenticación, por ejemplo:

EnrollmentController protegido con auth:sanctum.

6.3. Rutas API
En routes/api.php:

Definir rutas apiResource para los 5 CRUDs.

Agrupar rutas protegidas con middleware de autenticación.

6.4. Documentación funcional de la API
Generar documentación funcional de la API que incluya:

Listado de endpoints.

Método HTTP.

Parámetros de entrada.

Ejemplos de request/response.

Códigos de estado.

Indicar qué endpoints requieren autenticación.

Formato aceptable:

Documento Markdown estructurado, o

Esquema OpenAPI/Swagger (pero no es obligatorio usar herramienta externa).

7. FormRequests y scopes
7.1. FormRequests
Regla:
Todo formulario con más de 2 campos debe usar un FormRequest.

Ejemplos:

StoreCourseRequest, UpdateCourseRequest.

StoreStudentRequest, UpdateStudentRequest.

StoreEnrollmentRequest, etc.

Aplicar tanto en controladores web como en API.

7.2. Scopes (3, dos complejos)
Definir al menos 3 scopes en modelos, por ejemplo:

En Course:

scopeActive(): cursos activos.

scopeWithOpenEnrollments(): cursos con matrículas abiertas (scope complejo).

En Enrollment:

scopeWithAverageGradeAbove($value): matrículas con nota media superior a un valor (scope complejo).

Los scopes complejos deben incluir lógica no trivial (joins, subconsultas o condiciones múltiples).

8. Livewire y componentes de vistas
8.1. Clases Livewire (7)
Crear 7 componentes Livewire, de los cuales 2 serán CRUDs completos.

Ejemplos:

CRUDs:

CoursesCrud (gestión de cursos).

StudentsCrud (gestión de alumnos).

Otros 5:

Filtro dinámico de cursos.

Gestión de matrículas en tiempo real.

Listado de lecciones de un curso.

Panel de resumen para un profesor.

Buscador de alumnos.

8.2. Componentes de vistas (Blade/Livewire/Vue)
Definir y usar componentes reutilizables para:

Input

Fecha

Select

Label

Checkbox

Estos componentes deben usarse en los formularios de la aplicación (no solo definidos).

9. Eventos, listeners, jobs y colas
9.1. Eventos y listeners (2 + 2)
Crear al menos:

2 eventos, por ejemplo:

StudentEnrolled

PaymentCompleted

2 listeners asociados:

SendEnrollmentEmail (escucha StudentEnrolled).

GenerateInvoicePdf (escucha PaymentCompleted).

Registrar los listeners en EventServiceProvider.

9.2. Jobs (5, 2 usando colas)
Crear 5 jobs, de los cuales 2 deben ejecutarse en colas:

Ejemplos:

SendBulkEmailToStudents (en cola).

RecalculateCourseStatistics (en cola).

SyncExternalCalendar.

GenerateMonthlyReport.

CleanupOldEnrollments.

Configurar el sistema de colas (driver database o redis) y usar dispatch() para encolar los jobs correspondientes.

10. Comandos de consola (7)
Crear 7 comandos de consola personalizados, por ejemplo:

academy:recalculate-stats

academy:sync-external-data

academy:cleanup-old-enrollments

academy:generate-monthly-report

academy:seed-demo-data

academy:notify-teachers

academy:archive-old-courses

Regla:
2 de estos comandos deben ser invocados desde el código, por ejemplo:

Desde un Job.

Desde un Listener.

Usar Artisan::call('academy:...') para esas invocaciones internas.

11. Emails (4)
Configurar el sistema de correo y crear 4 tipos de emails:

Confirmación de matrícula.

Recordatorio de clase.

Notificación de pago recibido.

Resumen mensual para profesor o administrador.

Usar Mailable classes y plantillas Blade.
Al menos uno de estos emails debe enviarse desde un Listener o un Job.

12. PDFs con laravel-dompdf (2)
Instalar y configurar barryvdh/laravel-dompdf (o paquete equivalente).

Generar 2 PDFs:

PDF con formato complejo (por ejemplo, factura o certificado de curso).

PDF más sencillo (por ejemplo, resumen de matrícula o listado de cursos).

Al menos uno de los PDFs debe generarse como parte de un flujo de negocio (por ejemplo, tras PaymentCompleted en un Listener o Job).

13. Traducciones (5 idiomas)
Configurar el sistema de traducciones de Laravel con 5 idiomas, por ejemplo:

es, en, fr, de, it.

Requisitos:

Crear archivos de traducción en resources/lang/{locale}.

Usar __() o @lang en vistas, componentes y emails.

Traducir textos de interfaz principales.

Opcional pero recomendable: selector de idioma en la parte pública.

14. Tests con Pest (≥ 85% cobertura)
Instalar y configurar Pest.

Escribir tests para alcanzar al menos 85% de cobertura.

Tipos de tests:

Unitarios:

Modelos (relaciones, scopes).

Policies.

Jobs.

Feature:

Rutas web (pública y privada).

Rutas API (incluyendo la protegida).

Componentes Livewire.

Autorización (roles y permisos).

Eventos y listeners clave.

Generar reportes de cobertura y ajustar tests hasta superar el 85%.

15. Resumen de cumplimiento de requisitos
La IA debe asegurarse de que:

Hay parte pública y parte privada claramente separadas.

Las rutas están ordenadas y agrupadas.

Se usan 5 roles con laravel-permission.

Existen 2 policies con lógica real.

Se desarrolla una API con 7 modelos y 5 CRUDs, uno con autenticación.

Se añaden 7 comandos, 2 invocados desde código.

Se crean 2 eventos y 2 listeners.

Se definen 5 jobs, 2 usando colas.

Se envían 4 emails.

Se usan 7 clases Livewire, 2 CRUDs.

Se usa Pest con ≥ 85% cobertura.

Se implementan traducciones en 5 idiomas.

Se definen y usan componentes de vistas (input, fecha, select, label, checkbox).

Se generan 2 PDFs con laravel-dompdf, uno con formato complejo.

Se usan FormRequests en formularios con más de 2 campos.

Se definen 3 scopes, 2 complejos.

Hay relaciones 1:n y n:n con pivot y columnas extra gestionadas desde código.

Se genera documentación funcional de la API.