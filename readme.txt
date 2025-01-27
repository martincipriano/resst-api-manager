=== REST API Manager ===
Contributors: martincipriano
Donate link: https://www.paypal.me/martincipriano
Tags: REST API, endpoint management, admin
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin to manage REST API endpoints, enabling you to toggle them on and off.

== Description ==

REST API Manager is a powerful plugin designed for administrators to gain better control over WordPress REST API endpoints. This plugin provides a simple interface to toggle specific endpoints on or off, offering improved security and customization for your site.

**Features:**
- View all registered REST API endpoints.
- Enable or disable specific endpoints with a single click.
- Prevent unauthorized access to sensitive data via REST API.
- Fully integrates with the WordPress admin dashboard.

**Use Cases:**
- Enhance security by disabling unused or vulnerable API endpoints.
- Improve performance by reducing REST API traffic.
- Customize REST API availability to suit your site's requirements.

== Installation ==

1. Upload the `rest-api-manager` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to **REST API** in the admin menu to start managing your endpoints.

== Frequently Asked Questions ==

= Will this plugin break my website? =
While this plugin provides flexibility in managing endpoints, disabling essential endpoints could affect core functionalities (e.g., Gutenberg or plugins relying on the REST API). Use caution and test thoroughly before disabling endpoints.

= Can I revert my changes if something breaks? =
Yes, re-enable the disabled endpoints via the plugin interface or deactivate the plugin to restore default functionality.

= Does this plugin support custom endpoints? =
Yes! Any registered custom endpoint will appear in the plugin settings page.

== Screenshots ==

1. **Manage REST API Endpoints:** A simple interface to toggle endpoints on or off.
![screenshot-1.png](screenshot-1.png)

== Changelog ==

= 1.0.0 =
* Initial release.
* Manage REST API endpoints via the admin interface.
* Secure and straightforward endpoint toggling.

== Upgrade Notice ==

= 1.0.0 =
Initial release - safe to use on live sites, but ensure to test endpoint changes on staging first.

== License ==

This plugin is licensed under the GPLv2 or later. See [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html) for details.
