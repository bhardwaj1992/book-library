<?php
/**
 * Plugin Name:       Book Library
 * Plugin URI:        https://www.multidots.com/
 * Description:       Book Library with filtering options
 * Version:           1.0
 * Author:            Devendra Bhardwaj
 * Author URI:        https://www.multidots.com/ 
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'PLUGIN_NAME_VERSION', '1.0' );
require plugin_dir_path( __FILE__ ) . 'class-book-library-plugin.php';


// Run the plugin. 

function run_book_library_plugin() {
	$plugin = new Book_Library_Plugin();
}
run_book_library_plugin();
