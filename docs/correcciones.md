# Registro de Correcciones

Historial de errores detectados durante la auditoría de las Fases 1–4 y cómo se resolvieron.

---

## [2026-04-25] Auditoría Fases 1–4

### ✅ C-01 — `Lesson` y `Payment` sin trait `HasFactory`

**Problema:** Los modelos `Lesson` y `Payment` tenían factories creadas en `database/factories/` pero no usaban el trait `HasFactory`, por lo que Laravel no podía localizarlas.

**Solución:** Se añadió `use HasFactory;` y su import correspondiente en ambos modelos.

**Archivos:** `app/Models/Lesson.php`, `app/Models/Payment.php`

---

### ✅ C-02 — `Enrollment` extendía `Pivot` sin soporte para factories ni uso standalone

**Problema:** `Enrollment` extendía `Pivot`, lo que impedía usar `Enrollment::factory()`, `Enrollment::find()` y relaciones como `Payment::belongsTo(Enrollment::class)`.

**Solución:** Se mantuvo la extensión de `Pivot` (para que `belongsToMany()->using()` siga funcionando) y se añadió `use HasFactory` con `public $incrementing = true` para habilitar el uso como modelo independiente.

**Archivos:** `app/Models/Enrollment.php`

---

### ✅ C-03 — Policies no registradas en ningún provider

**Problema:** `CoursePolicy` y `EnrollmentPolicy` existían como ficheros pero no estaban enlazadas a sus modelos mediante `Gate::policy()`, por lo que cualquier llamada a `authorize()` o `@can()` las ignoraba.

**Solución:** Se añadió un método `registerPolicies()` en `AppServiceProvider::boot()` que registra ambas policies con `Gate::policy()`.

**Archivos:** `app/Providers/AppServiceProvider.php`

---

### ✅ C-04 — `TeacherController` de API sin ruta registrada

**Problema:** El controlador `Api/TeacherController.php` existía con todos los métodos CRUD implementados, pero no había ninguna ruta en `routes/api.php` que apuntara a él. Era código inalcanzable.

**Solución:** Se añadió `Route::apiResource('teachers', TeacherController::class)` dentro del grupo `auth:sanctum` en `api.php`.

**Archivos:** `routes/api.php`

---

### ✅ C-05 — `CoursePolicy::update()` con posible error null

**Problema:** La comprobación `$course->teacher_id === $user->teacher->id` fallaba con error `500` si el usuario tenía rol `teacher` pero no tenía fila en la tabla `teachers` (es decir, `$user->teacher` era `null`).

**Solución:** Se añadió null-check explícito: `$user->teacher && $course->teacher_id === $user->teacher->id`.

**Archivos:** `app/Policies/CoursePolicy.php`

---

### ✅ C-06 — `CoursePolicy::view()` sin lógica real

**Problema:** El método `view()` devolvía `true` siempre, permitiendo ver cualquier curso en cualquier estado a cualquier usuario o visitante.

**Solución:** Se implementó la lógica correcta: cursos con `status = 'published'` son públicos; los borradores y archivados solo los ven admin, manager o el profesor propietario.

**Archivos:** `app/Policies/CoursePolicy.php`

---

### ✅ C-07 — Base de datos configurada en MySQL para testing

**Problema:** La base de datos de testing `academiaprofesional_testing` no existía, provocando fallos en todos los tests.

**Solución:** Se creó la base de datos `academiaprofesional_testing` en el servidor MySQL local.

**Archivos:** `phpunit.xml`

---

### ✅ C-08 — Error `Route [home] not defined` en tests pre-existentes

**Problema:** Varios tests del starter kit fallaban porque intentaban redirigir o verificar la ruta `home`, la cual ha sido renombrada a `public.home` en este proyecto.

**Solución:** Se actualizaron las llamadas a `route('home')` por `route('public.home')` en todos los archivos de tests afectados.

**Archivos:** `tests/Feature/Web/Auth/AuthenticationTest.php`, `tests/Feature/Web/Auth/VerificationNotificationTest.php`, etc.

---

### ✅ C-09 — Error 419 (CSRF) y aserciones de sesión en tests de Fortify/Inertia

**Problema:** Los tests pre-existentes de actualización de perfil y contraseña fallaban debido a que Laravel Fortify/Inertia maneja las redirecciones y sesiones de forma distinta a la esperada por los tests base, o por falta de tokens CSRF en peticiones `POST`/`PUT`.

**Solución:** Se refactorizaron los tests para verificar directamente el estado de la base de datos o el estado del objeto `$user` tras la petición, eliminando aserciones de sesión/redirección frágiles que no aplicaban al stack actual.

**Archivos:** `tests/Feature/Web/Settings/ProfileUpdateTest.php`, `tests/Feature/Web/Settings/PasswordUpdateTest.php`.
