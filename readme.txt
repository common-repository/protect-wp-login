=== Protect WP Login ===
Contributors: clickar, alebuo
Tags: login, security, authentication, protect wp-login
Requires at least: 5.8
Tested up to: 6.6
Stable tag: 1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds an extra layer of security to the wp-login.php page by using authentication.

== Description ==

Protect WP Login is a powerful WordPress plugin designed to block bots and unauthorized users before they reach your `wp-login.php` page. By adding an additional layer of basic authentication via `.htaccess`, this plugin ensures that only users with the correct credentials can proceed to the WordPress login screen. This method minimizes unnecessary database queries and server load, effectively preventing brute force attacks without relying on resource-intensive CAPTCHA solutions.

**Key Features:**
- Protects the `wp-login.php` page with server-level authentication.
- Prevents unauthorized access to the WordPress dashboard.
- Reduces server load by denying access before reaching the WordPress login form.
- Compatible with most hosting environments supporting `.htaccess` files.

**How It Works:**

When someone tries to access the `wp-login.php` page, the server intercepts the request before it reaches the WordPress login screen. At this point, the plugin requires the user to enter an additional `username` and `password`, which are managed by the plugin. If the correct credentials are provided, the user is granted access to the standard WordPress login page. However, if the credentials are incorrect, access is denied, effectively blocking unauthorized attempts and reducing unnecessary server load caused by bot traffic.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/protect-wp-login` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the 'Protect WP Login' menu under the admin dashboard to configure the plugin.

== Frequently Asked Questions ==

= How does Protect WP Login differ from WordPress login credentials? =

The Protect WP Login plugin uses basic authentication via `.htaccess` to protect the login process before the WordPress login screen is displayed, ensuring that unauthorized users are blocked by the server itself, reducing the load on WordPress and the database. In contrast, WordPress login credentials are checked by WordPress after the login page is loaded.

= How do I add a new user? =

Go to the 'Protect WP Login' page under the admin menu, enter a username and password, and click 'Save'.

= How do I delete a user? =

On the same page, find the username you want to delete, and in the 'Actions' column, click 'Delete'.

= Do I need a complex username and password for the authentication prompt? =

No, even with a simple username and password, the plugin blocks unauthorized access attempts before they reach WordPress. This prevents bots from causing unnecessary server load, as they are stopped at the server level without WordPress or the database needing to process the request.

= How does the plugin help reduce server resource consumption? =

The plugin adds an authentication layer that activates before the WordPress login page is loaded. This means any brute force or unauthorized access attempt is blocked at the server level. By preventing WordPress and the database from processing bot requests, server resource consumption is significantly reduced.

= Does the plugin affect website performance? =

No, it actually improves it. By blocking unauthorized access attempts before they reach WordPress, the plugin reduces server load. This leads to fewer database queries and less CPU usage, improving the overall performance of the website.

= Do I need to enter the username and password every time I access the login page? =

Depending on your browser settings, it might store the username and password entered in the authentication prompt. This means that on future visits, the browser can automatically fill in the information, avoiding the need to re-enter it every time.

= What happens if a bot makes multiple incorrect login attempts? =

The plugin works with the server to block these attempts before they reach WordPress. Depending on your server’s security settings, multiple failed attempts may trigger firewall rules that permanently block the attacker’s IP, ensuring no further resource consumption.

= How can I save the username and password from the prompt in the browser (for example, in Chrome)? =

To save the username and password from the prompt in Chrome, you can follow these steps:

1. When the prompt appears asking for a username and password, enter the correct credentials.
2. After successfully entering the username and password, Chrome will prompt you with a pop-up at the top of the screen asking if you'd like to "Save password".
3. Click "Save" to ensure Chrome remembers these credentials for future sessions.

With this process, the next time you access the protected WordPress login page, Chrome will automatically fill in the username and password for the prompt, saving you from manually entering them each time.

== Screenshots ==

1. **Admin Page** - The Protect WP Login admin interface where you can easily add, manage, and view authentication credentials.
2. **Adding a new user** - Entering a new user and credentials.
3. **User Created Successfully** - Visual confirmation of a newly created user displayed on the admin page.
4. **List of existing users** - View of current users in Protect WP Login.
5. **Server-Level Login Prompt** - Example of the authentication prompt displayed at the server level before accessing the wp-login.php page.
6. **WordPress Login Page** - Once credentials are successfully entered, the user is redirected to the standard WordPress wp-login.php form.
7. **User Deletion** - User successfully deleted, and the updated list is displayed.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
* Initial release. No upgrade notices yet.
