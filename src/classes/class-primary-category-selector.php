<?php

if (!defined('ABSPATH')) {
	exit;
}

class Primary_Category_Selector
{

	/**
	 * Initialize the plugin by setting up hooks.
	 */
	public static function init()
	{
		add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_script'));
		add_action('add_meta_boxes', array(__CLASS__, 'add_primary_category_meta_box'));
		add_action('save_post', array(__CLASS__, 'save_primary_category'));
		add_filter('pre_get_posts', array(__CLASS__, 'modify_query_for_primary_category'));
		add_shortcode('primary_category_posts', array(__CLASS__, 'primary_category_posts_shortcode'));
	}

	/**
	 * Add a meta box to the post editing screen to select a primary category.
	 */
	public static function add_primary_category_meta_box()
	{
		$post_types = get_post_types(array('public' => true), 'names');
		foreach ($post_types as $post_type) {
			add_meta_box(
				'primary_category',
				__('Primary Category', 'primary-category-selector'),
				array(__CLASS__, 'render_primary_category_meta_box'),
				$post_type,
				'side',
				'high'
			);
		}
	}

	/**
	 * Render the primary category meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public static function render_primary_category_meta_box($post)
	{
		echo '<div id="primary-category-selector-root"></div>';
		wp_nonce_field('save_primary_category', 'primary_category_nonce');
	}

	/**
	 * Save the primary category when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public static function save_primary_category($post_id)
	{
		if (!isset($_POST['primary_category_nonce']) || !wp_verify_nonce($_POST['primary_category_nonce'], 'save_primary_category')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		$primary_category = isset($_POST['primary_category']) ? sanitize_text_field($_POST['primary_category']) : '';

		if ($primary_category) {
			update_post_meta($post_id, '_primary_category', $primary_category);
		} else {
			delete_post_meta($post_id, '_primary_category');
		}
	}

	/**
	 * Modify the query to filter by primary category.
	 *
	 * @param WP_Query $query The WP_Query instance (passed by reference).
	 */
	public static function modify_query_for_primary_category($query)
	{
		if (!is_admin() && $query->is_main_query() && $query->is_category()) {
			$primary_category_id = get_queried_object_id();
			$meta_query = array(
				array(
					'key'     => '_primary_category',
					'value'   => $primary_category_id,
					'compare' => '='
				)
			);
			$query->set('meta_query', $meta_query);
		}
	}

	/**
	 * Shortcode to list posts by primary category.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML content to display.
	 */
	public static function primary_category_posts_shortcode($atts)
	{
		$atts = shortcode_atts([
			'category' => '',
			'number' => 5,
			'post_type' => '',
		], $atts, 'primary_category_posts');

		$category_id = intval($atts['category']);
		$number = intval($atts['number']);
		$post_type = sanitize_text_field($atts['post_type']);

		if (!$category_id) {
			return '<p>Please specify a valid category ID.</p>';
		}

		$args = [
			'meta_key' => '_primary_category',
			'meta_value' => $category_id,
			'posts_per_page' => $number,
		];

		$args['post_type'] = empty($post_type) ? get_post_types(['public' => true]) : $post_type;

		$query = new WP_Query($args);
		$output = '<ul>';

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$output .= sprintf(
					'<li><a href="%1$s">%2$s</a></li>',
					esc_url(get_permalink()),
					esc_html(get_the_title())
				);
			}
			wp_reset_postdata();
		} else {
			$output .= '<li>No posts found.</li>';
		}

		$output .= '</ul>';

		return $output;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @param string $hook 	Page hook suffix.
	 */
	public static function enqueue_script($hook)
	{
		$asset_file = include PRIMARY_CATEGORY_PLUGIN_DIR . 'build/index.asset.php';

		foreach ($asset_file['dependencies'] as $style) {
			wp_enqueue_style($style);
		}

		wp_enqueue_style(
			'primary-category-selector-style',
			PRIMARY_CATEGORY_PLUGIN_URL . 'build/index.css',
			array(),
			$asset_file['version']
		);

		wp_enqueue_script(
			'primary-category-selector-script',
			PRIMARY_CATEGORY_PLUGIN_URL . 'build/index.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_localize_script(
			'primary-category-selector-script',
			'primaryCategorySelector',
			array(
				'primaryCategory' => get_post_meta(get_the_ID(), '_primary_category', true)
			)
		);
	}
}
