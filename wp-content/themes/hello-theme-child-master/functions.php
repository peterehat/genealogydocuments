<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

function add_glb_mime_types( $mime_types ) {
    $mime_types['glb'] = 'model/gltf-binary';
    return $mime_types;
}
add_filter( 'upload_mimes', 'add_glb_mime_types' );

// 3D Model Post Type

function create_3d_model_post_type() {
    $labels = array(
        'name'               => _x('3D Models', 'Post Type General Name', 'textdomain'),
        'singular_name'      => _x('3D Model', 'Post Type Singular Name', 'textdomain'),
        'menu_name'          => __('3D Models', 'textdomain'),
        'name_admin_bar'     => __('3D Model', 'textdomain'),
        'add_new'            => __('Add New', 'textdomain'),
        'add_new_item'       => __('Add New 3D Model', 'textdomain'),
        'new_item'           => __('New 3D Model', 'textdomain'),
        'edit_item'          => __('Edit 3D Model', 'textdomain'),
        'view_item'          => __('View 3D Model', 'textdomain'),
        'all_items'          => __('All 3D Models', 'textdomain'),
        'search_items'       => __('Search 3D Models', 'textdomain'),
        'not_found'          => __('No 3D models found', 'textdomain'),
        'not_found_in_trash' => __('No 3D models found in Trash', 'textdomain'),
    );

    $args = array(
        'label'              => __('3D Models', 'textdomain'),
        'description'        => __('Custom post type for 3D models', 'textdomain'),
        'labels'             => $labels,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        //'taxonomies'         => array('category', 'post_tag'),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-image', // Icon for the post type
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,
        'can_export'         => true,
        'has_archive'        => true,
        'exclude_from_search'=> false,
        'publicly_queryable' => true,
        'capability_type'    => 'post',
        'rewrite'            => array( 'slug' => false, 'with_front' => false ),
    );

    register_post_type('3d_model', $args);
}

add_action('init', 'create_3d_model_post_type');



