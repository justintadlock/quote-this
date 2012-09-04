<?php
/**
 * Plugin Name: Quote This
 * Plugin URI: http://justintadlock.com/archives/2009/03/26/quote-this-wordpress-plugin
 * Description: A plugin for displaying quotes on your site with either the <code>quote_this()</code> function, <code>[quote-this]</code> shortcode, or <em>Quote This</em> widget.
 * Version: 0.2 Alpha
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * Quote This is a plugin for outputting random quotes from
 * various categories.  The quotes are housed within the plugin
 * so that there's no dependency on external services.  Basically,
 * it's just something I've always used on my blog, and I thought
 * it would be fun to to release.
 *
 * Developers can learn more about the WordPress shortcode API:
 * @link http://codex.wordpress.org/Shortcode_API
 *
 * @copyright 2009
 * @version 0.2.0
 * @author Justin Tadlock
 * @link http://justintadlock.com/archives/2009/03/26/quote-this-wordpress-plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package QuoteThis
 */

/**
 * Yes, we're localizing the plugin.  This partly makes sure non-English
 * users can use it too.  To translate into your language use the
 * en_EN.po file as as guide.  Poedit is a good tool to for translating.
 * @link http://poedit.net
 *
 * @since 0.1
 */
load_plugin_textdomain( 'quote_this' );

/**
 * Make sure we get the correct directory.
 * @since 0.1
 */
if ( !defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( !defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( !defined( 'WP_PLUGIN_URL' ) )
	define('WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( !defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

/**
 * Define constant paths to the plugin folder.
 * @since 0.1
 */
define( QUOTE_THIS, WP_PLUGIN_DIR . '/quote-this' );
define( QUOTE_THIS_URL, WP_PLUGIN_URL . '/quote-this' );

/**
 * Load the widgets at appropriate time.
 * @since 0.1
 */
add_action( 'plugins_loaded', 'quote_this_load_widgets' );

/**
 * Create Quote This shortcode.
 * @since 0.1
 */
add_shortcode( 'quote-this', 'quote_this_shortcode' );

/**
 * The workhorse of the Quote This plugin.  This function
 * loads the appropriate files, grabs the correct set of quotes,
 * and formats them for display on the site.  Both the widget
 * and shortcode tie into this function.
 *
 * Parameters as an array are preferred, but query-string
 * style parameters are accepted.
 *
 * @since 0.1
 * @param array|string $args
 * @return string
 */
function quote_this( $args = array() ) {

	/*
	* Set up the default arguments
	*/
	$defaults = array(
		//'order' => 'ASC',		// Add ability to order later
		'orderby' => 'rand',		// rand is currently the only value
		'format' => 'blockquote',	// blockquote, p, ul, ol
		//'number' => 1,		// Add ability to choose more than one later
		'separator' => '-',		// Separates the quote and author
		'type' => 'all',		// Type of quotes to show
		'echo' => true,		// Display quote or return it for use in a function
	);

	/*
	* Parse the defaults and the arguments
	*/
	$args = wp_parse_args( $args, $defaults );
	extract( $args );

	/*
	* Art quotes
	*/
	if ( $type == 'art' ) :
		require_once( QUOTE_THIS . '/art.php' );
		$quotes = quote_this_art();

	/*
	* Film quotes
	*/
	elseif ( $type == 'film' ) :
		require_once( QUOTE_THIS . '/film.php' );
		$quotes = quote_this_film();

	/*
	* Friendship quotes
	*/
	elseif ( $type == 'friendship' ) :
		require_once( QUOTE_THIS . '/friendship.php' );
		$quotes = quote_this_friendship();

	/*
	* Individual quotes
	*/
	elseif ( $type == 'individual' ) :
		require_once( QUOTE_THIS . '/individual.php' );
		$quotes = quote_this_individual();

	/*
	* Life quotes
	*/
	elseif ( $type == 'life' ) :
		require_once( QUOTE_THIS . '/life.php' );
		$quotes = quote_this_life();

	/*
	* Literature quotes
	*/
	elseif ( $type == 'literature' ) :
		require_once( QUOTE_THIS . '/literature.php' );
		$quotes = quote_this_literature();

	/*
	* If no particular type of quote is chosen, load them all.
	* Then merge each of the arrays into one.
	*/
	else :
		require_once( QUOTE_THIS . '/art.php' );
		require_once( QUOTE_THIS . '/film.php' );
		require_once( QUOTE_THIS . '/friendship.php' );
		require_once( QUOTE_THIS . '/individual.php' );
		require_once( QUOTE_THIS . '/life.php' );
		require_once( QUOTE_THIS . '/literature.php' );

		$art = quote_this_art();
		$film = quote_this_film();
		$friendship = quote_this_friendship();
		$individual = quote_this_individual();
		$life = quote_this_life();
		$literature = quote_this_literature();

		$quotes = array_merge( $art, $film, $friendship, $individual, $life, $literature );

	endif;

	/*
	* If the quote should be randomly chosen (default).
	*/
	if ( $orderby = 'rand' ) :
		srand( (double) microtime() * 1000000 );
		$randomquote = rand( 0, count( $quotes ) - 1 );
		$quote = $quotes[$randomquote];
		$the_quote = $quote[0];
		$the_author = $quote[1];

	/*
	* If not random, get the first quote.
	*/
	else :
		$the_quote = $quotes[0][0];
		$the_author = $quotes[0][1];

	endif;

	/*
	* Format the quote with a blockquote.
	*/
	if ( $format == 'blockquote' ) :
		$output = '<blockquote class="quote-this"><p>';
		$output .= '<span class="quote">' . $the_quote . '</span>';
		$output .= ' ' . $separator . ' ';
		$output .= '<cite class="quote-author">' . $the_author . '</cite>';
		$output .= '</p></blockquote>';

	/*
	* Format the quote with a paragraph.
	*/
	elseif ( $format == 'p' ) :
		$output = '<p class="quote-this">';
		$output .= '<span class="quote">' . $the_quote . '</span>';
		$output .= ' ' . $separator . ' ';
		$output .= '<cite class="quote-author">' . $the_author . '</cite>';
		$output .= '</p>';

	/*
	* Format an unordered list of quotes.
	* Not that useful now, but when $number can be set, it should be.
	*/
	elseif ( $format == 'ul' ) :
		$output = '<ul class="quote-this"><li>';
		$output .= '<span class="quote">' . $the_quote . '</span>';
		$output .= ' ' . $separator . ' ';
		$output .= '<cite class="quote-author">' . $the_author . '</cite>';
		$output .= '</li></ul>';

	/*
	* Format an ordered list of quotes.
	* Not that useful now, but when $number can be set, it should be.
	*/
	elseif ( $format == 'ol' ) :
		$output = '<ol class="quote-this"><li>';
		$output .= '<span class="quote">' . $the_quote . '</span>';
		$output .= ' ' . $separator . ' ';
		$output .= '<cite class="quote-author">' . $the_author . '</cite>';
		$output .= '</li></ol>';

	endif;

	/*
	* Echo or return the quote
	*/
	if ( $echo )
		echo $output;

	else
		return $output;
}

/**
 * Function for loading and registering the Quote This widget.
 *
 * @since 0.1
 */
function quote_this_load_widgets() {
	global $pagenow;

	$local_pages = array( 'widgets.php' ); // define pages we want the plugin to be activated on

	if ( is_admin() && in_array( $pagenow, $local_pages ) ) :
		require_once( QUOTE_THIS . '/widget.php' );
		quote_this_widget_register();

	elseif ( !is_admin() ) :
		require_once( QUOTE_THIS . '/widget.php' );
		quote_this_widget_register();

	endif;
}

/**
 * Shortcode for replicating the quote_this() function.
 * The attributes are the same as the function parameters.
 * Users should input [quote-this] into their posts.
 *
 * @since 0.1
 * @param array $attr Attributes attributed to the shortcode.
 * @return string
 */
function quote_this_shortcode( $attr ) {

	$attr['echo'] = false;

	return quote_this( $attr );
}

?>