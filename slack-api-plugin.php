<?php
/*
Plugin Name: Slack API Framework
Description: A plugin that creates a framework for working with slack.
Author:      BinaryJazz
Version:     1.0
Author URI:  https://www.binaryjazz.com/
*/

require_once trailingslashit( __DIR__ ) . 'vendor/autoload.php';

// Start the core plugin
add_action( 'plugins_loaded', function () {
	slack_api_plugin()->init();
}, 1, 0 );

function slack_api_plugin() {
	return \BinaryJazz\Slack\Core::instance( new Pimple\Container( [ 'plugin_file' => __FILE__ ] ) );
}
