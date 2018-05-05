<?php

namespace BinaryJazz\Slack\Service_Providers;


use BinaryJazz\Slack\Post_Types\Message_Log;
use BinaryJazz\Slack\Post_Types\Oauth_Log;
use BinaryJazz\Slack\Post_Types\Slack_Team;
use BinaryJazz\Slack\Post_Types\Slack_URL;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Post_Type_Provider implements ServiceProviderInterface {

	const SLACK_URL   = 'post_types.slack_urls';
	const SLACK_TEAM  = 'post_types.slack_team';
	const MESSAGE_LOG = 'post_types.message_log';
	const OAUTH_LOG   = 'post_types.oauth_log';

	public function register( Container $container ) {
		$container[ self::SLACK_URL ]   = function () {
			return new Slack_URL();
		};
		$container[ self::SLACK_TEAM ]  = function () {
			return new Slack_Team();
		};
		$container[ self::MESSAGE_LOG ] = function () {
			return new Message_Log();
		};
		$container[ self::OAUTH_LOG ] = function () {
			return new Oauth_Log();
		};

		add_action( 'init', function () use ( $container ) {
			$container[ self::SLACK_URL ]->register();
			$container[ self::SLACK_TEAM ]->register();
			$container[ self::MESSAGE_LOG ]->register();
			$container[ self::OAUTH_LOG ]->register();
		} );
	}

}
