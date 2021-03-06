<?php
/**
 * @package theatrehistory
 * 
 * @wordpress-plugin
 * Plugin Name: Theatre Manager
 * Description: A plugin to manage theatrical productions, storing information about who is involved. Can also be used as an archive
 * Version: 1.1.2
 * Requires at least: 5.4
 * Requires PHP: 7.2
 * Author: John Cherry
 * Author URI: https://johncherry.me
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * text domain: theatre-manager
 */

// If called directly, abort
if ( ! defined( 'ABSPATH' )) die;


//fetch relevant pages
require_once( dirname( __FILE__ ) . '/tm-includes/theatre-manager-person-type.php');
require_once( dirname( __FILE__ ) . '/tm-includes/theatre-manager-committee-type.php');
require_once( dirname( __FILE__ ) . '/tm-includes/theatre-manager-committee-role-type.php');
require_once( dirname( __FILE__ ) . '/tm-includes/theatre-manager-show-type.php');
require_once( dirname( __FILE__ ) . '/tm-admin/theatre-manager-options.php' );

//------------------------------------------------------------------------------------------
/**
 * Main Plugin functions
 * @since 0.1
 */

//activate plugin
function tm_activate(){
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'tm_activate');

//deactivate plugin
function tm_deactivate() {
    // Unregister the post type, so the rules are no longer in memory.
    unregister_post_type( 'theatre_show' );
    unregister_post_type( 'theatre_member' );
    unregister_post_type( 'theatre_committee' );
    unregister_post_type( 'theatre_committee_role' );
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tm_deactivate' );

//------------------------------------------------------------------------------------------
/**
 * Add shortcodes to shows, people and committees 
 * Not the best way to do this but guarantees content with every theme
 * @since 0.7
 */
function tm_shortcodes_on_posts( $content ): string
{
    global $post;
    if( ! $post instanceof WP_Post ) return $content;
  
    switch( $post->post_type ) {
        case 'theatre_show':
            return $content . '[show_data]';
        case 'theatre_person':
            return $content . '[person_data]';
        case 'theatre_committee':
            return $content . '[committee_data]';
        case 'theatre_role':
            return $content . '[role_data]';
        default:
              return $content;
    }
}
add_filter( 'the_content', 'tm_shortcodes_on_posts' );


//------------------------------------------------------------------------------------------
/**
 * Utility Functions
 */
/**
 * tm_id_lookup - get id from name
 * @param $name string name of post
 * @param $type string post type
 * @return false|integer
 * @since 0.6
 */
function tm_id_lookup($name, $type){
    $query = new WP_Query( 'post_type=' . $type );
    while ( $query->have_posts() ) {
        $query->the_post();
        $title = get_the_title();
        if($title == $name){
            return get_the_ID();
        }
    }
    return false;
}

/**
 * @since 0.8.4
 * @return array containing all persons in form post_id => post_name
 */
function tm_get_names_array(): array
{
	$names = array();
	global $wpdb;
	$query = 'SELECT ID,post_title FROM ' . $wpdb->posts . '
        WHERE post_type = \'theatre_person\'
        AND post_status = \'publish\'
        ORDER BY post_title ASC';
	$rows = $wpdb->get_results($query);
	foreach ($rows as $row) {
		$post_title = $row->post_title;
		$id = $row->ID;
		$names[$id] = $post_title;
	}
	return $names;
}

/**
 * @since 0.9
 * @return array containing all persons in form post_id => post_name
 */
function tm_get_roles_array(): array
{
	$names = array();
	global $wpdb;
	$query = 'SELECT ID,post_title FROM ' . $wpdb->posts . '
        WHERE post_type = \'theatre_role\'
        AND post_status = \'publish\'
        ORDER BY post_title ASC';
	$rows = $wpdb->get_results($query);
	foreach ($rows as $row) {
		$post_title = $row->post_title;
		$id = $row->ID;
		$names[$id] = $post_title;
	}
	return $names;
}
