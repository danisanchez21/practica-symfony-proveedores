# 📦 Practica Symfony

Este repositorio contiene una aplicación web desarrollada con Symfony 4, Twig para el renderizado de vistas, MySQL como base de datos y un entorno Docker listo para desarrollo y despliegue.

---

## 💼 Propuesta de proyecto

El objetivo de esta prueba técnica consiste en desarrollar una aplicación para que el departamento de contabilidad pueda gestionar los datos de los proveedores con los que se trabaja habitualmente. La aplicación permite realizar operaciones CRUD (crear, editar, eliminar y visualizar) sobre los proveedores.

### 📋 Datos requeridos para cada proveedor

* **Nombre**
* **Correo electrónico**
* **Teléfono de contacto**
* **Tipo de proveedor**: hotel, pista o complemento
* **Estado**: activo o no
* **Fecha de creación** y **última actualización**

---

## ⚙ Funcionalidades implementadas

* Panel principal con listado completo de proveedores
* Filtros por estado, tipo y fecha
* Paginación del listado
* Validaciones en todos los formularios
* Sistema de login con autenticación de usuarios
* Vistas diseñadas con Tailwind CSS
* Interfaz responsive pensada para la experiencia de usuario
* Proyecto completamente desplegable mediante Docker

---
## 💡 Requisitos previos

* Docker y Docker Compose instalados
* Node.js y npm instalados en la máquina host
* Composer instalado
* Conexión a Internet para instalar dependencias

---


## 🐳 Levantar el entorno con Docker (rama main)

Ejecuta el siguiente comando para construir las imágenes y levantar los contenedores:

```bash
docker compose up -d --build
```

Esto iniciará los servicios necesarios: PHP, MySQL y Nginx.

---

## 🛑 Parada y limpieza de contenedores

Para detener los contenedores y eliminar los volúmenes asociados:

```bash
docker compose down -v
```

---

## 🌐 Acceso a la aplicación

Una vez los contenedores estén funcionando, accede a la aplicación en:

```
http://localhost:8080/login
```

---

## 🔐 Credenciales de acceso por defecto

* **Correo:** [admin@example.com]
* **Contraseña:** admin123
---
## 🚨 Aviso importante sobre ejecución

> **Nota:** Si el entorno Docker no funciona correctamente en la rama `main`, puedes utilizar la rama `dev`, donde la aplicación puede ejecutarse sin depender de Docker.

Para cambiar a la rama funcional sin Docker:

```bash
git switch dev
```
1. Asegúrate de tener una BBDD con la siguiente estructura:

<details>
  <summary>Mostrar estructura</summary>

  ![Estructura de la BBDD](https://github.com/user-attachments/assets/41bf94d7-6a0e-4d82-8594-a8344608ec50)

</details>

2. Crear un usuario administrador desde consola:

```bash
# Este proyecto incluye un comando personalizado para crear usuarios con rol de administrador sin necesidad de un formulario.
```
---

### 🛠️ Sintaxis del comando

```bash
php bin/console app:create-user EMAIL CONTRASEÑA
```

### 💉 Ejemplo

```bash
php bin/console app:create-user admin@example.com password
```

Esto creará un nuevo usuario en la base de datos con:

- 📧 **Email:** `admin@example.com`
- 🔐 **Contraseña:** `password` (almacenada de forma segura y hasheada)  
- 🛡️ **Rol asignado:** `ROLE_ADMIN


```bash
# Luego seguir las instrucciones de instalación desde el README de la rama `dev` o ejecutar el servidor de Symfony manualmente.
```
---


## 🧱 Instalación de dependencias

1. Sitúate en la raíz del proyecto:

   ```bash
   cd practica-symfony-proveedores
   ```

2. Instala las dependencias de Node.js y compila los assets de Tailwind:

   ```bash
   npm install
   npm run dev
   ```

3. Instala las dependencias de PHP con Composer (desde la máquina host):

   ```bash
   composer install
   ```

---

## 🐳 Levantar el entorno con Docker (rama main)

Ejecuta el siguiente comando para construir las imágenes y levantar los contenedores:

```bash
docker compose up -d --build
```

Esto iniciará los servicios necesarios: PHP, MySQL y Nginx.

---

## 🛑 Parada y limpieza de contenedores

Para detener los contenedores y eliminar los volúmenes asociados:

```bash
docker compose down -v
```

---

## 🌐 Acceso a la aplicación

Una vez los contenedores estén funcionando, accede a la aplicación en:

```
http://localhost:8080/login
```

---

## 🔐 Credenciales de acceso por defecto

* **Correo:** [admin@example.com]
* **Contraseña:** admin123

---


## 🗒 Notas finales

Se ha seguido el enfoque propuesto en la prueba, evitando la generación automática de CRUDs con comandos Symfony.

### Extras incluidos

* Sistema de autenticación
* Filtros avanzados y ordenación
* Paginación personalizada
* Maquetación responsiva pensada para entorno PC y Yablet con Tailwind CSS

---

**Desarrollado por:** \[Daniel Sánchez Aránega]

**Contacto:** \[[danisanchez.a@outlook.com](mailto:danisanchez.a@outlook.com)]
