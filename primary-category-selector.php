<?php

/**
 * Plugin Name:       Primary Category Selector
 * Description:       A plugin that allows publishers to designate a primary category for posts or custom post types.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Jamalah Bryan
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       primary-category-selector
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PRIMARY_CATEGORY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PRIMARY_CATEGORY_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once PRIMARY_CATEGORY_PLUGIN_DIR . '/src/classes/class-primary-category-selector.php';

add_action('plugins_loaded', array('Primary_Category_Selector', 'init'));
