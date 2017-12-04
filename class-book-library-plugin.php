<?php
/**
 * This file have plugin class
 */
class Book_Library_Plugin {
	
	protected $plugin_name;
	protected $version;


// Define the core functionality of the plugin.		
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0';
		}
		$this->plugin_name = 'book-library';

		$this->load_dependencies();
		$this->define_public_hooks();
		$this->define_admin_hooks();

	}

	// Load the required dependencies for this plugin.	
	private function load_dependencies() {	
		require_once plugin_dir_path( __FILE__ ) . '/class-book-library-admin.php';
		require_once plugin_dir_path( __FILE__) . '/class-book-library-frontend.php';
	}

	// Load frontend functionality	 
	private function define_public_hooks() {
		$plugin_public = new Book_Library_Frontend( $this->get_plugin_name(), $this->get_version() );
	}


	// Load admin functionality	 	
	private function define_admin_hooks() {
		$plugin_admin = new Book_Library_Admin( $this->get_plugin_name(), $this->get_version() );
	}

	
	// Get Plugin Name		
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	
	// Get plugin version.	
	
	public function get_version() {
		return $this->version;
	}

}
