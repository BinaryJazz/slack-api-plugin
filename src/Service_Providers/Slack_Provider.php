<?php

namespace BinaryJazz\Slack\Service_Providers;


use BinaryJazz\Slack\Slack\Post_Message;
use BinaryJazz\Slack\Slack\Redirect_URI;
use BinaryJazz\Slack\Slack\Webhooks;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Slack_Provider implements ServiceProviderInterface {

	const REDIRECT_URI = 'slack.redirect_uri';
	const POST_MESSAGE = 'slack.post_message';
	const WEBHOOKS     = 'slack.webhooks';

	public function register( Container $container ) {
		$container[ self::REDIRECT_URI ] = function () {
			return new Redirect_URI();
		};

		$container[ self::POST_MESSAGE ] = function () {
			return new Post_Message();
		};

		$container[ self::WEBHOOKS ] = function () use ( $container ){
			return new Webhooks( $container[ self::POST_MESSAGE ] );
		};
	}

}
