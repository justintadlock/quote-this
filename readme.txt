=== Quote This ===
Contributors: greenshady
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3687060
Tags: widget, shortcode, plugin, post, page, quote, quotes, random
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: 0.1

Allows the user to call random quotes with the quote_this() function, [quote-this] shortcode, or Quote This widget.

== Description ==

*Quote This* is yet another quote plugin.  It has been a script I've used on my personal blog for a few years that I figured I'd share with the rest of the WordPress community.

Basically, it lets you show quotations on your blog in one of three ways:

* `quote_this()` template tag for your theme template files.
* `[quote-this]` shortcode for adding it to your posts and pages.
* <em>Quote This</em> widget for use in widget areas.

== Installation ==

1. Uzip the `quote-this.zip` folder.
1. Upload the `quote-this` folder to your `/wp-content/plugins` directory.
1. In your WordPress dashboard, head over to the *Plugins* section.
1. Activate *Quote This*.

More detailed instructions are included in the plugin's `readme.html` file.

== Frequently Asked Questions ==

= Why was this plugin created? =

It was just an old script I've had lying around, gathering dust.  I've been using it on my personal blog for years, so I figured someone might make some use of it.

= How do I call the function in my theme templates? =

`
<?php if ( function_exists( 'quote_this' ) ) quote_this(); ?>
`

= How do I use the shortcode in my posts? =

`
[quote-this]
`

= How do I use the widget? =

Head over to the *Widgets* section in your WordPress admin and click the "Add" button for the *Quote This* widget.  Once added, you can select how you want to display the quotes.

= What are the parameters? =

**type**

* Which type of quotes to show.
* Possible values: `all` (default), `art`, `film`, `friendship`, `individual`, `life`, `literature`

**orderby**

* How to order the quote(s) shown.
* Possible values: `rand` (more options will be added in the future)

**format**

* What XHTML element should wrap the quotation.
* Possible values: `blockquote` (default), `p`

**separator**

* What should be added between the quote and quote author.
* Possible values: Anything (default is `-`)

**echo**

* Whether the quotation should be printed to the screen or returned for use in a function (is not used for the `[quote-this]` shortcode.)
* Possible values: `true` (default), `false`

= Can I get more detailed instructions? =

If you need a more detailed guide, see `readme.html`, which is included with the plugin.  It has a few examples and explains everything.

== Screenshots ==

Screenshots are not really needed, but you can see this plugin in action on the <a href="http://justintadlock.com/writing" title="Justin Tadlock's Writing">Writing page</a> of my personal blog.

== Changelog ==

**Version 0.1**

* Plugin released.