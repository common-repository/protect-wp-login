=== Protect WP Login ===
Contributors: clickar, alebuo
Tags: login, seguridad, autenticación, proteger wp-login
Requires at least: 5.8
Tested up to: 6.6
Stable tag: 1.0
Requires PHP: 7.4
License: GPLv2 o posterior
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Añade una capa adicional de seguridad a la página wp-login.php mediante autenticación.

== Descripción ==

Protect WP Login es un potente plugin de WordPress diseñado para bloquear bots y usuarios no autorizados antes de que lleguen a tu página `wp-login.php`. Al agregar una capa adicional de autenticación básica a través de `.htaccess`, este plugin garantiza que solo los usuarios con las credenciales correctas puedan acceder a la pantalla de inicio de sesión de WordPress. Este método minimiza las consultas innecesarias a la base de datos y la carga del servidor, previniendo eficazmente los ataques de fuerza bruta sin depender de soluciones CAPTCHA que consumen muchos recursos.

**Características clave:**
- Protege la página `wp-login.php` con autenticación a nivel del servidor.
- Evita el acceso no autorizado al panel de administración de WordPress.
- Reduce la carga del servidor al denegar el acceso antes de llegar al formulario de inicio de sesión de WordPress.
- Compatible con la mayoría de los entornos de hosting que soportan archivos `.htaccess`.

**Cómo funciona:**

Cuando alguien intenta acceder a la página `wp-login.php`, el servidor intercepta la solicitud antes de que llegue a la pantalla de inicio de sesión de WordPress. En este punto, el plugin requiere que el usuario ingrese un `nombre de usuario` y `contraseña` adicionales, gestionados por el plugin. Si se proporcionan las credenciales correctas, el usuario obtiene acceso a la página de inicio de sesión estándar de WordPress. Si las credenciales son incorrectas, se deniega el acceso, bloqueando eficazmente los intentos no autorizados y reduciendo la carga innecesaria en el servidor causada por el tráfico de bots.

== Instalación ==

1. Sube los archivos del plugin al directorio `/wp-content/plugins/protect-wp-login`.
2. Activa el plugin a través del menú 'Plugins' en WordPress.
3. Ve al menú 'Protect WP Login' en el panel de administración para configurar el plugin.

== Preguntas Frecuentes ==

= ¿En qué se diferencia Protect WP Login de las credenciales de inicio de sesión de WordPress? =

El plugin Protect WP Login utiliza autenticación básica a través de `.htaccess` para proteger el proceso de inicio de sesión antes de que se muestre la pantalla de inicio de sesión de WordPress, lo que garantiza que los usuarios no autorizados sean bloqueados por el propio servidor, reduciendo la carga en WordPress y en la base de datos. En contraste, las credenciales de inicio de sesión de WordPress son verificadas por WordPress después de cargar la página de inicio de sesión.

= ¿Cómo añado un nuevo usuario? =

Ve a la página 'Protect WP Login' en el menú de administración, ingresa un nombre de usuario y una contraseña, y haz clic en 'Guardar'.

= ¿Cómo elimino un usuario? =

En la misma página, encuentra el nombre de usuario que deseas eliminar y en la columna 'Acciones', haz clic en 'Eliminar'.
= ¿Es necesario tener un usuario y contraseña complejos para el prompt de autenticación? =

No es necesario. Incluso con un nombre de usuario y contraseña simples, el plugin bloquea los intentos de acceso no autorizados antes de que lleguen a WordPress. Esto evita que los bots causen carga innecesaria en el servidor, ya que son detenidos a nivel de servidor, sin que WordPress o la base de datos tengan que procesar la solicitud.

= ¿Cómo ayuda el plugin a reducir el consumo de recursos del servidor? =

El plugin añade un nivel de autenticación que se activa antes de que la página de inicio de sesión de WordPress se cargue. Esto significa que cualquier intento de fuerza bruta o acceso no autorizado se bloquea a nivel de servidor. Al evitar que WordPress y la base de datos procesen solicitudes de bots, se reduce significativamente la carga en los recursos del servidor.

= ¿El plugin afecta el rendimiento del sitio web? =

No, de hecho, lo mejora. Al bloquear intentos de acceso no autorizados antes de que lleguen a WordPress, el plugin reduce la carga en el servidor. Esto se traduce en menos consultas a la base de datos y un menor uso de CPU, mejorando así el rendimiento general del sitio web.

= ¿Es necesario ingresar el usuario y contraseña cada vez que accedo a la página de inicio de sesión? =

Dependiendo de la configuración de tu navegador, es posible que guarde el usuario y contraseña ingresados en el prompt de autenticación. Esto significa que, en futuras visitas, el navegador puede rellenar automáticamente la información, evitando que tengas que ingresarla manualmente cada vez.

= ¿Qué sucede si un bot intenta acceder varias veces con credenciales incorrectas? =

El plugin trabaja junto con el servidor para bloquear estos intentos antes de que lleguen a WordPress. Dependiendo de las configuraciones de seguridad de tu servidor, múltiples intentos fallidos pueden activar reglas de firewall que bloqueen permanentemente la IP del atacante, asegurando así que no siga consumiendo recursos.

= ¿Cómo puedo guardar el usuario y la contraseña del prompt en el navegador (por ejemplo, en Chrome)? =

Para guardar el usuario y la contraseña del prompt en Chrome, puedes seguir estos pasos:

1. Cuando aparezca el prompt solicitando usuario y contraseña, introduce las credenciales correspondientes.
2. Después de ingresar correctamente el usuario y la contraseña, Chrome te ofrecerá la opción de "Guardar contraseña" en una ventana emergente en la parte superior de la pantalla.
3. Haz clic en "Guardar" para que el navegador recuerde estas credenciales para futuras sesiones.

Con este proceso, la próxima vez que intentes acceder a la página de inicio de sesión de WordPress protegida, Chrome rellenará automáticamente el usuario y la contraseña del prompt, sin que tengas que ingresarlos manualmente.

== Capturas de Pantalla ==

1. **Página de administración** - La interfaz de administración de Protect WP Login, donde puedes agregar, gestionar y ver las credenciales de autenticación fácilmente.
2. **Añadiendo un nuevo usuario** - Ingresando un nuevo usuario y sus credenciales.
3. **Usuario creado exitosamente** - Confirmación visual de un usuario creado recientemente que se muestra en la página de administración.
4. **Lista de usuarios existentes** - Vista de los usuarios actuales en Protect WP Login.
5. **Solicitud de autenticación a nivel del servidor** - Ejemplo de la solicitud de autenticación que se muestra a nivel del servidor antes de acceder a la página wp-login.php.
6. **Página de inicio de sesión de WordPress** - Una vez que se ingresan las credenciales correctamente, el usuario es redirigido al formulario estándar de wp-login.php de WordPress.
7. **Eliminación de usuario** - Usuario eliminado con éxito y la lista actualizada se muestra.

== Registro de Cambios ==

= 1.0 =
* Lanzamiento inicial.

== Aviso de Actualización ==

= 1.0 =
* Lanzamiento inicial. No hay avisos de actualización por el momento.
