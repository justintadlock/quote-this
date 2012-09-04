<?php
/**
 * Plugin Name: Quote This
 * Plugin URI: http://justintadlock.com/archives/2009/03/26/quote-this-wordpress-plugin
 * Description: A plugin for displaying quotes on your site with either the <code>quote_this()</code> function, <code>[quote-this]</code> shortcode, or <em>Quote This</em> widget.
 * Version: 0.2 Alpha
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * Quote This is a plugin for outputting random quotes from various categories.  The quotes are 
 * housed within the plugin so that there's no dependency on external services.  Basically, it's just 
 * something I've always used on my blog, and I thought it would be fun to to release.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package QuoteThis
 * @version 0.2.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2009 - 2012, Justin Tadlock
 * @link http://justintadlock.com/archives/2009/03/26/quote-this-wordpress-plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Class to launch the plugin.  Just a simple wrapper to clean things up nicely.  I've set it to 'final' for 
 * the moment because I have plans for major changes and don't want to mess up anyone's classes 
 * if they try to extend it.
 *
 * @since 0.2.0
 */
final class Quote_This {

	/**
	 * Constructor method.  Sets up needed actions/filters for the plugin.
	 *
	 * @since 0.2.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );

		/* Load and register widgets. */
		add_action( 'widgets_init', array( &$this, 'register_widgets' ) );

		/* Register shortcodes. */
		add_action( 'init', array( &$this, 'register_shortcodes' ) );
	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 0.2.0
	 * @access public
	 * @return void
	 */
	public function constants() {

		/* Set constant path to the members plugin directory. */
		define( 'QUOTE_THIS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	/**
	 * Loads the translation files.
	 *
	 * @since 0.2.0
	 * @access public
	 * @return void
	 */
	public function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'quote-this', false, 'quote-this/languages' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 0.2.0
	 * @access public
	 * @return void
	 */
	public function includes() {
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/functions.php' );
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/quotes-art.php' );
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/quotes-film.php' );
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/quotes-friendship.php' );
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/quotes-individual.php' );
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/quotes-life.php' );
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/quotes-literature.php' );
	}

	/**
	 * Loads and registers widgets.
	 *
	 * @since 0.2.0
	 * @access public
	 * @return void
	 */
	public function register_widgets() {
		require_once( trailingslashit( QUOTE_THIS_DIR ) . 'includes/widget-quote-this.php' );
		register_widget( 'Quote_This_Widget' );
	}

	/**
	 * Registers shortcodes.
	 *
	 * @since 0.2.0
	 * @access public
	 * @return void
	 */
	public function register_shortcodes() {
		add_shortcode( 'quote-this', 'quote_this_shortcode' );
	}
}

new Quote_This();

?>