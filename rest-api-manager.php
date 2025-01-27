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
    add_action('admin_init', [$this, 'register_settings']);
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
    add_options_page('REST API Manager', 'REST API Manager', 'manage_options', 'rest_api_manager', [$this, 'options_page']);
  }

  public function options_page(): void
  { ?>
    <div class="wrap" id="rest-api-manager">
      <h1><?php esc_html_e('REST API Manager', 'rest-api-manager'); ?></h1>
      <form action="options.php" method="post">
        <?php
          settings_fields('rest_api_manager');
          do_settings_sections('rest_api_manager');
          submit_button(__('Save Settings', 'rest-api-manager'));
        ?>
      </form>
    </div>
  <?php }

  public function register_settings(): void
  {
    register_setting('rest_api_manager', 'rest_api_manager_settings');
    add_settings_section('rest_api_manager_main', null, null, 'rest_api_manager');
    add_settings_field('rest_api_block_option', null, [$this, 'render_block_option'], 'rest_api_manager', 'rest_api_manager_main');
  }

  public function render_block_option(): void
  {
    $server = rest_get_server();
    $routes = $server->get_routes();
    $endpoints = get_option('rest_api_manager_settings');
    $endpoints = $endpoints ? $endpoints : [];

    $grouped_routes = [];
    foreach ($routes as $endpoint => $route) {
      $group = explode('/', $endpoint)[1];
      $grouped_routes[$group][$endpoint] = $route;
    }
    $key = 0;
    foreach ($grouped_routes as $group => $routes) { ?>
      <h2><?php echo esc_html($group); ?></h2>
      <?php foreach ($routes as $endpoint => $route) {
        $checked = in_array($endpoint, $endpoints) ? 'checked' : ''; ?>
        <p>
          <label for="field-<?php echo esc_attr($key); ?>">
            <input <?php echo esc_attr($checked); ?> id="field-<?php echo esc_attr($key) ?>" name="rest_api_manager_settings[]" type="checkbox" value="<?php echo esc_attr($endpoint); ?>">
            <span class="slider"></span>
            <span><?php echo esc_html($endpoint); ?></span>
          </label>
          <a href="<?php echo esc_attr(site_url('wp-json')); ?><?php echo esc_attr($endpoint); ?>" target="_blank">View</a>
        </p>
        <?php $key++;
      }
    }
  }

  public function block_rest_api_endpoints($result)
  {
    if (isset($_SERVER['REQUEST_URI'])) {
      $endpoints = get_option('rest_api_manager_settings');
      $request_uri = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']));
      if ($request_uri && $endpoints) {
        foreach ($endpoints as $endpoint_pattern) {
          $regex_pattern = '@' . preg_replace('/\(\?P<\w+>/', '(', $endpoint_pattern) . '$@';
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
