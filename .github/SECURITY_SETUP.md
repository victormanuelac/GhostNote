# 🔒 Guía de Configuración de Seguridad en GitHub

Esta guía te ayudará a configurar la seguridad del repositorio GhostNote en GitHub para proteger la rama `main` y establecer un flujo de trabajo seguro.

## 📋 Tabla de Contenidos

1. [Protección de la Rama Main](#protección-de-la-rama-main)
2. [Configuración de Colaboradores](#configuración-de-colaboradores)
3. [Autenticación de Dos Factores](#autenticación-de-dos-factores)
4. [Tokens de Acceso Personal](#tokens-de-acceso-personal)
5. [Alertas de Seguridad](#alertas-de-seguridad)
6. [Flujo de Trabajo](#flujo-de-trabajo)

---

## 🛡️ Protección de la Rama Main

### Paso 1: Acceder a la configuración

1. Ve a tu repositorio: `https://github.com/victormanuelac/GhostNote`
2. Haz clic en **Settings** (Configuración)
3. En el menú lateral izquierdo, selecciona **Branches** (Ramas)

### Paso 2: Crear regla de protección

1. En "Branch protection rules", haz clic en **Add rule** (Agregar regla)
2. En "Branch name pattern", escribe: `main`

### Paso 3: Configurar protecciones

Activa las siguientes opciones:

#### ✅ Require a pull request before merging
- **Descripción**: Obliga a crear un Pull Request antes de fusionar cambios
- **Configuración adicional**:
  - ✅ **Require approvals**: Número de aprobaciones: `1`
  - ✅ **Dismiss stale pull request approvals when new commits are pushed**
  - ✅ **Require review from Code Owners** (opcional)

#### ✅ Require status checks to pass before merging
- **Descripción**: Los tests deben pasar antes de fusionar
- **Configuración**: Agrega `tests` si tienes CI/CD configurado

#### ✅ Require conversation resolution before merging
- **Descripción**: Todos los comentarios deben resolverse antes de fusionar

#### ✅ Require signed commits (opcional)
- **Descripción**: Requiere commits firmados con GPG

#### ✅ Require linear history
- **Descripción**: Mantiene un historial de commits limpio

#### ✅ Require deployments to succeed before merging (opcional)
- **Descripción**: Si tienes despliegues automáticos

#### ✅ Lock branch
- **Descripción**: Hace la rama de solo lectura (muy restrictivo)

#### ✅ Do not allow bypassing the above settings
- **Descripción**: Ni siquiera los administradores pueden omitir estas reglas
- **⚠️ IMPORTANTE**: Activa esto para máxima seguridad

#### ✅ Restrict who can push to matching branches
- **Descripción**: Solo usuarios específicos pueden hacer push directo
- **Configuración**: 
  - Agrega tu usuario: `victormanuelac`
  - Agrega otros colaboradores de confianza si es necesario

#### ❌ Allow force pushes (DESACTIVAR)
- **Descripción**: Previene `git push --force`

#### ❌ Allow deletions (DESACTIVAR)
- **Descripción**: Previene eliminación de la rama

### Paso 4: Guardar

Haz clic en **Create** o **Save changes** al final de la página.

---

## 👥 Configuración de Colaboradores

### Niveles de Acceso

1. **Settings** → **Collaborators and teams**
2. Para cada colaborador, asigna el rol apropiado:

#### Roles disponibles:

- **Read**: Solo puede ver el código y clonar el repositorio
- **Triage**: Puede gestionar issues y pull requests
- **Write**: Puede hacer push a ramas (NO a main si está protegida)
- **Maintain**: Puede gestionar el repositorio sin acceso a configuraciones sensibles
- **Admin**: Control total (solo para ti como owner)

#### Recomendación:

- **Colaboradores regulares**: Rol **Write**
  - Pueden crear ramas
  - Pueden crear Pull Requests
  - NO pueden hacer push directo a `main`
  - NO pueden aprobar sus propios PRs

- **Colaboradores de confianza**: Rol **Maintain**
  - Pueden gestionar issues y PRs
  - Pueden hacer merge de PRs aprobados

- **Solo tú**: Rol **Admin** (owner)
  - Apruebas los Pull Requests
  - Haces merge a `main`

---

## 🔐 Autenticación de Dos Factores (2FA)

### Activar 2FA en tu cuenta

1. Ve a tu perfil de GitHub (esquina superior derecha)
2. **Settings** → **Password and authentication**
3. En "Two-factor authentication", haz clic en **Enable two-factor authentication**
4. Sigue las instrucciones:
   - Opción 1: Usar una app de autenticación (Google Authenticator, Authy, etc.)
   - Opción 2: Usar SMS (menos seguro)
5. **Guarda los códigos de recuperación** en un lugar seguro

### Requerir 2FA para colaboradores

1. En el repositorio: **Settings** → **Collaborators and teams**
2. Activa **Require two-factor authentication**
3. Los colaboradores sin 2FA serán removidos hasta que lo activen

---

## 🔑 Tokens de Acceso Personal (PAT)

GitHub ya no acepta contraseñas para operaciones Git. Debes usar tokens.

### Crear un Token

1. **Settings** (tu perfil) → **Developer settings**
2. **Personal access tokens** → **Tokens (classic)**
3. **Generate new token** → **Generate new token (classic)**
4. Configuración:
   - **Note**: `GhostNote Development`
   - **Expiration**: `90 days` (o personalizado)
   - **Scopes**:
     - ✅ `repo` (acceso completo a repositorios)
     - ✅ `workflow` (si usas GitHub Actions)
5. **Generate token**
6. **⚠️ COPIA EL TOKEN INMEDIATAMENTE** (solo se muestra una vez)

### Usar el Token

```bash
# Configurar Git para almacenar credenciales
git config --global credential.helper store

# La próxima vez que hagas push/pull:
Username: victormanuelac
Password: [PEGA TU TOKEN AQUÍ, NO TU CONTRASEÑA]
```

### Tokens Fine-grained (Recomendado)

1. **Personal access tokens** → **Fine-grained tokens**
2. **Generate new token**
3. Configuración más granular:
   - **Repository access**: Solo `victormanuelac/GhostNote`
   - **Permissions**: Solo los permisos necesarios

---

## 🚨 Alertas de Seguridad

### Activar Dependabot

1. **Settings** → **Code security and analysis**
2. Activa las siguientes opciones:

#### ✅ Dependency graph
- Visualiza las dependencias del proyecto

#### ✅ Dependabot alerts
- Recibe alertas de vulnerabilidades en dependencias

#### ✅ Dependabot security updates
- Crea PRs automáticos para actualizar dependencias vulnerables

#### ✅ Dependabot version updates (opcional)
- Mantiene las dependencias actualizadas

#### ✅ Code scanning (GitHub Advanced Security)
- Escaneo automático de código (requiere plan Pro/Enterprise)

#### ✅ Secret scanning
- Detecta secretos accidentalmente commiteados

### Configurar Dependabot

Crea el archivo `.github/dependabot.yml`:

```yaml
version: 2
updates:
  - package-ecosystem: "composer"
    directory: "/"
    schedule:
      interval: "weekly"
    open-pull-requests-limit: 10
```

---

## 🔄 Flujo de Trabajo Recomendado

### Estructura de Ramas

```
main (protegida, solo producción)
  ↑
develop (rama de desarrollo)
  ↑
feature/* (ramas de características)
hotfix/* (correcciones urgentes)
```

### Para el Owner (tú)

```bash
# 1. Crear nueva característica
git checkout develop
git pull origin develop
git checkout -b feature/nueva-caracteristica

# 2. Hacer cambios
git add .
git commit -m "feat: descripción del cambio"

# 3. Subir rama
git push -u origin feature/nueva-caracteristica

# 4. Crear Pull Request en GitHub
# - De: feature/nueva-caracteristica
# - A: develop

# 5. Revisar y aprobar tu propio PR (o pedir revisión)

# 6. Hacer merge a develop

# 7. Cuando esté listo para producción
# Crear PR de develop → main
# Aprobar y hacer merge a main
```

### Para Colaboradores

```bash
# 1. Fork o clonar repositorio
git clone https://github.com/victormanuelac/GhostNote.git
cd GhostNote

# 2. Crear rama desde develop
git checkout develop
git pull origin develop
git checkout -b feature/mi-caracteristica

# 3. Hacer cambios
git add .
git commit -m "feat: mi cambio"

# 4. Subir rama
git push -u origin feature/mi-caracteristica

# 5. Crear Pull Request en GitHub
# - De: feature/mi-caracteristica
# - A: develop

# 6. Esperar aprobación del owner
# 7. El owner hace el merge
```

### Convenciones de Commits

Usa [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: nueva característica
fix: corrección de bug
docs: cambios en documentación
style: cambios de formato (no afectan el código)
refactor: refactorización de código
test: agregar o modificar tests
chore: tareas de mantenimiento
```

---

## ✅ Checklist de Seguridad

Marca cada item cuando lo completes:

- [ ] Rama `main` protegida con reglas
- [ ] Require pull request before merging activado
- [ ] Require approvals configurado (mínimo 1)
- [ ] Restrict who can push activado
- [ ] Allow force pushes DESACTIVADO
- [ ] Allow deletions DESACTIVADO
- [ ] 2FA activado en tu cuenta
- [ ] Tokens de acceso personal creados
- [ ] Dependabot alerts activado
- [ ] Dependabot security updates activado
- [ ] Secret scanning activado
- [ ] Colaboradores configurados con roles apropiados
- [ ] Plantilla de PR creada
- [ ] `.gitignore` configurado correctamente
- [ ] Archivo `.env` NO está en el repositorio

---

## 📞 Soporte

Si tienes dudas sobre la configuración de seguridad:

1. Consulta la [documentación oficial de GitHub](https://docs.github.com/en/repositories/configuring-branches-and-merges-in-your-repository/managing-protected-branches/about-protected-branches)
2. Revisa esta guía nuevamente
3. Contacta al administrador del repositorio

---

**⚠️ IMPORTANTE**: Estas configuraciones de seguridad son críticas para mantener la integridad del código en producción. No las omitas ni desactives sin una razón válida.
