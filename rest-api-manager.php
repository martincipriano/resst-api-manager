<?php
/**
 * Plugin Name: Rest API Manager
 * Description: A WordPress plugin to allow the users to toggle the REST API endpoints on and off.
 * Author: Jose Martin Cipriano
 * Version: 1.0.0
 * Author URI: https://www.linkedin.com/in/jmcipriano
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
  exit;
}

class REST_API_Manager {

  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    add_action('admin_menu', [$this, 'options_menu']);
  }

  public function enqueue_scripts(): void
  {
    $stylesheet_url = plugin_dir_url(__FILE__) . 'rest-api-manager.css';
    $stylesheet_path = plugin_dir_path(__FILE__) . 'rest-api-manager.css';
    $stylesheet_version = filemtime($stylesheet_path);

    wp_enqueue_style('rest-api-manager', $stylesheet_url, [], $stylesheet_version);
  }

  public function options_menu() : void
  {
    add_menu_page('REST API Manager', 'API Manager', 'manage_options', 'rest-api-manager', [$this, 'options_page']);
  }

  public function options_page() : void
  {
    $server = rest_get_server();
    $routes = $server->get_routes();
    $endpoints = get_option('rest_api_manager');
    $endpoints = $endpoints ? $endpoints : []; ?>

    <div class="wrap" id="rest-api-manager">

      <?php if (isset($_GET['updated'])) { ?>
        <div class="notice notice-success is-dismissible">
          <p>Settings updated successfully.</p>
        </div>
      <?php } ?>

      <h1>Rest API Manager</h1>
      <p><strong>Important reminders:</strong></p>
      <ul>
        <li>Check if WordPress core features (e.g., Block Editor/Gutenberg, admin functionality) rely on the endpoint.</li>
        <li>Identify plugins or themes that utilize the REST API and may break if access is restricted.</li>
        <li>Blocking parent endpoints (e.g., /wp/v2/posts) can implicitly block child routes (e.g., /wp/v2/posts/<id>).</li>
      </ul>

      <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="save_rest_api_endpoints">
        <?php
          wp_nonce_field('rest_api_manager');
        ?>
        <p class="submit"><button class="button button-primary" type="submit">Save Settings</button></p>
      </form>
    </div>
    <?php
  }
}

new REST_API_Manager;
