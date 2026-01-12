# 📧 Guía de Implementación del Formulario de Contacto

## ✅ Archivos Creados

1. **`public/contact.php`** - Backend PHP que procesa el formulario
2. **`public/.htaccess`** - Configuración para Apache (enrutamiento Vue + acceso a PHP)
3. **`src/components/HomeContactFooter.vue`** - Actualizado con lógica de envío

## 🚀 Pasos para Despliegue en Hostinger

### 1. Configurar el Email en contact.php

⚠️ **IMPORTANTE**: Antes de hacer el build, abre `public/contact.php` y cambia esta línea:

```php
$to_email = 'info@construcasaomodern.com'; // ⚠️ CAMBIAR POR TU EMAIL REAL
```

Reemplázala con tu dirección de correo electrónico real donde quieres recibir los mensajes.

### 2. Hacer el Build

Ejecuta el comando de build para generar los archivos de producción:

```bash
npm run build
```

Esto creará una carpeta `dist/` con todos los archivos necesarios, incluyendo:
- `index.html`
- `contact.php` (copiado automáticamente desde `public/`)
- `.htaccess` (copiado automáticamente desde `public/`)
- Carpeta `assets/` con JS y CSS
- Carpeta `images/` si tienes imágenes

### 3. Subir Archivos a Hostinger

1. Accede al **File Manager** de Hostinger
2. Navega a la carpeta `public_html` (o el directorio raíz de tu dominio)
3. **Sube TODO el contenido** de la carpeta `dist/`:
   - `index.html`
   - `contact.php`
   - `.htaccess`
   - Carpeta `assets/`
   - Carpeta `images/`
   - Cualquier otro archivo generado

### 4. Verificar Permisos

Asegúrate de que el archivo `contact.php` tenga permisos de ejecución (644 o 755).

### 5. Probar el Formulario

1. Visita tu sitio web
2. Navega a la sección de contacto
3. Completa y envía el formulario
4. Deberías ver un mensaje de éxito y recibir un email

## 🔧 Solución de Problemas

### El correo no llega

1. **Verifica la configuración de email en contact.php**
   - Asegúrate de haber cambiado `$to_email` con tu dirección real

2. **Revisa la función mail() de PHP**
   - Algunos hostings requieren configuración adicional
   - Contacta al soporte de Hostinger si `mail()` no funciona
   - Considera usar alternativas como PHPMailer o SendGrid

3. **Revisa la carpeta de SPAM**
   - Los correos pueden llegar a spam la primera vez

### Error 404 al enviar el formulario

- Verifica que `contact.php` esté en la raíz junto a `index.html`
- Asegúrate de que `.htaccess` también esté presente

### Error de CORS

- El archivo PHP ya incluye headers CORS configurados
- Si tienes problemas, ajusta la línea `Access-Control-Allow-Origin` en `contact.php`

### El formulario muestra "Error de conexión"

- Verifica que el archivo PHP tenga permisos correctos (644 o 755)
- Revisa los logs de error de PHP en Hostinger para más detalles

## 📝 Funcionalidades Implementadas

✅ Validación de datos en el backend (PHP)
✅ Sanitización de inputs para prevenir XSS
✅ Validación de email con expresiones regulares
✅ Envío de correo con formato HTML profesional
✅ Respuestas JSON estructuradas
✅ Manejo de errores en frontend y backend
✅ Indicador de carga durante el envío
✅ Mensajes de éxito/error visibles al usuario
✅ Limpieza automática del formulario tras envío exitoso
✅ CORS configurado para producción
✅ Compatible con Hostinger (solo PHP, sin Node.js)

## 🛠️ Desarrollo Local (Opcional)

Si quieres probar el formulario en desarrollo local, necesitarás un servidor PHP:

### Opción 1: Usar el servidor PHP integrado
```bash
# En una terminal separada, desde la carpeta del proyecto
cd public
php -S localhost:8000
```

Luego configura un proxy en `vite.config.js`:
```javascript
export default defineConfig({
  // ... resto de configuración
  server: {
    proxy: {
      '/contact.php': 'http://localhost:8000'
    }
  }
})
```

### Opción 2: Usar XAMPP/WAMP
- Coloca el proyecto en `htdocs/` o `www/`
- Accede vía `http://localhost/tu-proyecto/`

## 📧 Personalización del Email

Para personalizar el correo que se envía, edita la sección HTML en `public/contact.php`:

```php
$email_body = "
<!DOCTYPE html>
<html>
<head>
    <!-- Aquí puedes modificar los estilos del email -->
```

## 🔒 Seguridad

El código implementa varias medidas de seguridad:

- ✅ Sanitización de inputs con `htmlspecialchars()`
- ✅ Validación de email con `FILTER_VALIDATE_EMAIL`
- ✅ Validación de longitud de campos
- ✅ Solo acepta peticiones POST
- ✅ Headers de seguridad configurados
- ✅ Prevención de inyección SQL (no usa base de datos)
- ✅ Escape de caracteres en el email

## 📞 Soporte

Si tienes problemas:
1. Revisa los logs de error de PHP en Hostinger
2. Activa el logging descomentando las líneas al final de `contact.php`
3. Contacta al soporte de Hostinger para verificar que `mail()` esté habilitado

---

**¡Listo!** Tu formulario de contacto está completamente funcional y listo para producción. 🎉
