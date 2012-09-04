<?php

/**
 * The workhorse of the Quote This plugin.  This function loads the appropriate files, grabs the correct 
 * set of quotes, and formats them for display on the site.  Both the widget and shortcode tie into this 
 * function.
 *
 * @since 0.1.0
 * @param array $args
 * @return string
 */
function quote_this( $args = array() ) {

	$output = '';

	/* Set up the default arguments. */
	$defaults = array(
		'orderby' => 'rand',		// rand is currently the only value
		'type' => 'all',		// Type of quotes to show
		'echo' => true,		// Display quote or return it for use in a function
	);

	/* Parse the defaults and the arguments. */
	$args = wp_parse_args( $args, $defaults );

	/* Get the quote based on the 'type'. */

	if ( 'art' == $args['type'] )
		$quotes = quote_this_art();

	elseif ( 'film' == $args['type'] )
		$quotes = quote_this_film();

	elseif ( 'friendship' == $args['type'] )
		$quotes = quote_this_friendship();

	elseif ( 'individual' == $args['type'] )
		$quotes = quote_this_individual();

	elseif ( 'life' == $args['type'] )
		$quotes = quote_this_life();

	elseif ( 'literature' == $args['type'] )
		$quotes = quote_this_literature();

	else
		$quotes = array_merge( quote_this_art(), quote_this_film(), quote_this_friendship(), quote_this_individual(), quote_this_life(), quote_this_literature() );


	if ( 'rand' == $args['orderby'] ) {
		srand( (double) microtime() * 1000000 );
		$randomquote = rand( 0, count( $quotes ) - 1 );
		$quote = $quotes[$randomquote];
		$the_quote = $quote[0];
		$the_author = $quote[1];

	} else {
		$the_quote = $quotes[0][0];
		$the_author = $quotes[0][1];
	}

	if ( !empty( $the_quote ) ) {

		$output = '<blockquote class="quote-this">';
		$output .= '<p>' . $the_quote . '</p>';
		$output .= '<p><cite class="quote-this-author quote-author">' . $the_author . '</cite></p>';
		$output .= '</blockquote>';
	}

	if ( false === $args['echo'] )
		return $output;

	echo $output;
}

/**
 * Shortcode for replicating the quote_this() function.  The attributes are the same as the 
 * function parameters.  Users should input [quote-this] into their posts.
 *
 * @since 0.1.0
 * @param array $attr Attributes attributed to the shortcode.
 * @return string
 */
function quote_this_shortcode( $attr ) {

	$attr['echo'] = false;

	return quote_this( $attr );
}

?>