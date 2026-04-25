# Guía de Desarrollo – Aplicación Web de Academia

Esta guía define los requisitos completos que debe cumplir la aplicación web de una academia, usando **Laravel + Vue + Livewire**.

---

## 1. Contexto General del Proyecto

### Objetivo
Desarrollar una aplicación web para una academia con:

- Parte pública (sin autenticación).
- Parte privada (con autenticación y roles).
- API paralela documentada.
- Uso intensivo de características avanzadas de Laravel.

### Stack Obligatorio

| Capa | Tecnología |
|---|---|
| Backend | Laravel (versión actual LTS) |
| Frontend | Vue + Blade + Livewire |
| Base de Datos | MySQL o PostgreSQL |
| Colas | Database o Redis |
| Tests | Pest |

---

## 2. Modelado del Dominio

### 2.1. Modelos Mínimos (7)

Definir al menos estos 7 modelos con sus migraciones:

1. `User`
2. `Student`
3. `Teacher`
4. `Course`
5. `Lesson`
6. `Enrollment` *(pivot entre Student y Course, con columnas extra)*
7. `Payment` *(o `Exam`, elegir uno y usarlo de forma coherente)*

### 2.2. Relaciones

Implementar:

**1:N**
- `Teacher` → `Course`
- `Course` → `Lesson`

**N:N con pivot especial**
- `Student` ↔ `Course` mediante `Enrollment`

La tabla pivot `enrollments` debe tener columnas adicionales:
- `enrolled_at` (datetime)
- `status` (string)
- `final_grade` (decimal o integer)

Estas columnas deben ser gestionadas desde el código (formularios, validación, lógica).

---

## 3. Estructura del Proyecto y Organización

### 3.1. Estructura de Carpetas

Organizar el código de forma explícita:

| Tipo | Ruta |
|---|---|
| Controladores Web | `App/Http/Controllers/Web/...` |
| Controladores API | `App/Http/Controllers/Api/...` |
| Componentes Livewire | `App/Http/Livewire/...` |
| Policies | `App/Policies/...` |
| Jobs | `App/Jobs/...` |
| Events | `App/Events/...` |
| Listeners | `App/Listeners/...` |
| Comandos | `App/Console/Commands/...` |

### 3.2. Autenticación

Usar **Laravel Breeze** o **Jetstream** (elegir uno) para:

- Registro, login, logout, reset de contraseña.
- Proteger la parte privada con middleware `auth` (y `verified` si aplica).

---

## 4. Rutas Públicas y Privadas

### 4.1. Rutas Públicas (sin autenticación)

En `routes/web.php`, definir un grupo con `name('public.')`. Ejemplos:

- Página de inicio.
- Listado de cursos públicos.
- Detalle de curso.
- Formulario de contacto.

### 4.2. Rutas Privadas (con autenticación)

En `routes/web.php`, definir un grupo con middleware `auth`. Secciones típicas:

- Gestión de cursos.
- Gestión de alumnos.
- Gestión de profesores.
- Gestión de matrículas.
- Panel de administración.

Las rutas deben estar ordenadas y agrupadas por contexto (usando `Route::prefix('courses')` y `name('courses.')`).

---

## 5. Roles, Permisos y Policies

### 5.1. Roles y Permisos (`laravel-permission`)

Instalar y configurar `spatie/laravel-permission`.

**5 roles:**
- `admin`
- `manager`
- `teacher`
- `student`
- `api_client`

**Permisos:**
- `manage courses`
- `manage students`
- `manage teachers`
- `manage enrollments`
- `view reports`

**Seeders:**
- Crear roles y permisos.
- Asignar un usuario administrador inicial.

### 5.2. Policies (2 con contenido real)

Crear al menos 2 policies con lógica de autorización real:

**`CoursePolicy`** – Métodos: `view`, `create`, `update`, `delete`.
- Usar roles y/o permisos para decidir acceso.

**`EnrollmentPolicy`** – Métodos: `view`, `create`, `update`, `delete`.
- Controlar quién puede gestionar matrículas (admin/manager/teacher).

Registrar las policies en `AuthServiceProvider`.

---

## 6. API Paralela

### 6.1. Modelos y CRUDs

Usar los 7 modelos definidos. Implementar **5 CRUDs completos** (REST):

1. `Course`
2. `Student`
3. `Teacher`
4. `Lesson`
5. `Enrollment`

Cada CRUD debe tener: `index`, `show`, `store`, `update`, `destroy`.

Usar **FormRequest** cuando haya más de 2 campos.

### 6.2. Autenticación en la API

Usar **Laravel Sanctum** (o Passport, elegir uno).

- Al menos uno de los CRUDs debe requerir autenticación.
- Ejemplo: `EnrollmentController` protegido con `auth:sanctum`.

### 6.3. Rutas API

En `routes/api.php`:
- Definir rutas `apiResource` para los 5 CRUDs.
- Agrupar rutas protegidas con middleware de autenticación.

### 6.4. Documentación Funcional de la API

Generar documentación que incluya:

- Listado de endpoints.
- Método HTTP.
- Parámetros de entrada.
- Ejemplos de request/response.
- Códigos de estado.
- Indicación de qué endpoints requieren autenticación.

**Formato aceptable:** Documento Markdown estructurado, o esquema OpenAPI/Swagger.

---

## 7. FormRequests y Scopes

### 7.1. FormRequests

> **Regla:** Todo formulario con más de 2 campos debe usar un FormRequest.

Ejemplos:
- `StoreCourseRequest`, `UpdateCourseRequest`
- `StoreStudentRequest`, `UpdateStudentRequest`
- `StoreEnrollmentRequest`, etc.

Aplicar tanto en controladores web como en API.

### 7.2. Scopes (3, dos complejos)

Definir al menos 3 scopes en modelos:

**En `Course`:**
- `scopeActive()` – cursos activos.
- `scopeWithOpenEnrollments()` – cursos con matrículas abiertas *(scope complejo)*.

**En `Enrollment`:**
- `scopeWithAverageGradeAbove($value)` – matrículas con nota media superior a un valor *(scope complejo)*.

> Los scopes complejos deben incluir lógica no trivial (joins, subconsultas o condiciones múltiples).

---

## 8. Livewire y Componentes de Vistas

### 8.1. Clases Livewire (7)

Crear **7 componentes Livewire**, de los cuales **2 serán CRUDs completos**.

**CRUDs:**
- `CoursesCrud` – gestión de cursos.
- `StudentsCrud` – gestión de alumnos.

**Otros 5:**
- Filtro dinámico de cursos.
- Gestión de matrículas en tiempo real.
- Listado de lecciones de un curso.
- Panel de resumen para un profesor.
- Buscador de alumnos.

### 8.2. Componentes de Vistas Reutilizables (Blade)

Definir y **usar** componentes reutilizables para:

- `Input`
- `Fecha`
- `Select`
- `Label`
- `Checkbox`

> Estos componentes deben usarse en los formularios de la aplicación, no solo estar definidos.

---

## 9. Eventos, Listeners, Jobs y Colas

### 9.1. Eventos y Listeners (2 + 2)

**Eventos:**
- `StudentEnrolled`
- `PaymentCompleted`

**Listeners asociados:**
- `SendEnrollmentEmail` → escucha `StudentEnrolled`
- `GenerateInvoicePdf` → escucha `PaymentCompleted`

Registrar los listeners en `EventServiceProvider`.

### 9.2. Jobs (5, con 2 en cola)

Crear **5 jobs**, de los cuales **2 deben ejecutarse en colas**:

| Job | ¿En cola? |
|---|---|
| `SendBulkEmailToStudents` | ✅ Sí |
| `RecalculateCourseStatistics` | ✅ Sí |
| `SyncExternalCalendar` | No |
| `GenerateMonthlyReport` | No |
| `CleanupOldEnrollments` | No |

Configurar el sistema de colas (driver `database` o `redis`) y usar `dispatch()` para encolar los jobs.

---

## 10. Comandos de Consola (7)

Crear **7 comandos Artisan personalizados**:

1. `academy:recalculate-stats`
2. `academy:sync-external-data`
3. `academy:cleanup-old-enrollments`
4. `academy:generate-monthly-report`
5. `academy:seed-demo-data`
6. `academy:notify-teachers`
7. `academy:archive-old-courses`

> **Regla:** 2 de estos comandos deben ser **invocados desde el código** (desde un Job o un Listener) usando `Artisan::call('academy:...')`.

---

## 11. Emails (4)

Configurar el sistema de correo y crear **4 tipos de emails**:

1. Confirmación de matrícula.
2. Recordatorio de clase.
3. Notificación de pago recibido.
4. Resumen mensual para profesor o administrador.

Usar **Mailable classes** y plantillas Blade.

> Al menos uno de estos emails debe enviarse desde un Listener o un Job.

---

## 12. PDFs con `laravel-dompdf` (2)

Instalar y configurar `barryvdh/laravel-dompdf`.

Generar **2 PDFs**:

1. **PDF complejo** – por ejemplo, factura o certificado de curso.
2. **PDF sencillo** – por ejemplo, resumen de matrícula o listado de cursos.

> Al menos uno de los PDFs debe generarse como parte de un flujo de negocio (por ejemplo, tras `PaymentCompleted` en un Listener o Job).

---

## 13. Traducciones (5 idiomas)

Configurar el sistema de traducciones de Laravel con **5 idiomas**:

`es` · `en` · `fr` · `de` · `it`

**Requisitos:**
- Crear archivos de traducción en `resources/lang/{locale}`.
- Usar `__()` o `@lang` en vistas, componentes y emails.
- Traducir los textos de interfaz principales.
- *(Opcional pero recomendable)* Selector de idioma en la parte pública.

---

## 14. Tests con Pest (≥ 85% cobertura)

Instalar y configurar Pest. Escribir tests para alcanzar **al menos 85% de cobertura**.

### Tests Unitarios
- Modelos (relaciones, scopes).
- Policies.
- Jobs.

### Tests de Características (Feature)
- Rutas web (pública y privada).
- Rutas API (incluyendo la protegida).
- Componentes Livewire.
- Autorización (roles y permisos).
- Eventos y listeners clave.

Generar reportes de cobertura y ajustar tests hasta superar el 85%.

---

## 15. Checklist Final de Cumplimiento

Verificar que se cumplen **todos** los siguientes puntos antes de considerar el proyecto finalizado:

- [ ] Hay parte pública y parte privada claramente separadas.
- [ ] Las rutas están ordenadas y agrupadas.
- [ ] Se usan **5 roles** con `laravel-permission`.
- [ ] Existen **2 policies** con lógica real.
- [ ] Se desarrolla una API con **7 modelos** y **5 CRUDs**, uno con autenticación.
- [ ] Se añaden **7 comandos**, 2 invocados desde código.
- [ ] Se crean **2 eventos** y **2 listeners**.
- [ ] Se definen **5 jobs**, 2 usando colas.
- [ ] Se envían **4 emails**.
- [ ] Se usan **7 clases Livewire**, 2 CRUDs.
- [ ] Se usa **Pest** con ≥ 85% cobertura.
- [ ] Se implementan traducciones en **5 idiomas**.
- [ ] Se definen y usan **componentes de vistas** (input, fecha, select, label, checkbox).
- [ ] Se generan **2 PDFs** con `laravel-dompdf`, uno con formato complejo.
- [ ] Se usan **FormRequests** en formularios con más de 2 campos.
- [ ] Se definen **3 scopes**, 2 complejos.
- [ ] Hay relaciones **1:N** y **N:N** con pivot y columnas extra gestionadas desde código.
- [ ] Se genera **documentación funcional de la API**.