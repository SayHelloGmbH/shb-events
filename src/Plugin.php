<?php

namespace SayHello\ShpEvents;

use function SayHello\ShpEvents\sayhello_plugin_events_get_instance;

class Plugin
{
	private static $instance;
	public $name = '';
	public $prefix = '';
	public $version = '';
	public $file = '';

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @param  string $file The file from which the class is being instantiated.
	 * @return object       The class instance.
	 */
	public static function getInstance($file)
	{
		if (!isset(self::$instance) && !(self::$instance instanceof Plugin)) {
			self::$instance = new Plugin;

			if (!function_exists('get_plugin_data')) {
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data($file);

			self::$instance->name = $data['Name'];
			self::$instance->prefix = 'shp_events';
			self::$instance->version = $data['Version'];
			self::$instance->file = $file;

			self::$instance->run();
		}
		return self::$instance;
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 */
	private function run()
	{
		add_action('init', [$this, 'registerPostType']);
		add_action('init', [$this, 'addCapabilities']);
		add_action('plugins_loaded', array($this, 'loadPluginTextdomain'));
	}

	/**
	 * Load translation files from the indicated directory.
	 */
	public function loadPluginTextdomain()
	{
		load_plugin_textdomain('shp_events', false, dirname(plugin_basename($this->file)) . '/languages');
	}

	/**
	 * Registers the custom post type
	 * @return void
	 */
	public function registerPostType()
	{

		$args = apply_filters('shp-events__post_type_args', [
			'can_export' => false,
			'capabilities'	=> [
				'read' => 'read_shp_event',
				'edit_post' => 'edit_shp_event',
				'read_post' => 'read_shp_event',
				'delete_post' => 'delete_shp_event',
				'edit_posts' => 'edit_shp_event',
				'edit_others_posts' => 'edit_others_shp_event',
				'publish_posts' => 'publish_shp_event',
				'read_private_posts' => 'read_private_shp_event',
				'delete_posts' => 'delete_shp_event',
				'delete_private_posts' => 'delete_private_shp_event',
				'delete_published_posts' => 'delete_published_shp_event',
				'delete_others_posts' => 'delete_others_shp_event',
				'edit_private_posts' => 'edit_private_shp_event',
				'edit_published_posts' => 'edit_published_shp_event',
			],
			'has_archive' => false,
			'map_meta_cap' => false,
			'menu_icon' => 'dashicons-calendar-alt',
			'public' => false,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
			'show_ui' => true,
			'menu_position' => 5,
			'rewrite' => [
				'slug' => _x('event', 'URL slug for custom post type', 'shp_fb_event')
			],
			'supports' => false,
			'taxonomies' => [],
			'labels' => [
				'name' => _x('Events', 'CPT name', 'shp_fb_event'),
				'singular_name' => _x('Event', 'CPT singular name', 'shp_fb_event'),
				'add_new' => _x('Termin erstellen', 'CPT add_new', 'shp_fb_event'),
				'add_new_item' => _x('Neuer Event', 'cpt name', 'shp_fb_event'),
				'edit_item' => _x('Event bearbeiten', 'cpt name', 'shp_fb_event'),
				'new_item' => _x('Neuer Event', 'cpt name', 'shp_fb_event'),
				'view_item' => _x('Event anzeigen', 'cpt name', 'shp_fb_event'),
				'view_items' => _x('Events anzeigen', 'cpt name', 'shp_fb_event'),
				'search_items' => _x('Events durchsuchen', 'cpt name', 'shp_fb_event'),
				'not_found' => _x('Keine Events', 'cpt name', 'shp_fb_event'),
				'not_found_in_trash' => _x('Keine Events im Papierkorb', 'cpt name', 'shp_fb_event'),
				'all_items' => _x('Alle Termine', 'cpt name', 'shp_fb_event'),
				'archives' => _x('Archiv', 'cpt name', 'shp_fb_event'),
				'attributes' => _x('Attribute', 'cpt name', 'shp_fb_event'),
				'name_admin_bar' => _x('Event', 'Label for name admin bar', 'shp_fb_event'),
			]
		]);

		register_post_type('shp_event', $args);
	}
}
