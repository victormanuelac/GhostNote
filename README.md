# 🔒 GhostNote

**GhostNote** es una aplicación web segura para compartir notas y secretos que se autodestruyen después de ser vistos. Perfecta para compartir contraseñas, códigos de acceso, información sensible o cualquier mensaje que necesite desaparecer después de ser leído.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## ✨ Características

### 🔐 Seguridad
- **Encriptación de extremo a extremo** - Todos los secretos se encriptan usando el sistema de encriptación de Laravel antes de almacenarse
- **Autodestrucción automática** - Los secretos se eliminan permanentemente después de ser vistos o cuando expiran
- **Protección contra condiciones de carrera** - Uso de bloqueos de base de datos para garantizar límites de vistas estrictos
- **Sin rastros** - Una vez quemado, el secreto desaparece completamente de la base de datos

### 👤 Gestión de Usuarios
- **Autenticación segura** - Sistema de registro e inicio de sesión con Laravel Breeze
- **Dashboard personal** - Panel de control para gestionar todos tus secretos
- **Seguimiento en tiempo real** - Actualización automática del estado de tus secretos cada 5 segundos
- **Historial de vistas** - Registro de cuándo fue visto cada secreto

### 🎨 Interfaz Moderna
- **Diseño oscuro premium** - Interfaz elegante con gradientes y animaciones suaves
- **Totalmente responsive** - Funciona perfectamente en móviles, tablets y escritorio
- **Modo modal** - Revelación de secretos en ventana modal sin recargar la página
- **Copiar con un clic** - Botones para copiar enlaces y contenido al portapapeles

### ⚙️ Configuración Flexible
- **Tiempo de expiración** - Define cuándo expira el secreto (5 min, 1 hora, 1 día, 7 días o nunca)
- **Límite de vistas** - Establece cuántas veces puede ser visto antes de autodestruirse
- **Descripciones** - Agrega etiquetas descriptivas para identificar fácilmente tus secretos

### 🧹 Mantenimiento Automático
- **Limpieza programada** - Comando automático que elimina secretos expirados cada minuto
- **Sin intervención manual** - El sistema se mantiene limpio automáticamente

## 🚀 Instalación

### Requisitos Previos

- PHP 8.3 o superior
- Composer
- MySQL 8.0 o SQLite
- Node.js y NPM (opcional, para desarrollo)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/tuusuario/ghostnote.git
cd ghostnote
```

2. **Instalar dependencias de PHP**
```bash
composer install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

Edita el archivo `.env` y configura tu conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ghostnote
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

O usa SQLite para desarrollo:

```env
DB_CONNECTION=sqlite
```

5. **Ejecutar migraciones**
```bash
php artisan migrate
```

6. **Iniciar el servidor de desarrollo**
```bash
php artisan serve
```

7. **Iniciar el scheduler (en otra terminal)**
```bash
php artisan schedule:work
```

La aplicación estará disponible en `http://localhost:8000`

## 📖 Uso

### Crear un Secreto

1. Regístrate o inicia sesión en la aplicación
2. En el dashboard, completa el formulario:
   - **Contenido**: El mensaje secreto que deseas compartir
   - **Descripción** (opcional): Una etiqueta para identificar el secreto
   - **Tiempo de Expiración**: Cuándo expirará el secreto
   - **Vistas Máximas**: Cuántas veces puede ser visto
3. Haz clic en "Crear Secreto Seguro"
4. Copia el enlace generado y compártelo

### Ver un Secreto

1. Abre el enlace compartido
2. Lee la advertencia de autodestrucción
3. Haz clic en "Sí, muéstrame el secreto"
4. El secreto se mostrará en un modal
5. Copia el contenido si es necesario
6. Al cerrar, el secreto se marca como visto

### Gestionar Secretos

En tu dashboard puedes:
- Ver todos tus secretos creados
- Verificar el estado (Activo, Visto, Quemado)
- Copiar enlaces de secretos activos
- Ver cuándo fue creado y visto cada secreto
- Identificar secretos por su descripción

## 🧪 Testing

Ejecutar todos los tests:

```bash
php artisan test
```

Ejecutar tests específicos:

```bash
php artisan test --filter SecretFlowTest
php artisan test --filter DashboardTest
```

## 🏗️ Arquitectura

### Stack Tecnológico

- **Backend**: Laravel 12.x
- **Base de Datos**: MySQL 8.0 / SQLite
- **Frontend**: Blade Templates + Alpine.js
- **Estilos**: Tailwind CSS (CDN)
- **Autenticación**: Laravel Breeze

### Estructura del Proyecto

```
app/
├── Console/Commands/
│   └── CleanupExpiredSecrets.php  # Comando de limpieza
├── Http/Controllers/
│   ├── SecretController.php       # Gestión de secretos
│   └── DashboardController.php    # Panel de usuario
├── Models/
│   ├── Secret.php                 # Modelo de secreto
│   └── User.php                   # Modelo de usuario
└── Services/
    └── SecretService.php          # Lógica de negocio

resources/views/
├── secret/
│   ├── confirm.blade.php          # Confirmación antes de ver
│   └── show.blade.php             # Vista del secreto
├── dashboard.blade.php            # Panel principal
├── burned.blade.php               # Página de salida
└── welcome.blade.php              # Página de inicio

tests/Feature/
├── SecretFlowTest.php             # Tests del flujo completo
├── DashboardTest.php              # Tests del dashboard
├── DashboardStatusTest.php        # Tests de API
└── UnavailableSecretTest.php      # Tests de errores
```

### Flujo de Datos

1. **Creación**: Usuario → SecretController → SecretService → Encriptación → Base de Datos
2. **Revelación**: Enlace → Confirmación → Modal AJAX → SecretService → Desencriptación → Usuario
3. **Autodestrucción**: Límite alcanzado → Marcar como quemado → Limpieza programada → Eliminación

## 🔒 Seguridad

- **Encriptación AES-256**: Todos los secretos se encriptan con la clave de la aplicación
- **UUIDs**: Identificadores únicos imposibles de adivinar
- **Bloqueos de transacción**: Prevención de condiciones de carrera
- **CSRF Protection**: Protección contra ataques de falsificación de peticiones
- **Validación estricta**: Todos los inputs son validados
- **Sin logs sensibles**: El contenido de los secretos nunca se registra

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Haz fork del proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

Desarrollado con ❤️ para mantener tus secretos seguros y efímeros.

## 🙏 Agradecimientos

- Laravel Framework
- Tailwind CSS
- Alpine.js
- La comunidad de código abierto

---

**⚠️ Nota de Seguridad**: GhostNote es una herramienta para compartir información sensible de forma temporal. Aunque implementa múltiples capas de seguridad, no debe usarse como único método de protección para información extremadamente crítica. Siempre usa métodos adicionales de seguridad cuando sea necesario.
