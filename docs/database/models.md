# Documentación de Modelos Eloquent

Detalle de la capa de modelos de la aplicación.

## 1. Usuarios y Roles

### `User`
Modelo principal de autenticación.
- **Traits**: `Notifiable`, `TwoFactorAuthenticatable`, `HasRoles` (Spatie), `InteractsWithMedia` (Spatie).
- **Relaciones**:
    - `teacher()`: HasOne -> `Teacher`.
    - `student()`: HasOne -> `Student`.
    - `roles()`: BelongsToMany (Spatie).

### `Teacher`
Perfil de profesor.
- **Relaciones**:
    - `user()`: BelongsTo -> `User`.
    - `courses()`: HasMany -> `Course`.

### `Student`
Perfil de estudiante.
- **Relaciones**:
    - `user()`: BelongsTo -> `User`.
    - `enrollments()`: HasMany -> `Enrollment`.
    - `courses()`: BelongsToMany -> `Course` (vía enrollments).
    - `payments()`: HasMany -> `Payment`.

## 2. Académico

### `Course`
Entidad principal del curso.
- **Traits**: `InteractsWithMedia` (Spatie).
- **Relaciones**:
    - `teacher()`: BelongsTo -> `Teacher`.
    - `lessons()`: HasMany -> `Lesson`.
    - `enrollments()`: HasMany -> `Enrollment`.
    - `students()`: BelongsToMany -> `Student` (vía enrollments).

### `Lesson`
Unidad de contenido dentro de un curso.
- **Traits**: `InteractsWithMedia` (Spatie).
- **Relaciones**:
    - `course()`: BelongsTo -> `Course`.

## 3. Operaciones

### `Enrollment`
Modelo Pivot personalizado (extiende `Pivot`). Representa la matrícula de un alumno.
- **Relaciones**:
    - `student()`: BelongsTo -> `Student`.
    - `course()`: BelongsTo -> `Course`.
- **Atributos Pivot**: `status`, `final_grade`, `enrolled_at`.

### `Payment`
Registro de pagos.
- **Relaciones**:
    - `student()`: BelongsTo -> `Student`.
    - `course()`: BelongsTo -> `Course`.
    - `enrollment()`: BelongsTo -> `Enrollment` (opcional).
