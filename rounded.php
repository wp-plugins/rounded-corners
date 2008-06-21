<?php
	/*
	Plugin Name: Rounded Corners
	Plugin URI: http://www.pancak.es/plugins/rounded-corners/
	Description: Selectively add rounded corners to elements with pure JavaScript. Still in experimental phases.
	Author: Nick Berlette
	Version: 0.2a
	Author URI: http://www.pancak.es/
	*/
	#get options
	$rounded = get_option('rounded');
	if (!$rounded) update_option('rounded', array());
	#append code to admin and frontend
	add_action('wp_head', 'append_js');
	add_action('admin_menu', 'append_pages');
	#functionality
	function append_js () {
		$rounded = get_option('rounded');
		echo '<script type="text/javascript" src="/' . PLUGINDIR . '/rounded/mt-core.js"></script>' . "\n";
		echo '<script type="text/javascript" src="/' . PLUGINDIR . '/rounded/mt-more.js"></script>' . "\n";
		echo '<script type="text/javascript" src="/' . PLUGINDIR . '/rounded/rounded.js"></script><script type="text/javascript">' . "\n" . 'window.onload = function () {' . "\n";
		foreach ($rounded as $element) echo "render_corners('$element[0]', $element[1], '#$element[2]');\n";
		echo '}' . "\n" . '</script>' . "\n";
	}
	function append_pages () {
		add_theme_page('Rounded Corners Options', 'Rounded Corners', 8, __FILE__, 'options_page');
	}
	function options_page () {
		$rounded = get_option('rounded');
		$page = $_GET['page'];
		if (isset($_POST['action'])) {
			$elements = array();
			for ($i = 0; $i < count($_POST['element_id']); $i++) {
				$elements[] = array(
					$_POST['element_id'][$i],
					$_POST['radius'][$i],
					$_POST['color'][$i]
				);
			}
			update_option('rounded', $elements);
			echo '<div id="message" class="updated fade"><p><strong>' . __('Your Rounded Corners options have been saved.') . '</strong></p></div>';
			$rounded = get_option('rounded');
		}
		include ABSPATH . PLUGINDIR . '/rounded/admin.php';
	}
?>