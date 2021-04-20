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

const P5JSWP_STRIP_ATTRIBUTE = '/<\/?(br|p)\s*\/?>/i';
const P5JSWP_STRIP_ATTRIBUTE_LINES = '/<\/?(br|p|\r|\n)\s*\/?>/i';

function p5jswp_process_shortcode($attrs = [], $content = null) {
	$attrs = array_change_key_case( (array) $attrs, CASE_LOWER );
	$attrs = shortcode_atts(array( //defaults
		'debug' => '',
		'js' => '',
		'script' => '',
		'css' => '',
		'width' => '',
		'height' => '',
		'caption' => '',
		'libraries' => '',
		), $attrs);

	/* JS, SCRIPT */
	$script_itself = '';
	if (!empty($attrs['js'])) {
		$script_itself .= '<script>'.preg_replace(P5JSWP_STRIP_ATTRIBUTE, '', $attrs['js']).'</script>';
	}
	if (!empty($attrs['script'])) {
		$attrs['script'] = preg_replace(P5JSWP_STRIP_ATTRIBUTE_LINES, ' ', $attrs['script']);

		foreach (explode(' ', $attrs['script']) as $script_item)
			if (!empty(trim($script_item)))
				$script_itself .= "<script src=\"$script_item\"></script>";
	} 
	if (empty($script_itself)) {
		$script_itself = '<p>' . __('p5jswp: WARNING: No `script` or `js` attributes specified', 'p5js-wp') . '</p>';
	}

	/* CSS */
	$css = '<link rel="stylesheet" href="'.plugins_url('/css/iframe-style.css', __FILE__).'"/>';
	if (!empty($attrs['css'])) 
		$css .= '<style>'. preg_replace(P5JSWP_STRIP_ATTRIBUTE, '', $attrs['css']).'</style>';
	$css = htmlspecialchars($css);

	
	/* WIDTH, HEIGHT */
	$width = '';
	$height = '';
	$custom_size = '';
	if (!empty($attrs['width'])) {
		$width = "width=\"$attrs[width]\"";
		$custom_size .= 'p5jswp-custom-width';
	} 
	if (!empty($attrs['height'])) {
		$width = "height=\"$attrs[height]\"";
		$custom_size .= ' p5jswp-custom-height';
	}

	/* LIBRARIES */
	$libraries = '';
	if (!empty($attrs['libraries'])) {
		$attrs['libraries'] = preg_replace(P5JSWP_STRIP_ATTRIBUTE_LINES, ' ', $attrs['libraries']);

		foreach (explode(' ', $attrs['libraries']) as $library)
			if (!empty(trim($library)))
				$libraries .= "<script src=\"$library\"></script>";
	}
	//default
	$libraries .= '<script src="'.plugins_url('/js/p5.min.js', __FILE__).'"></script>';
	$libraries = htmlspecialchars($libraries);
	
	//htmlspecialchars prevents contents of the scripts from interfering with the iframe
	$iframe_interior = "<html>
				<head>$libraries $css</head>
				<body>
					$script_itself
				</body>
			</html>";

	$output = "<figure class=\"wp-block-image\">
		<!--noptimize--><iframe class=\"p5jswp $custom_size\" $width $height sandbox=\"allow-scripts allow-pointer-lock allow-same-origin allow-popups allow-forms allow-modals\" srcdoc=\"$iframe_interior\"></iframe><!--/noptimize-->";
	
	/* CAPTION */
	if (!empty($attrs['caption'])) {
		$output .= "<figcaption>$attrs[caption]</figcaption>";
	}
	/* DEBUG */
	if (!empty($attrs['debug'])) {
		$output .= "<figcaption class=\"p5jswp-debug\"><ul>";
		foreach ($attrs as $key => $val) {
			if (!empty($val))
				$output .= "<li><em>$key:</em>$val</li>";
			else
				$output .= "<li><span style=\"text-decoration:line-through;\">$key</span></li>";
		}
		$output .= "</ul></figcaption>";
	}

	$output .= '</figure>';
	return $output;
}
add_shortcode('p5jswp', 'p5jswp_process_shortcode');

add_filter('no_texturize_shortcodes', 'p5jswp_no_texturize_shortcodes');	
function p5jswp_no_texturize_shortcodes($shortcodes) {
	$shortcodes []= 'p5jswp';
	return $shortcodes;
}

?>
