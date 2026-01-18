# Plan de Desarrollo - Pasos a Seguir

Este documento define la hoja de ruta para el desarrollo de la aplicación Academia Profesional, basada en los requisitos establecidos en `Guía.md`.

El desarrollo se divide en 13 fases secuenciales para asegurar una implementación ordenada y sólida.

## ✅ Fase 1: Base de Datos y Fundamentos (Completado)
Establecimiento del núcleo del sistema.
- [x] Crear Migraciones (7 modelos principales + tablas de sistema).
- [x] Crear Modelos con relaciones (1:N, N:M) y atributos.
- [x] Crear Factories para pruebas.
- [x] Instalar y configurar Spatie Permissions.
- [x] Instalar y configurar Spatie MediaLibrary.
- [x] Sembrar base de datos (Admin inicial y roles).

## 🔲 Fase 2: Estructura y Andamiaje
Organización del código y sistema de autenticación.
- [ ] Crear estructura de carpetas (`Web/`, `Api/` controllers, `Livewire/`).
- [ ] Instalar Laravel Breeze o Jetstream para autenticación base.

## 🔲 Fase 3: Roles, Permisos y Políticas
Control de acceso y seguridad lógica.
- [ ] Configurar los 5 roles: `admin`, `manager`, `teacher`, `student`, `api_client`.
- [ ] Definir permisos específicos (ej: `manage courses`).
- [ ] Crear `CoursePolicy` y `EnrollmentPolicy` con lógica real.

## 🔲 Fase 4: Rutas (Públicas y Privadas)
Definición de los puntos de entrada de la aplicación web.
- [ ] Definir rutas públicas (Home, Catálogo, Contacto).
- [ ] Definir rutas privadas con middleware `auth` y organización por prefijos.

## 🔲 Fase 5: API REST
Desarrollo de la API para consumo externo o aplicaciones móviles.
- [ ] Implementar 5 controladores CRUD (Course, Student, Teacher, Lesson, Enrollment).
- [ ] Configurar Laravel Sanctum para autenticación por tokens.
- [ ] Generar documentación funcional de endpoints.

## 🔲 Fase 6: Lógica de Negocio y Validación
Refinamiento de la calidad de datos y consultas complejas.
- [ ] Crear FormRequests para validaciones complejas (>2 campos).
- [ ] Implementar Scopes (ej: `scopeActive`, `scopeWithOpenEnrollments`).

## 🔲 Fase 7: Frontend y Livewire
Implementación de la interfaz dinámica.
- [ ] Crear 7 componentes Livewire (incluyendo 2 CRUDs completos).
- [ ] Crear componentes Blade reutilizables (Input, fechas, selects).

## 🔲 Fase 8: Eventos y Procesos Asíncronos
Automatización de flujos de trabajo.
- [ ] Crear Eventos (`StudentEnrolled`, `PaymentCompleted`).
- [ ] Crear Listeners (`SendEmail`, `GeneratePDF`).
- [ ] Implementar 5 Jobs (2 en cola Redis/Database).

## 🔲 Fase 9: Comandos de Consola
Herramientas de mantenimiento y automatización interna.
- [ ] Crear 7 comandos Artisan personalizados.
- [ ] Implementar invocación interna de comandos desde código.

## 🔲 Fase 10: Emails y Notificaciones
Comunicación con los usuarios.
- [ ] Crear 4 clases Mailables (Bienvenida, Factura, etc.).
- [ ] Configurar plantillas Blade para emails.

## 🔲 Fase 11: Generación de PDF
Documentos digitales.
- [ ] Instalar `laravel-dompdf`.
- [ ] Generar 2 tipos de reportes PDF (Certificado, Resumen).

## 🔲 Fase 12: Traducciones
Internacionalización del sistema.
- [ ] Configurar soporte para 5 idiomas (`es`, `en`, `fr`, `de`, `it`).
- [ ] Externalizar cadenas de texto en archivos de recursos.

## 🔲 Fase 13: Testing
Aseguramiento de calidad.
- [ ] Configurar framework Pest.
- [ ] Escribir tests unitarios y de características ("feature") alcanzando >85% de cobertura.
