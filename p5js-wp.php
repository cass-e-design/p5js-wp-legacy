<?php
/*
Plugin Name: p5js wp
Plugin URI: https://github.com/cass-e-design/p5js-wp-legacy
Description: Local hosting & embedding of p5.js scripts directly in posts & pages using iframes & shortcode
Version: 1.0.0
Date: 21/03/2018
Author: Cassia Duske
Author URI: http://cass-e.net
License: GPL2

Core functionality

Copyright (C) 2021 Cassia Duske

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

*/

function p5jswp_styles() {
	wp_enqueue_style('pjswp-style', plugins_url('css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'p5jswp_styles');

function p5jswp_process_shortcode($attrs, $content) {

	$script_itself = '';
	if (isset($attrs['js'])) {
		$script_itself .= "<script>$attrs[js]</script>";
	}
	if (isset($attrs['script'])) {
		$script_itself .= "<script src=\"$attrs[script]\"></script>";
	} 
	if (empty($script_itself)) {
		$script_itself = '<p>' . __('p5jswp: WARNING: No `script` or `js` attributes specified', 'p5js-wp') . '</p>';
	}

	$css = '<link rel="stylesheet" href="'.plugins_url('/css/iframe-style.css', __FILE__).'"/>';
	if (isset($attrs['css'])) $css .= "<style>$attrs[css]</style>";
	
	$width = '';
	$height = '';
	$custom_size = '';
	if (isset($attrs['width'])) {
		$width = "width=\"$attrs[width]\"";
		$custom_size .= 'p5jswp-custom-width';
	} 
	if (isset($attrs['height'])) {
		$width = "height=\"$attrs[height]\"";
		$custom_size .= ' p5jswp-custom-height';
	}

	$libraries = '';
	if (isset($attrs['libraries']))
		foreach (explode(' ', $attrs['libraries']) as $library)
			$libraries .= "<script src=\"$library\"></script>";

	//default
	$libraries .= '<script src="'.plugins_url('/js/p5.min.js', __FILE__).'"></script>';
	
	//htmlspecialchars prevents contents of the scripts from interfering with the iframe
	$iframe_interior = htmlspecialchars("<html>
				<head>$libraries $css</head>
				<body>
					$script_itself
				</body>
			</html>");

	$output = "<figure class=\"wp-block-image\">
		<!--noptimize--><iframe class=\"p5jswp $custom_size\" $width $height sandbox=\"allow-scripts allow-pointer-lock allow-same-origin allow-popups allow-forms allow-modals\" srcdoc=\"$iframe_interior\"></iframe><!--/noptimize-->";
	
	if (isset($attrs['caption'])) {
		$output .= "<figcaption>$attrs[caption]</figcaption>";
	}

	$output .= '</figure>';
	return $output;
}
add_shortcode('p5jswp', 'p5jswp_process_shortcode');

//Move the smartcodes later on in the loading so that they don't mess with scripts
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'wptexturize', 99);		

?>
