<?php
/**
 * Widget for outputting quotes from the Quote This function
 *
 * @package QuoteThis
 */

/**
 * Quote this widget.  This function displays the widget
 * by grabbing the widget settings and calling up the 
 * quote_this() function.
 *
 * @since 0.1
 */
function quote_this_widget( $args, $widget_args = 1 ) {

	extract( $args, EXTR_SKIP );

	if ( is_numeric( $widget_args ) )
		$widget_args = array( 'number' => $widget_args );

	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );

	extract( $widget_args, EXTR_SKIP );

	$options = get_option( 'quote_this_widget' );

	if ( !isset( $options[$number] ) )
		return;

	$title = apply_filters( 'widget_title', $options[$number]['title'] );
	//$order = $options[$number]['order'];
	//$orderby = $options[$number]['orderby'];
	$type = $options[$number]['type'];
	$format = $options[$number]['format'];
	$separator = $options[$number]['separator'];

	$args = array(
		'type' => $type,
		'separator' => $separator,
		//'order' => $order,
		'orderby' => 'rand',
		'format' => $format,
		//'number' => $quote_number,
		'echo' => true,
	);

	echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		quote_this( $args );

	echo $after_widget;
}

/**
 * Quote This widget control panel.  This displays the form
 * for users to select their widget settings.
 *
 * @since 0.1
 */
function quote_this_widget_control( $widget_args ) {

	global $wp_registered_widgets;

	static $updated = false;

	if ( is_numeric( $widget_args ) )
		$widget_args = array( 'number' => $widget_args );

	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );

	extract( $widget_args, EXTR_SKIP );

	$options = get_option( 'quote_this_widget' );

	if ( !is_array( $options ) )
		$options = array();

	if ( !$updated && !empty( $_POST['sidebar'] ) ) :

		$sidebar = (string)$_POST['sidebar'];

		$sidebars_widgets = wp_get_sidebars_widgets();

		if ( isset( $sidebars_widgets[$sidebar] ) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();

		foreach ( $this_sidebar as $_widget_id ) :

			if ( 'quote_this_widget' == $wp_registered_widgets[$_widget_id]['callback'] && isset( $wp_registered_widgets[$_widget_id]['params'][0]['number'] ) ) :

				$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];

				unset( $options[$widget_number] );

			endif;

		endforeach;

		foreach ( (array)$_POST['widget-quote-this'] as $widget_number => $quote_this_widget ) :

			$title = strip_tags( stripslashes( $quote_this_widget['title'] ) );

			$format = strip_tags( stripslashes( $quote_this_widget['format'] ) );

			$separator = stripslashes( $quote_this_widget['separator'] );

			$type = strip_tags( stripslashes( $quote_this_widget['type'] ) );

			$options[$widget_number] = compact( 'title', 'type', 'format', 'separator' );

		endforeach;

		update_option( 'quote_this_widget', $options );

		$updated = true;

	endif;

	if ( $number == -1 ) :
		$title = '';
		$format = '';
		$separator = '';
		$type = '';
		$number = '%i%';
	else :
		$title = attribute_escape( $options[$number]['title'] );
		$format = attribute_escape( $options[$number]['format'] );
		$separator = attribute_escape( $options[$number]['separator'] );
		$type = attribute_escape( $options[$number]['type'] );
	endif;

?>

	<p>
		<label for="quote-this-title-<?php echo $number; ?>">
			<?php _e('Title:', 'quote_this'); ?>
		</label>
		<input id="quote-this-title-<?php echo $number; ?>" name="widget-quote-this[<?php echo $number; ?>][title]" type="text" value="<?php echo $title; ?>" style="width:100%;" />
	</p>
	<p>
		<label for="quote-this-type-<?php echo $number; ?>">
			<?php _e('Type:', 'quote_this'); ?>
		</label>

		<select id="quote-this-type-<?php echo $number; ?>" name="widget-quote-this[<?php echo $number; ?>][type]" style="width:100%;">
			<option <?php if ( 'all' == $type ) echo 'selected="selected"'; ?>>all</option>
			<option <?php if ( 'art' == $type ) echo 'selected="selected"'; ?>>art</option>
			<option <?php if ( 'film' == $type ) echo 'selected="selected"'; ?>>film</option>
			<option <?php if ( 'friendship' == $type ) echo 'selected="selected"'; ?>>friendship</option>
			<option <?php if ( 'individual' == $type ) echo 'selected="selected"'; ?>>individual</option>
			<option <?php if ( 'life' == $type ) echo 'selected="selected"'; ?>>life</option>
			<option <?php if ( 'literature' == $type ) echo 'selected="selected"'; ?>>literature</option>
		</select>
	</p>
	<p>
		<label for="quote-this-format-<?php echo $number; ?>">
			<?php _e('Format:', 'quote_this'); ?>
		</label>

		<select id="quote-this-format-<?php echo $number; ?>" name="widget-quote-this[<?php echo $number; ?>][format]" style="width:100%;">
			<option <?php if ( 'blockquote' == $format ) echo 'selected="selected"'; ?>>blockquote</option>
			<option <?php if ( 'p' == $format ) echo 'selected="selected"'; ?>>p</option>
		</select>
	</p>
	<p>
		<label for="quote-this-separator-<?php echo $number; ?>">
			<?php _e('Separator:', 'quote_this'); ?>
		</label>
		<input id="quote-this-separator-<?php echo $number; ?>" name="widget-quote-this[<?php echo $number; ?>][separator]" type="text" value="<?php echo $separator; ?>" style="width:100%;" />
	</p>

	<p style="clear:both;">
		<input type="hidden" id="quote-this-submit-<?php echo $number; ?>" name="quote-this-submit-<?php echo $number; ?>" value="1" />
	</p>
<?php
}

/**
* Register the authors widget
* Register the authors widget controls
*
* @since 0.1.1
*/
function quote_this_widget_register() {

	if ( !$options = get_option( 'quote_this_widget' ) )
		$options = array();

	$widget_ops = array(
		'classname' => 'quote-this',
		'description' => __('A widget that allows you to show a quote from the Quote This collection.', 'quote_this'),
	);

	$control_ops = array(
		'width' => 200,
		'height' => 350,
		'id_base' => 'quote-this',
	);

	$name = __('Quote This', 'quote_this');

	$id = false;

	foreach ( array_keys( $options ) as $o ) :

		if ( !isset( $options[$o]['title'] ) )
			continue;

		$id = 'quote-this-' . $o;

		wp_register_sidebar_widget( $id, $name, 'quote_this_widget', $widget_ops, array( 'number' => $o ) );

		wp_register_widget_control( $id, $name, 'quote_this_widget_control', $control_ops, array( 'number' => $o ) );

	endforeach;

	if ( !$id ) :

		wp_register_sidebar_widget( 'quote-this-1', $name, 'quote_this_widget', $widget_ops, array( 'number' => -1 ) );

		wp_register_widget_control( 'quote-this-1', $name, 'quote_this_widget_control', $control_ops, array( 'number' => -1 ) );

	endif;

}

?>