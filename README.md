# p5.js WP
Contributors: cass-e<br>
Donate link: http://cass-e.net<br>
Tags: p5js, embed, iframe, javascript<br>
Requires at least: 4.0<br>
Tested up to: 5.7<br>
Requires PHP: 4.3<br>
Stable tag: 1.0<br>
License: GPLv2 or later<br>
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Local hosting & embedding of p5.js scripts directly in posts & pages using iframes & shortcode
 
## Description

Local hosting & embedding of p5.js scripts directly in posts & pages using iframes & shortcode [p5jswp].

### Usage

This plugin adds a **shortcode**, not a Gutenberg Block. For a detailed explanation of shortcodes, please see the [Wordpress Codex Page](https://codex.wordpress.org/Shortcode). For the usage of this shortcode, please see the usage examples below.

#### Usage Examples: Individual Attributes

* Using a JavaScript file: `[p5jswp script="<URL TO JavaScript FILE>"]`
* Using inline JavaScript: `[p5jswp js="console.log(&quot;HELLO WORLD&quot;);"]` \*
* Using additional libraries: `[p5jswp libraries="<URL> <URL> <URL>"]` Replace `<URL>`(s) with your URL(s). You can include one or more libraries by placing a space between multiple URLs. The URL can point to any online location - you can upload the library files to your site, or link to external files. The built-in p5.js library is always included.
* Using inline CSS: `[p5jswp css="html { text-align: center; }` \*
* Using a caption: `[p5jswp caption="Hello World"]` The caption can even include HTML if that html/any quotes inside it are properly escaped.

All of these parameters can be used together.

#### Usage Example: Complete

* Using a javascript file located at https://javascript-file.js, a height of 512, a caption of "Hello World" 
<br>`[p5jswp script="https://javascript-file.js" height="512" caption="Hello World"]`

\*Note use of `&quot;` to prevent breaking the shortcode. Using a literal " inside the attribute like `js` would end it prematurely, like how a javascript string that looked like `' it's '` would end prematurely.**

List of all possible attributes:
* **script**: hardcoded URL to a js file
* **js**: literal javascript instead of an external file\*
* **css**: literal css included in a style header inside the iframe\*
* **width**: a width for the iframe. NB: This is in HTML, not CSS
* **height**: a height for the iframe. NB: This is in HTML, not CSS
* **caption**: Specify a caption inside the figure
* **libraries**: space delimited list of hardcoded URLs to libraries to be included in the iframe's `<head>`. The local copy of p5.min.js is automatically included.\*

\*I've had to encode everything literal inside the iframe with [htmlspecialchars()](https://www.php.net/manual/en/function.htmlspecialchars.php) to avoid messing with the html output. This could mess with script output, especially if you're modifying DOM.

### Explanation

The shortcode [p5jswp] creates the following hierarchy (\<!-- HTML Comments explain where the plugin puts components-->):
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

## Installation
 
1. Upload `p5js-wp` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
 
## Frequently Asked Questions
 
### I can't find it in the block editor

This plugin adds a **shortcode**, not a Gutenberg Block. For a detailed explanation of shortcodes, please see the [Wordpress Codex Page](https://codex.wordpress.org/Shortcode). For the usage of this shortcode, please see the description.

### What are the differences between this and other p5.js plugins?
 
This version should have very wide compatibility. It uses a shortcode, so it's not dependent on Gutenberg, and it should be compatible with old versions of both PHP and WordPress. The oldest versions supported are subject to change, but is a goal of the project.
 
## Screenshots
 
## Changelog
 
### 1.0
* Initial release. Moved to srcdoc attribute; added support for JS content saved in editor, css, etc.
 
### 0.5
* Original version: Passed all content into the iframe via GET request
 
## Upgrade Notice
 
### 1.0
Technically drops support for Internet Explorer. Oops.