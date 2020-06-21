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
		'singular_name'       	=> _x( 'House', 'House', 'lbx_house' ),
		'menu_name'           	=> __( 'Houses', 'lbx_house' ),
		'parent_item_colon'   	=> __( 'Parent House:', 'lbx_house' ),
		'all_items'           	=> __( 'All Houses', 'lbx_house' ),
		'view_item'           	=> __( 'View House', 'lbx_house' ),
		'add_new_item'        	=> __( 'Add New House', 'lbx_house' ),
		'add_new'             	=> __( 'New House', 'lbx_house' ),
		'edit_item'           	=> __( 'Edit House', 'lbx_house' ),
		'update_item'         	=> __( 'Update House', 'lbx_house' ),
		'search_items'        	=> __( 'Search House', 'lbx_house' ),
		'not_found'           	=> __( 'No article found', 'lbx_house' ),
		'not_found_in_trash'  	=> __( 'No article found in Trash', 'lbx_house' )
		);

	$args = array(  
        'label'                 => __( 'movies', 'lbx_house' ),
        'description'           => __( 'Movie news and reviews', 'lbx_house' ),
        'labels'             	=> $labels,
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'            => array( 'genres' ),
		'public'             	=> true,
		'publicly_queryable' 	=> true,
        'show_in_menu'       	=> true,
        'show_in_rest'          => false,
		'show_in_admin_bar'   	=> true,
		'can_export'          	=> true,
		'has_archive'        	=> false,
		'hierarchical'       	=> false,
		'menu_position'      	=> null,
		'supports'            => array( 'title', 'editor',  'thumbnail',  )
	);

	register_post_type('lbx_house',$args);

}

add_action('init','logikbox_house_plugin');

/* update message
================================================== */

function lbx_update_message_house( $messages )
{
	global $post, $post_ID;

	$message['lbx_house'] = array(
		0 => '',
		1 => sprintf( __('House updated. <a href="%s">View House</a>', 'lbx_house' ), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'lbx_house' ),
		3 => __('Custom field deleted.', 'lbx_house' ),
		4 => __('House updated.', 'lbx_house' ),
		5 => isset($_GET['revision']) ? sprintf( __('House restored to revision from %s', 'lbx_house' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Team published. <a href="%s">View House</a>', 'lbx_house' ), esc_url( get_permalink($post_ID) ) ),
		7 => __('Team saved.', 'lbx_house' ),
		8 => sprintf( __('House submitted. <a target="_blank" href="%s">Preview Team</a>', 'lbx_house' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('House scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Team</a>', 'lbx_house' ), date_i18n( __( 'M j, Y @ G:i','lbx_house'), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('House draft updated. <a target="_blank" href="%s">Preview Team</a>', 'lbx_house' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
	return $message;
}

add_filter( 'post_updated_messages', 'lbx_update_message_house' );


function add_post_meta_boxes() {
    // see https://developer.wordpress.org/reference/functions/add_meta_box for a full explanation of each property
    add_meta_box(
        "post_metadata_house_details", // div id containing rendered fields
        "House Details", // section heading displayed as text
        "post_meta_box_house_details", // callback function to render fields
        "lbx_house", // name of post type on which to render fields
        "normal", // location on the screen
        "low" // placement priority
    );
}
add_action( "admin_init", "add_post_meta_boxes" );


function save_post_meta_boxes(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
    update_post_meta( $post->ID, "_post_house_details", sanitize_text_field( $_POST[ "_post_house_details" ] ) );
    update_post_meta( $post->ID, "_post_advertising_html", sanitize_text_field( $_POST[ "_post_advertising_html" ] ) );
}
add_action( 'save_post', 'save_post_meta_boxes' );


//Add custome fileds
function post_meta_box_house_details(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $advertisingCategory = $custom[ "_post_house_details" ][ 0 ];
    $advertisingHtml = $custom[ "_post_advertising_html" ][ 0 ];

    // wp_editor(
    //     htmlspecialchars_decode( $advertisingHtml ),
    //     '_post_advertising_html',
    //     $settings = array(
    //         'textarea_name' => '_post_advertising_html',
    //     )
    // );

    
    echo "<label>test label</label><input name=\"_post_advertising_html\" value=\" $advertisingHtml \" />";
    echo "<br>";
    switch ( $advertisingCategory ) {
        case 'internal':
            $internalSelected = "selected";
            break;
        case 'external':
            $externalSelected = "selected";
            break;
        case 'mixed':
            $mixedSelected = "selected";
            break;
    }
    echo "<select name=\"_post_house_details\">";
    echo "    <option value=\"internal\" $internalSelected>Internal</option>";
    echo "    <option value=\"external\" $externalSelected>External</option>";
    echo "    <option value=\"mixed\" $mixedSelected>Mixed</option>";
    echo "</select>";
}




?>