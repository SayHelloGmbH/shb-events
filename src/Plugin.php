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

		$labels = apply_filters(
			'shp-events_post_type_labels',
			[
				'name'                  => _x('Events', 'Post type general name', 'textdomain'),
				'singular_name'         => _x('Event', 'Post type singular name', 'textdomain'),
				'menu_name'             => _x('Events', 'Admin Menu text', 'textdomain'),
				'name_admin_bar'        => _x('Event', 'Add New on Toolbar', 'textdomain'),
				'add_new'               => __('Add New', 'textdomain'),
				'add_new_item'          => __('Add new event', 'textdomain'),
				'new_item'              => __('New event', 'textdomain'),
				'edit_item'             => __('Edit event', 'textdomain'),
				'view_item'             => __('View event', 'textdomain'),
				'all_items'             => __('All events', 'textdomain'),
				'search_items'          => __('Search events', 'textdomain'),
				'parent_item_colon'     => __('Parent events:', 'textdomain'),
				'not_found'             => __('No events found.', 'textdomain'),
				'not_found_in_trash'    => __('No events found in Trash.', 'textdomain'),
				'featured_image'        => _x('Event cover image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
				'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
				'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
				'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
				'archives'              => _x('Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
				'insert_into_item'      => _x('Insert into event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
				'uploaded_to_this_item' => _x('Uploaded to this event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
				'filter_items_list'     => _x('Filter events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
				'items_list_navigation' => _x('Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
				'items_list'            => _x('Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
			]
		);

		$capabilities = apply_filters('shp-events_post_type_capabilities', [
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
		]);

		$args = apply_filters('shp-events_post_type_args', [
			'can_export' => false,
			'capabilities'	=> $capabilities,
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
				'slug' => 'event'
			],
			'supports' => ['title', 'editor', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields'],
			'taxonomies' => [],
			'labels' => $labels
		]);

		register_post_type('shp_event', $args);
	}

	/**
	 * Add user capabilities
	 */
	public function addCapabilities()
	{
		$admin = get_role('administrator');
		$admin->add_cap('edit_shp_event');
		$admin->add_cap('delete_shp_event');
		$admin->add_cap('read_shp_event');
		$admin->add_cap('publish_shp_event');
		$admin->add_cap('edit_shp_events');
		$admin->add_cap('delete_shp_events');
		$admin->add_cap('read_shp_events');
		$admin->add_cap('publish_shp_events');
	}
}
