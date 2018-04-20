<?php

namespace BinaryJazz\Slack\Service_Providers;


use BinaryJazz\Slack\Endpoints\OAuth;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Endpoints_Provider implements ServiceProviderInterface {

	const ENDPOINTS_OAUTH = 'endpoints.oauth';

	public function register( Container $container ) {
		$container[ self::ENDPOINTS_OAUTH ] = function () use ( $container ) {
			return new OAuth( $container[ Slack_Provider::POST_MESSAGE ], $container[ Slack_Provider::REDIRECT_URI ] );
		};

		add_action( 'rest_api_init', function () use ( $container ) {
			$container[ self::ENDPOINTS_OAUTH ]->register();
		} );

	}

}
