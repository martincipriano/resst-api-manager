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
}

new REST_API_Manager;
