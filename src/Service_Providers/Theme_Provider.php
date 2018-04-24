<?php

namespace BinaryJazz\Slack\Service_Providers;


use BinaryJazz\Slack\Theme\Header;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Theme_Provider implements ServiceProviderInterface {

	const HEADER = 'theme.header';

	public function register( Container $container ) {
		$container[ self::HEADER ] = function () {
			return new Header();
		};

		add_action( 'wp_head', function () use ( $container ) {
			$container[ self::HEADER ]->meta();
		} );
	}

}