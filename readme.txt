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

**REST API Manager** is a powerful plugin designed for administrators to gain better control over WordPress REST API endpoints. This plugin provides a simple interface to toggle specific endpoints on or off, offering improved security and customization for your site.

**Features:**
- View all registered REST API endpoints.
- Prevent unauthorized access to sensitive data by enabling/disabling specific endpoints.

**Use Cases:**
- Enhance security by disabling unused or vulnerable API endpoints.
- Improve performance by reducing REST API traffic.
- Customize REST API availability to suit your site's requirements.

== Installation ==

1. Upload the `rest-api-manager` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to **REST API Manager** under settings in the admin menu to manage your endpoints.

== Usage ==
- Activate/deactivate REST API endpoints from the REST API Manager settings by clicking the toggle UI.

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
* Created a settings page to list all the REST API endpoints.
* Created a custom toggle UI instead of checkboxes.
* Block deactivated REST API endpoints.

== Upgrade Notice ==

= 1.0.0 =
Initial release - safe to use on live sites, but ensure to test endpoint changes on staging first.

== License ==

This plugin is licensed under the GNU General Public License v2.0 or later.  
You may obtain a copy of the license at: https://www.gnu.org/licenses/gpl-2.0.html

== Screenshots ==
1. REST API Manager UI
  *Description: Displays a list of activated/deactivated REST API endpoints.*
