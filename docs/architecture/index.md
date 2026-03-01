# Arquitectura del Sistema

Documentación de las decisiones arquitectónicas, estructura de código y flujos de seguridad implementados en Academia Profesional.

## 1. Stack Tecnológico
- **Backend**: Laravel Framework (v12.x)
- **Frontend**: Vue.js 3 + Inertia.js
- **Autenticación**: Laravel Fortify (Web) + Laravel Sanctum (API)
- **Base de Datos**: MySQL
- **Gestión de Roles**: `spatie/laravel-permission`

## 2. Estructura del Código

Para mantener una separación clara de responsabilidades entre el Frontend (Inertia) y la API externa, se ha organizado el directorio de controladores:

### Controladores (`app/Http/Controllers`)
- **`Web/`**: Controladores que responden con `Inertia::render`. Manejan la lógica de la aplicación SPA.
    - Ejemplo: `DashboardController`, `CourseController` (para vistas).
- **`Api/`**: Controladores que responden con `JSON`. Siguen principios REST.
    - Ejemplo: `Api/CourseController` (para consumo móvil/externo).

### Rutas (`routes/`)
- **`web.php`**:
    - **Grupo `public.`**: Rutas accesibles sin login (Home, Catálogo).
    - **Grupo Auth**: Rutas protegidas por middleware `auth` y `verified`.
- **`api.php`**:
    - Rutas protegidas por middleware `auth:sanctum`.
    - Versionado implícito (actualmente v1).

## 3. Seguridad y Control de Acceso (RBAC)

El sistema utiliza un modelo de **Roles y Permisos** estricto.

### Roles Definidos
1. **`admin`**: Acceso total al sistema.
2. **`manager`**: Gestión administrativa (cursos, estudiantes, pagos).
3. **`teacher`**: Gestión de sus propios cursos y alumnos.
4. **`student`**: Acceso a cursos matriculados.
5. **`api_client`**: Rol para integraciones externas.

### Políticas (Policies)
La autorización se delega a las Policies de Laravel, que verifican los roles del usuario.

- **`CoursePolicy`**: Controla quién puede crear, editar o eliminar cursos.
    - `viewAny`: Público.
    - `create/delete`: Admin/Manager.
    - `update`: Admin/Manager o Teacher (propio curso).
- **`EnrollmentPolicy`**: Controla la visualización y gestión de matrículas.

## 4. Autenticación

### Web (SPA)
Utiliza sesiones estándar de Laravel con cookies protegidas. El flujo de login es manejado por Fortify.

### API
Utiliza Tokens de acceso (Bearer Token) provistos por Sanctum.
El modelo `User` utiliza el trait `HasApiTokens`.

---
*Actualizado: 03 Feb 2026*
