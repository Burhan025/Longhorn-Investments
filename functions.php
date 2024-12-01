<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Subpage Header Code
//require_once('subpage-header.php');

//* Set Localization (do not remove)
load_child_theme_textdomain( 'parallax', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'parallax' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'parallax_customizer' );
function parallax_customizer(){
	require_once( get_stylesheet_directory() . '/lib/customize.php' );
}

//* Include Section Image CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

global $blogurl;
$blogurl = get_stylesheet_directory_uri();

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'parallax_enqueue_scripts_styles' );
function parallax_enqueue_scripts_styles() {
	// Styles
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/custom.css', array() );
	wp_enqueue_style( 'gravityforms', get_stylesheet_directory_uri() . '/css/formsmain.css', array('custom') );
	wp_enqueue_style( 'mediaqueries', get_stylesheet_directory_uri() . '/css/mediaqueries.css', array() );
	wp_enqueue_style( 'fontawesome', get_stylesheet_directory_uri() . '/fonts/css/font-awesome.min.css', array() );
	wp_enqueue_style( 'googlefonts', '//fonts.googleapis.com/css?family=Oswald:400,700|PT+Sans:400,700', array() );
	wp_enqueue_style( 'googlefonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,400i,700|Montserrat:300,400,600,700', array() );	

	// Scripts
	wp_enqueue_script( 'responsive-menu-js', get_stylesheet_directory_uri() . '/js/responsive-menu/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'waypoint', get_stylesheet_directory_uri() . '/js/counter/waypoints.min.js', array() );
	wp_enqueue_script( 'counterup', get_stylesheet_directory_uri() . '/js/counter/jquery.counterup.min.js', array() );
	wp_enqueue_script( 'onscreen', get_stylesheet_directory_uri() . '/js/counter/jquery.onscreen.min.js', array() );
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array() );
	wp_enqueue_script( 'fancyBox-js', get_bloginfo( 'stylesheet_directory' ) . '/js/fancy/jquery.fancybox.js', array( 'jquery' ), '1.0.0', true );

	// Examples & Optionals:
	//wp_enqueue_script( 'owlcarousel', get_stylesheet_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', array('jquery') );
	//wp_enqueue_style( 'ptsans', 'https://fonts.googleapis.com/css?family=PT+Sans:400,700', array() );
	//wp_enqueue_style( 'ptsans-caption', 'https://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700', array() );
	//wp_enqueue_style( 'owlcarouselcss', get_stylesheet_directory_uri() . '/js/owl-carousel/owl.carousel.css', array() );
	//wp_enqueue_style( 'fancyBoxcss', get_stylesheet_directory_uri() . '/js/fancy/jquery.fancybox.css', array() );
	
}

// Removes Query Strings from scripts and styles
function remove_script_version( $src ){
  if ( strpos( $src, 'uploads/bb-plugin' ) !== false || strpos( $src, 'uploads/bb-theme' ) !== false ) {
    return $src;
  }
  else {
    $parts = explode( '?ver', $src );
    return $parts[0];
  }
}
add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Reposition the primary navigation menu
//remove_action( 'genesis_after_header', 'genesis_do_nav' );
//add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Add Search to Primary Nav
//add_filter( 'genesis_header', 'genesis_search_primary_nav_menu', 10 );
function genesis_search_primary_nav_menu( $menu ){
    locate_template( array( 'searchform-header.php' ), true );
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'breadcrumb',
	'footer-widgets',
	'footer',
) );

// Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '...&nbsp;<a class="readmore" href="' . get_permalink() . '">Read&nbsp;More &raquo;</a>';
}

// Add Beaver Builder Editable Footers to the Genesis Footer hook
add_action( 'genesis_before_footer', 'global_footer', 4 );
function global_footer(){
	echo do_shortcode('[fl_builder_insert_layout slug="global-footer"]');
}

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] [post_comments] [post_edit]';
	return $post_info;
}

//* Custom Breadcrumb Hook 
function breadcrumb_hook() {
	do_action('breadcrumb_hook');
}

//* Remove breadcrumbs and reposition them
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'breadcrumb_hook', 'genesis_do_breadcrumbs', 12 );

// Modify Breadcrumbs Args
add_filter( 'genesis_breadcrumb_args', 'malcolm_breadcrumb_args' );
function malcolm_breadcrumb_args( $args ) {
	$args['prefix'] = '<div class="breadcrumbs"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['sep'] = ' <span class="bread-sep">></span> ';
	$args['heirarchial_attachments'] = true;
	$args['heirarchial_categories'] = true;
	$args['display'] = true;
	$args['labels']['prefix'] = '';
    return $args;
}

// Widget - Latest News on home page
genesis_register_sidebar( array(
	'id'			=> 'home-latest-news',
	'name'			=> __( 'Latest News on Home Page', 'thrive' ),
	'description'	=> __( 'This is latest news home page widget', 'thrive' ),
) );

// Blog Widgets
genesis_register_sidebar( array(
	'id'			=> 'blog-sidebar',
	'name'			=> __( 'Blog Widgets', 'thrive' ),
	'description'	=> __( 'This is latest news widget', 'thrive' ),
) );

// Add Header Links Widget to Header
//add_action( 'genesis_before', 'header_widget', 1 );
	function header_widget() {
	if (is_active_sidebar( 'header-links' ) ) {
 	genesis_widget_area( 'header-links', array(
		'before' => '<div class="header-links">',
		'after'  => '</div>',
	) );
}}

// Unregister unused sidebar
//unregister_sidebar( 'header-right' );

// Previous / Next Post Navigation Filter For Genesis Pagination
add_filter( 'genesis_prev_link_text', 'gt_review_prev_link_text' );
function gt_review_prev_link_text() {
        $prevlink = '&laquo;';
        return $prevlink;
}
add_filter( 'genesis_next_link_text', 'gt_review_next_link_text' );
function gt_review_next_link_text() {
        $nextlink = '&raquo;';
        return $nextlink;
}

/* Changing the Copyright text */
function genesischild_footer_creds_text () {
	global $blogurl;
 	echo '<div class="clearboth copy-line">
 			<div class="copyright first">
 				<p><span id="copy">&copy; '. date("Y") .' Longhorn Investments</span> <span class="format-pipe"> - </span>  
	 			 <a href="/privacy-policy/">Privacy Policy</a> <span class="format-pipe"> - </span> <a href="/terms-and-conditions/">Terms and Conditions</a> <span class="format-pipe"> - </span> <a href="/sitemap/">Site Map</a></p>
 			</div>
 			<div class="credits">
 				<span>Site by</span>
 				<a target="_blank" href="https://thriveagency.com/">
 					<img class="svg" src="'.  $blogurl . '/images/thrive-logo.png" alt="Web Design by Thrive Internet Marketing">
 				</a>
 			</div>
 		  </div>';
}
add_filter( 'genesis_footer_creds_text', 'genesischild_footer_creds_text' );


//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'genesis_do_nav', 12 );

// Add Additional Image Sizes
add_image_size( 'genesis-post-thumbnail', 163, 108, true );
add_image_size( 'subpage-header', 1600, 162, true );
add_image_size( 'news-thumb', 369, 191, true );
add_image_size( 'news-full', 800, 300, false );
add_image_size( 'sidebar-thumb', 200, 150, false );
add_image_size( 'blog-featured-image', 228, 176, true );


// Gravity Forms confirmation anchor on all forms
add_filter( 'gform_confirmation_anchor', '__return_true' );


// Button Shortcode
// Usage: [button url="https://www.google.com"] Button Shortcode [/button]
function button_shortcode($atts, $content = null) {
  extract( shortcode_atts( array(
	  'url' => '#',
	  'target' => '_self',
	  'onclick' => '',

  ), $atts ) 
);
return '<a target="' . $target . '" href="' . $url . '" class="button" onClick="' . $onclick . '"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('button', 'button_shortcode');

// Link Shortcode
// Usage: [link url=”tel:1-817-447-9194″ onClick=”onClick=”ga(‘send’, ‘event’, { eventCategory: ‘Click to Call’, eventAction: ‘Clicked Phone Number’, eventLabel: ‘Header Number’});”]
function link_shortcode($atts, $content = null) {
  extract( shortcode_atts( array(
	  'url' => '#',
	  'target' => '_self',
	  'onclick' => '',
  ), $atts ) 
);
return '<a target="' . $target . '" href="' . $url . '" onClick="' . $onclick . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('link', 'link_shortcode');

//* Declare WooCommerce support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

// Advance Custom field for Scheme Markups will be output under wphead tag
add_action('wp_head', 'add_scripts_to_wphead');
function add_scripts_to_wphead() {
	if( get_field('custom_javascript') ):	
		echo get_field('custom_javascript', 5);
	endif;
}

// Run shortcodes in Text Widgets
add_filter('widget_text', 'do_shortcode');


//Removing unused Default Wordpress Emoji Script - Performance Enhancer
function disable_emoji_dequeue_script() {
    wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Removes Emoji Scripts 
add_action('init', 'remheadlink');
function remheadlink() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_header', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}



//* Add custom Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'thrive_dns_prefetching' );
function thrive_dns_prefetching() {
	// Set Homepage Domains to Prefetch/Preconnect
	if( class_exists('acf') && is_front_page() ) {
		// check for domains
		if( have_rows('homepage_dns_prefetching_preconnect', 5) ):
		 	// List all domains
		 	echo '<meta http-equiv="x-dns-prefetch-control" content="on">';
		    while ( have_rows('homepage_dns_prefetching_preconnect', 5) ) : the_row();
				echo '<link rel="dns-prefetch" href="//' . get_sub_field('add_domain') . '">';
				echo '<link rel="preconnect" href="/' . get_sub_field('add_domain') . '">';
		    endwhile;
		endif;
	}
	elseif( class_exists('acf') && (is_single() || is_home() || is_page()) ) {
		// check for domains
		if( have_rows('subpage_dns_prefetching_preconnect', 5) ):
		 	// List all domains
		 	echo '<meta http-equiv="x-dns-prefetch-control" content="on">';
		    while ( have_rows('subpage_dns_prefetching_preconnect', 5) ) : the_row();
				echo '<link rel="dns-prefetch" href="//' . get_sub_field('add_domain') . '">';
				echo '<link rel="preconnect" href="/' . get_sub_field('add_domain') . '">';
		    endwhile;
		endif;
	}
	else {
		// If all else fails do nothing
	}	
}

// Add "nav-primary" class to Main Menu as this gets removed when we reposition the menu inside header/widget area
add_filter( 'genesis_attr_nav-header', 'thrive_custom_nav_id' );
function thrive_custom_nav_id( $attributes ) {
 	$attributes['class'] = 'nav-primary';
 	return $attributes;
}



//****** AMP Customizations ******/

//* Enqueue "stylesheet" for AMP */
add_action('amp_init','amp_css', 11);
function amp_css() { 
	require_once('css/amp.php');
}

//* Add Featured Images to AMP content
add_action( 'pre_amp_render_post', 'amp_add_custom_actions' );
function amp_add_custom_actions() {
    add_filter( 'the_content', 'amp_add_featured_image' );
}

function amp_add_featured_image( $content ) {
    if ( has_post_thumbnail() ) {
        // Just add the raw <img /> tag; our sanitizer will take care of it later.
        $image = sprintf( '<p class="featured-image">%s</p>', get_the_post_thumbnail($size = 'news-full') );
        $content = $image . $content;
    }
    return $content;
}

// Add Fav Icon to AMP Pages
add_action('amp_post_template_head','amp_favicon');
function amp_favicon() { ?>
	<link rel="icon" href="<?php echo get_site_icon_url(); ?>" />
<?php } 

// Add Banner below content of AMP Pages
add_action('ampforwp_after_post_content','amp_custom_banner_extension_insert_banner');
function amp_custom_banner_extension_insert_banner() { ?>
	<div class="amp-custom-banner-after-post">
		<h2>CUSTOM AMP BANNER TEXT HERE IF NEEDED</h2>
		<a class="ampforwp-comment-button" href="/contact-us/">
			CONTACT US
		</a>
	</div>
<?php } 



