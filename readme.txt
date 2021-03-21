=== p5.js WP ===
Contributors: cass-e
Donate link: http://cass-e.net
Tags: p5js, embed, iframe, javascript
Requires at least: 4.0
Tested up to: 5.7
Requires PHP: 4.3
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Local hosting & embedding of p5.js scripts directly in posts & pages using iframes & shortcode
 
== Description ==

Local hosting & embedding of p5.js scripts directly in posts & pages using iframes & shortcode [p5jswp].

The shortcode [p5jswp] creates the following hierarchy:
```
<figure class="wp-block-image">
    <iframe class="p5jswp">
        <html>
            <head>
                <!-- optional libraries -->
                <!-- optional css -->
            </head>
            <body>
                <!-- script reference or script -->
            </body>
        </html>
    </iframe>
    <figcaption><!-- optional caption --></figcaption>
</figure>
```

Attributes include:
* **script**: hardcoded URL to a js file
* **js**: literal javascript instead of an external file\*
* **css**: literal css included inside iframe
* **width**: a width for the iframe. Remember to include units!
* **height**: a height for the iframe. Remember to include units!
* **caption**: Specify a caption inside the figure
* **libraries**: space delimited list of hardcoded URLs to libraries to be included in the iframe's `<head>`. The local copy of p5.min.js is automatically included.

\*I've had to encode the js with [htmlspecialchars()](https://www.php.net/manual/en/function.htmlspecialchars.php) to avoid messing with html attribute (quoted string) this is all being included inside of. This could mess with script output, especially if you're modifying DOM


== Installation ==
 
1. Upload `p5js-wp` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
 
== Frequently Asked Questions ==
 
= What are the differences between this and *the other version I may someday release* =
 
I think this version should have very widespread compatibility - I don't think I've used any features new to PHP 7 or Wordpress versions newer than 5.
 
== Screenshots ==
 
== Changelog ==
 
= 1.0 =
* Initial release. Moved to srcdoc attribute; added support for JS content saved in editor, css, etc.
 
= 0.5 =
* Original version: Passed all content into the iframe via GET request
 
== Upgrade Notice ==
 
= 1.0 =
Technically drops support for Internet Explorer. Oops.