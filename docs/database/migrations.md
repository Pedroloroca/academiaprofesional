# Documentación de Migraciones - Academia Profesional

Este documento detalla la estructura de la base de datos definida a través de las migraciones de Laravel.

## Resumen de Tablas

| Tabla | Descripción | Modelo Asociado |
| :--- | :--- | :--- |
| `users` | Usuarios del sistema (autenticación). | `User` |
| `teachers` | Perfil extendido para profesores. | `Teacher` |
| `students` | Perfil extendido para estudiantes. | `Student` |
| `courses` | Cursos creados por profesores. | `Course` |
| `lessons` | Lecciones pertenecientes a un curso. | `Lesson` |
| `enrollments` | Matrículas de estudiantes en cursos. | `Enrollment` (Pivot) |
| `payments` | Registro de pagos por cursos. | `Payment` |
| *Spatie Tables* | Tablas gestionadas por librerías externas. | N/A |

## Detalle de Esquema

### 1. Usuarios y Perfiles

#### `users`
Tabla estándar de Laravel con columnas adicionales para autenticación de dos factores (Laravel Fortify).
- **Relaciones**:
    - `hasOne` Teacher
    - `hasOne` Student
    - `hasRoles` (Spatie)

#### `teachers`
Información específica para usuarios con rol de profesor.
- `user_id`: FK única a `users`.
- `bio`: Biografía o descripción.
- `website_url`: Enlace personal.

#### `students`
Información específica para usuarios con rol de estudiante.
- `user_id`: FK única a `users`.
- `date_of_birth`: Fecha de nacimiento.
- `address`: Dirección postal.

### 2. Contenido Académico

#### `courses`
- `teacher_id`: FK a `teachers` (autor del curso).
- `title`: Título del curso.
- `slug`: Identificador URL amigable (único).
- `description`: Descripción completa.
- `price`: Precio del curso.
- `status`: Estado (`draft`, `published`, `archived`).

#### `lessons`
- `course_id`: FK a `courses`.
- `title`: Título de la lección.
- `slug`: URL amigable.
- `content`: Contenido textual.
- `position`: Orden secuencial.
- `is_published`: Visibilidad.

### 3. Matrículas y Pagos

#### `enrollments`
Tabla pivot extendida que conecta `students` y `courses`.
- `student_id`: FK a `students`.
- `course_id`: FK a `courses`.
- `enrolled_at`: Fecha y hora de inscripción.
- `status`: Estado (`active`, `completed`, `dropped`).
- `final_grade`: Calificación obtenida.

#### `payments`
Registro de transacciones financieras.
- `student_id`: FK a `students` (pagador).
- `course_id`: FK a `courses` (producto comprado).
- `enrollment_id`: FK opcional a `enrollments` (si aplica).
- `amount`: Cantidad pagada.
- `currency`: Moneda (default 'EUR').
- `status`: Estado del pago (`pending`, `paid`, `failed`).
- `provider`: Pasarela de pago (Stripe, PayPal).
- `transaction_id`: ID externo de la transacción.

### 4. Tablas Externas (Librerías)

#### Laravel Permission (Spatie)
Gestiona roles y permisos mediante las tablas:
- `roles`
- `permissions`
- `model_has_permissions`
- `model_has_roles`
- `role_has_permissions`

#### Laravel Media Library (Spatie)
Gestiona archivos multimedia (imágenes, videos) adjuntos a modelos:
- `media`: Almacena metadatos y rutas de archivos polimórficos.
