<?php
/*
 Plugin Name: Logikbox Real Estate
 Plugin URI: https://www.logikbox.com/
 Description: Logikbox Real EstatePlugin
 Author: Mike McAllister
 Version: 1.0.
 Author URI: https://www.logikbox.com
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/* House Post Type
================================================== */

function logikbox_house_plugin() {
	$labels = array( 
		'name'                	=> _x( 'Houses', 'Houses', 'lbx_house' ),
		'singular_name'       	=> _x( 'House', 'Hiuse', 'lbx_house' ),
		'menu_name'           	=> __( 'Houses', 'lbx_house' ),
		'parent_item_colon'   	=> __( 'Parent House:', 'lbx_house' ),
		'all_items'           	=> __( 'All Houses', 'lbx_house' ),
		'view_item'           	=> __( 'View House', 'lbx_house' ),
		'add_new_item'        	=> __( 'Add New House', 'lbx_house' ),
		'add_new'             	=> __( 'New House', 'lbx_house' ),
		'edit_item'           	=> __( 'Edit TeHouseam', 'lbx_house' ),
		'update_item'         	=> __( 'Update House', 'lbx_house' ),
		'search_items'        	=> __( 'Search House', 'lbx_house' ),
		'not_found'           	=> __( 'No article found', 'lbx_house' ),
		'not_found_in_trash'  	=> __( 'No article found in Trash', 'lbx_house' )
		);

	$args = array(  
		'labels'             	=> $labels,
		'public'             	=> true,
		'publicly_queryable' 	=> true,
		'show_in_menu'       	=> true,
		'show_in_admin_bar'   	=> true,
		'can_export'          	=> true,
		'has_archive'        	=> false,
		'hierarchical'       	=> false,
		'menu_position'      	=> null,
		'supports'           	=> array( 'title','editor','thumbnail')
	);

	register_post_type('lbx_house',$args);

}

add_action('init','logikbox_house_plugin');

?>