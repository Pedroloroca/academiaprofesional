# Documentación de la API (v1)

Esta es la documentación funcional de la API REST para la Academia Profesional. 
Todos los endpoints están protegidos por **Sanctum** y requieren el envío de credenciales o un Bearer Token (`Authorization: Bearer {token}`) así como el header `Accept: application/json`.

---

## 1. Courses (`/api/courses`)

Gestiona los cursos de la academia.

- **GET `/api/courses`**: Obtiene el listado de todos los cursos.
- **GET `/api/courses/{id}`**: Obtiene el detalle de un curso específico.
- **POST `/api/courses`**: Crea un nuevo curso.
  - *Body*: `title` (string, max 255), `description` (string), `price` (numeric, min 0), `teacher_id` (integer, exists in teachers).
- **PUT/PATCH `/api/courses/{id}`**: Actualiza un curso.
  - *Body*: `title`, `description`, `price`, `teacher_id` (todos opcionales).
- **DELETE `/api/courses/{id}`**: Elimina un curso.

---

## 2. Teachers (`/api/teachers`)

Gestiona los perfiles de profesores.

- **GET `/api/teachers`**: Obtiene el listado de todos los profesores (incluye la relación con el usuario).
- **GET `/api/teachers/{id}`**: Obtiene el detalle de un profesor específico.
- **POST `/api/teachers`**: Crea un perfil de profesor.
  - *Body*: `user_id` (integer, unique, exists in users), `bio` (string, nullable), `website_url` (url, nullable).
- **PUT/PATCH `/api/teachers/{id}`**: Actualiza un profesor.
  - *Body*: `bio`, `website_url` (opcionales).
- **DELETE `/api/teachers/{id}`**: Elimina un profesor.

---

## 3. Students (`/api/students`)

Gestiona los perfiles de estudiantes.

- **GET `/api/students`**: Obtiene el listado de estudiantes (incluye la relación con el usuario).
- **GET `/api/students/{id}`**: Obtiene el detalle de un estudiante.
- **POST `/api/students`**: Crea un perfil de estudiante.
  - *Body*: `user_id` (integer, unique, exists in users), `date_of_birth` (date, nullable), `address` (string, nullable).
- **PUT/PATCH `/api/students/{id}`**: Actualiza un estudiante.
  - *Body*: `date_of_birth`, `address` (opcionales).
- **DELETE `/api/students/{id}`**: Elimina un estudiante.

---

## 4. Lessons (`/api/lessons`)

Gestiona las lecciones de los cursos.

- **GET `/api/lessons`**: Obtiene el listado de lecciones (incluye la relación con el curso).
- **GET `/api/lessons/{id}`**: Obtiene el detalle de una lección.
- **POST `/api/lessons`**: Crea una nueva lección.
  - *Body*: `course_id` (integer, exists in courses), `title` (string, max 255), `content` (string), `position` (integer, nullable), `is_published` (boolean, default false).
- **PUT/PATCH `/api/lessons/{id}`**: Actualiza una lección.
  - *Body*: `title`, `content`, `position`, `is_published` (opcionales).
- **DELETE `/api/lessons/{id}`**: Elimina una lección.

---

## 5. Enrollments (`/api/enrollments`)

Gestiona las matriculaciones de los estudiantes en los cursos.

- **GET `/api/enrollments`**: Obtiene el listado de matriculaciones (incluye estudiante y curso).
- **GET `/api/enrollments/{id}`**: Obtiene el detalle de una matriculación.
- **POST `/api/enrollments`**: Crea una nueva matriculación.
  - *Body*: `student_id` (integer, exists in students), `course_id` (integer, exists in courses), `status` (string, in: active, completed, dropped), `final_grade` (numeric, min 0, max 10).
- **PUT/PATCH `/api/enrollments/{id}`**: Actualiza una matriculación.
  - *Body*: `status`, `final_grade` (opcionales).
- **DELETE `/api/enrollments/{id}`**: Elimina una matriculación.
