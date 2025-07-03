# 📦 Práctica Symfony

Este repositorio contiene una aplicación web desarrollada con Symfony 4, Twig para el renderizado de vistas, MySQL como base de datos y un entorno Docker listo para desarrollo y despliegue.

---

## 💼 Propuesta de proyecto

El objetivo de esta prueba técnica consiste en desarrollar una aplicación para que el departamento de contabilidad pueda gestionar los datos de los proveedores con los que se trabaja habitualmente. La aplicación permite realizar operaciones CRUD (crear, editar, eliminar y visualizar) sobre los proveedores.

### 📋 Datos requeridos para cada proveedor

- **Nombre**
- **Correo electrónico**
- **Teléfono de contacto**
- **Tipo de proveedor**: hotel, pista o complemento
- **Estado**: activo o no
- **Fecha de creación** y **última actualización**

---

## ⚙ Funcionalidades implementadas

- Panel principal con listado completo de proveedores
- Filtros por estado, tipo, fecha, etc.
- Paginación del listado
- Paneles para creación, edición y borrado de proveedores
- Validaciones en todos los formularios
- Sistema de login con autenticación para usuarios administradores
- Vistas diseñadas con Twig & estilos TailwindCSS
- Interfaz responsive pensada para la experiencia de usuario
- Proyecto completamente desplegable mediante Docker

---

## 💡 Requisitos previos

- Docker y Docker Compose
- Dependencias PHP
- Node Package Manager

---

## 🐳 Levantar el entorno con Docker

1. **Instalar y arrancar Docker:**

   Asegúrate de tener Docker y Docker Compose instalados y funcionando en tu sistema. Puedes descargarlos desde:

   👉 https://www.docker.com/products/docker-desktop/

   Una vez instalado, abre Docker Desktop (en Windows/macOS) o asegúrate de que el servicio esté activo (en Linux).

   > Este paso es necesario para poder levantar los contenedores del proyecto.  
   > Docker se encargará de simular los entornos necesarios como `PHP`, `Nginx`, `MySQL`.
   
2. **Clona y accede al repositorio:**

   ```bash
   git clone https://github.com/danisanchez21/practica-symfony-proveedores.git
   cd practica-symfony-proveedores
   ```
   >Este comando descarga (clona) una copia exacta del repositorio que está alojado en GitHub 
   >(en este caso, el proyecto llamado `practica-symfony-proveedores` ) a tu ordenador.

3. **Levanta los contenedores:**

   ```bash
   docker compose up -d --build
   ```

   > Este comando levantará automáticamente los servicios necesarios (`PHP`, `Nginx`, `MySQL`)  
   > y creará la base de datos con un usuario administrador preconfigurado.

4. **Instala las dependencias de PHP:**

   ```bash
   docker compose exec php composer install
   ```

   > Esto instalará todas las dependencias definidas en tu `composer.json`  
   > dentro del contenedor `php`.

5. **Instala y ejecuta las dependencias de Node.js:**

   ```bash
   npm install
   npm run dev
   ```

   > Estos comandos instalan las dependencias de JavaScript y arrancan el frontend en modo desarrollo.

---

## 🌐 Acceso a la aplicación

Una vez los contenedores estén funcionando, accede a la aplicación en:

```
http://localhost:8080/login
```

---

## 🔐 Credenciales de acceso preconfiguradas

- **Correo:** admin@example.com  
- **Contraseña:** admin123

> **En la BBDD se almacenan de la siguiente manera:**
>
> - 📧 **Email:** `admin@example.com`  
> - 🔐 **Contraseña:** `password` (almacenada de forma segura y hasheada)  
> - 🛡️ **Rol asignado:** `ROLE_ADMIN`

---

## 🛑 Parada y limpieza de contenedores

Para **detener** los contenedores y eliminar los volúmenes asociados:

```bash
docker compose down -v
```

> ⚠️ **Precaución**: 
>  
> ¡No lo uses si quieres mantener tus datos actuales! Porque perderás toda la información almacenada en los volúmenes.

---

## 🗒 Notas finales

Se ha seguido el enfoque propuesto en la prueba, evitando la generación automática de CRUD con comandos Symfony.

### Extras incluidos

- Sistema de autenticación
- Filtros avanzados y ordenación
- Paginación personalizada
- Maquetación responsiva pensada para entorno PC y Tablet con Tailwind CSS

---

**Desarrollado por:** Daniel Sánchez Aránega  
**Contacto:** [danisanchez.a@outlook.com](mailto:danisanchez.a@outlook.com)
