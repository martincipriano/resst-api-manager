<?php
/**
 * Plugin Name: REST API Manager
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
    add_action('admin_post_save_rest_api_endpoints', [$this, 'save_rest_api_endpoints']);
    add_filter('rest_authentication_errors', [$this, 'block_rest_api_endpoints'], 10, 1);
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
    add_options_page('REST API Manager','REST API Manager','manage_options','rest-api-manager',[$this, 'options_page']);
  }

  public function options_page() : void
  {
    $server = rest_get_server();
    $routes = $server->get_routes();
    $endpoints = get_option('rest_api_manager');
    $endpoints = $endpoints ? $endpoints : []; ?>

    <div class="wrap" id="rest-api-manager">

      <?php if (isset($_GET['updated']) && (isset($_GET['nonce']))) {
        $nonce = sanitize_text_field(wp_unslash($_GET['nonce']));
        if (wp_verify_nonce($nonce, 'rest_api_manager')) { ?>
          <div class="notice notice-success is-dismissible">
            <p>Settings updated successfully.</p>
          </div>
        <?php }
      } ?>

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
          
          $grouped_routes = [];
          foreach ($routes as $endpoint => $route) {
            $group = explode('/', $endpoint)[1];
            $grouped_routes[$group][$endpoint] = $route;
          }

          $key = 0;
          foreach ($grouped_routes as $group => $routes) { ?>
            <h2><?php echo esc_html($group); ?></h2>
            <?php foreach ($routes as $endpoint => $route) {
              $checked = in_array($endpoint, wp_unslash($endpoints)) ? 'checked' : ''; ?>
              <p>
                <label for="field-<?php echo esc_attr($key); ?>">
                  <input <?php echo esc_attr($checked); ?> id="field-<?php echo esc_attr($key) ?>" name="rest_api_manager[]" type="checkbox" value="<?php echo esc_attr($endpoint); ?>">
                  <span class="slider"></span>
                  <span><?php echo esc_html($endpoint); ?></span>
                </label>
                <a href="<?php echo esc_attr(site_url('wp-json')); ?><?php echo esc_attr($endpoint); ?>" target="_blank">View</a>
              </p>
              <?php $key++;
            }
          }
        ?>
        <p class="submit"><button class="button button-primary" type="submit">Save Settings</button></p>
      </form>
    </div>
    <?php
  }

  public function save_rest_api_endpoints() : void
  {
    if (isset($_POST['_wpnonce']) && isset($_POST['rest_api_manager'])) {
      $nonce = sanitize_text_field(wp_unslash($_POST['_wpnonce']));
      if (wp_verify_nonce($nonce, 'rest_api_manager')) {
        update_option('rest_api_manager', sanitize_text_field(wp_unslash($_POST['rest_api_manager'])) ?? []);
        wp_redirect(admin_url('admin.php?page=rest-api-manager&updated'));
      }
    }
    exit;
  }

  public function block_rest_api_endpoints($result)
  {
    $endpoints = get_option('rest_api_manager');
    if (isset($_SERVER['REQUEST_URI'])) {
      $request_uri = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']));
      if ($request_uri) {
        foreach ($endpoints as $endpoint_pattern) {
          $regex_pattern = '@' . preg_replace('/\(\?P<\w+>/', '(', wp_unslash($endpoint_pattern)) . '$@';
          if (preg_match($regex_pattern, $request_uri)) {
            return new \WP_Error('rest_forbidden', __('Access to this endpoint is forbidden.', 'rest-api-manager'), [
              'status' => 403
            ]);
          }
        }
        return $result;
      }
    }
    return $result;
  }
}

new REST_API_Manager;
