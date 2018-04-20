<?php

namespace BinaryJazz\Slack\Service_Providers;

use BinaryJazz\Slack\Shortcodes\Slack_Button;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class Shortcodes_Provider implements ServiceProviderInterface {

	const SLACK_BUTTON = 'slack_button';

	public function register( Container $container ) {
		$container[ self::SLACK_BUTTON ] = function () use ( $container ) {
			return new Slack_Button( $container[ Endpoints_Provider::ENDPOINTS_OAUTH ] );
		};

		add_action( 'init', function () use ( $container ) {
			$container[ self::SLACK_BUTTON ]->generate();
		} );
	}

}
