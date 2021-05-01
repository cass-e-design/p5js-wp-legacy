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

p5.js scripts can be tricky to embed safely alongside other content, especially when using plugins that aggregate or defer scripts. This plugin enables inclusion of p5.js scripts more easily, directly inside WordPress content using a shortcode. It encapsulates scripts inside an \<iframe\>, so one post or page can safely handle multiple p5.js sketches using conflicting libraries, versions, etc.

= Usage =

This plugin adds a **shortcode**, not a Gutenberg Block. For a detailed explanation of shortcodes, please see the [Wordpress Codex Page on Shortcodes](https://codex.wordpress.org/Shortcode). For the usage of this shortcode, please see the usage examples below.

Additional Note: I use <URL\> to indicate where a URL needs to go. You should replace the whole thing, including the <> brackets.

= Special Characters =
**All HTML Entities inside the shortcode need to be encoded.** Like '&amp;' (`&amp;`). If you want things to stay HTML Entities after decoding, those need to be encoded *twice*. (`&amp;amp;`). If you don't encode something, WordPress will encode it, and then unencode all the quotes.
[Mathias Bynen's HTML Entity Encoder/Decoder](https://mothereff.in/html-entities) (Not affiliated) may help. Check 'allow named character references.'

= Inline JavaScript with the `js` attribute: =
You can embed javascript directly in the shortcode instead of linking to an external file with the `js` attribute. This is a bit hacky. **Make sure all special characters are encoded (see Special Characters).**

*If you're having trouble with inline JavaScript, I recommend putting your javascript in a file and linking to it using the `script` attribute.*

= Usage Examples: Individual Attributes =

* Using a JavaScript file: `[p5jswp script="<URL>"]` Replace `<URL>` with the URL to your JavaScript file. Example: [jQuery](https://code.jquery.com/jquery-3.6.0.js)
* Using inline JavaScript: `[p5jswp js="console.log(&quot;HELLO WORLD&quot;);"]` This example should print "HELLO WORLD" in your browser console. Replace everything inside js="" with your own JavaScript.\*
* Using additional libraries: `[p5jswp libraries="<URL>"]` (or `[p5jswp libraries="<URL> <URL>"]` etc.) Replace `<URL>`(s) with your URL(s). You can include more than one library by separating multiple URLs with a space. The URL can point to any online location. You can upload the library files to your site, or link to external files. The built-in p5.js library is always included.
* Using inline CSS: `[p5jswp css="html { text-align: center; }` Replace everything inside css="" with your own CSS.\*
* Using a caption: `[p5jswp caption="Hello World"]` The caption can even include HTML if that html/any quotes inside it are properly escaped.

All of these parameters can be used together.<br>
\*Note use of \&quot; to prevent breaking the shortcode. Using a literal " inside the attribute would end it prematurely, like how a javascript string that looked like `' it's '` would end prematurely.**

= Usage Examples: Complete =

* Using a javascript file located at https://javascript-file.js, a height of 512, a caption of "Hello World" 
<br>`[p5jswp script="https://javascript-file.js" height="512" caption="Hello World"]`

List of all possible attributes:
* **script**: URL to a JavaScript file for inclusion in the body.
* **js**: Inline Javascript for inclusion in the body.
* **css**: Inline CSS included inside the iframe's head
* **width**: Width for the iframe. NB: This is in HTML, not CSS
* **height**: Height for the iframe. NB: This is in HTML, not CSS
* **caption**: Caption to be included in a \<figcaption>
* **libraries**: Space delimited list of URLs for libraries/additional scripts to be included in the iframe. The local copy of p5.min.js is automatically included.
* **debug**: Debug parameter per shortcode (use debug="true" to enable) that prints all attribute values inside the caption. Not intended for production.

All parameters are optional, but the Shortcode will produce a warning if both the `script` and `js` are unused.

= Output =

The shortcode \[p5jswp\] creates the following HTML hierarchy on the frontend:<br>
\<!-- HTML Comments explain where the plugin puts things-->
```
<figure class="wp-block-image">
    <iframe class="p5jswp">
        <html>
            <head>
                <!-- optional libraries -->
                <style><!-- optional css --></style>
            </head>
            <body>
                <!-- script reference or script -->
            </body>
        </html>
    </iframe>
    <figcaption><!-- optional caption --></figcaption>
</figure>
```

== Installation ==
 
1. Upload `p5js-wp-legacy` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
 
== Frequently Asked Questions ==
 
= I can't find it in the block editor =

This plugin adds a **shortcode**, not a Gutenberg Block. For a detailed explanation of shortcodes, please see the [Wordpress Codex Page on Shortcodes](https://codex.wordpress.org/Shortcode). For the usage of this shortcode, please see the description.

= "This block contains unexpected or invalid content." =

You forgot to encode an [HTML Entity](https://www.tutorialspoint.com/html/html_entities.htm) (ie. &, <, >, ', etc.) This isn't the end of the world - hit Attempt Block Recovery. Wordpress will encode everything except quotes, which you'll need to re-encode to prevent breaking your shortcode. See Special Characters under Usage.

= What are the differences between this and other p5.js plugins? =
 
This version should have very wide compatibility. It uses a shortcode, so it's not dependent on Gutenberg, and it should be compatible with very old versions of both PHP and WordPress. The oldest versions supported are subject to change, but is a goal of the project.
 
== Screenshots ==

== Changelog ==

= 1.0 =
* Initial release. Moved to srcdoc attribute; added support for JS content saved in editor, css, etc.
 
= 0.5 =
* Original version: Passed all content into the iframe via GET request
 
== Upgrade Notice ==
 
= 1.0 =
Technically drops support for Internet Explorer. Oops.