<?php

if ( ! function_exists( 'joinup_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function joinup_child_theme_enqueue_scripts() {
		$main_style = 'joinup-main';
		
		wp_enqueue_style( 'joinup-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}
	
	add_action( 'wp_enqueue_scripts', 'joinup_child_theme_enqueue_scripts' );
}

// Custom Fucntions - Please do not Edit above this line

// Remove WordPress Version Number
function wpb_remove_version() {
    return '';
    }
add_filter('the_generator', 'wpb_remove_version');

//Add Featured Images to RSS Feeds
function rss_post_thumbnail($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
    $content = '<p>' . get_the_post_thumbnail($post->ID) .
    '</p>' . get_the_content();
    }
    return $content;
    }
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

//Remove Welcome Panel from WordPress Dashboard
remove_action('welcome_panel', 'wp_welcome_panel');

//Disable XML-RPC in WordPress
add_filter('xmlrpc_enabled', '__return_false');

// Sender Email
// Function to change email address
function wpb_sender_email( $original_email_address ) {
    return 'no-reply@boiwala.com.bd';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'বইওয়ালা - boiwala.com.bd | প্রথম অনলাইন বাংলা সাহিত্য আর্কাইভ ও পোর্টাল';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

//Remove Version Numbers
// Remove WP Version From Styles	
/*add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );
*/
// Function to remove version numbers
/*function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
*/

function _remove_script_version( $src ){
    $parts = explode( '?ver', $src );
    return $parts[0];
}

add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

//Remove Heartbeat
add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
wp_deregister_script('heartbeat');
}

/* Automatically set the image Title, Alt-Text, Caption & Description upon upload
--------------------------------------------------------------------------------------*/
add_action('add_attachment', 'my_set_image_meta_upon_image_upload');
function my_set_image_meta_upon_image_upload($post_ID)
{

    // Check if uploaded file is an image, else do nothing

    if (wp_attachment_is_image($post_ID)) {

        $my_image_title = get_post($post_ID)->post_title;

        // Sanitize the title:  remove hyphens, underscores & extra spaces:
        $my_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $my_image_title);

        // Sanitize the title:  capitalize first letter of every word (other letters lower case):
        $my_image_title = ucwords(strtolower($my_image_title));

        // Create an array with the image meta (Title, Caption, Description) to be updated
        // Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
        $my_image_meta = array(
            'ID' => $post_ID,            // Specify the image (ID) to be updated
            'post_title' => $my_image_title,        // Set image Title to sanitized title
            'post_excerpt' => $my_image_title,        // Set image Caption (Excerpt) to sanitized title
            'post_content' => $my_image_title,        // Set image Description (Content) to sanitized title
        );

        // Set the image Alt-Text
        update_post_meta($post_ID, '_wp_attachment_image_alt', $my_image_title);

        // Set the image meta (e.g. Title, Excerpt, Content)
        wp_update_post($my_image_meta);

    }
}

// Ping Error 
add_filter('xmlrpc_methods', function($methods) {
  unset($methods['pingback.ping']); 
  return $methods; 
});

// Enable featured images for taxonomy terms (e.g., categories and tags)
function enable_taxonomy_term_featured_image() {
    register_taxonomy_for_object_type('category', 'term');
    add_post_type_support('term', 'thumbnail');
}
add_action('init', 'enable_taxonomy_term_featured_image');



