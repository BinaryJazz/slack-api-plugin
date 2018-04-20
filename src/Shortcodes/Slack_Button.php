<?php

namespace BinaryJazz\Slack\Shortcodes;

use BinaryJazz\Slack\Endpoints\OAuth;
use BinaryJazz\Slack\Settings\Defaults;

class Slack_Button {

	const ENDPOINT = 'https://slack.com/oauth/authorize?scope=incoming-webhook,users.profile:write';

	/**
	 * @var OAuth
	 */
	protected $o_auth;

	public function __construct( OAuth $o_auth ) {
		$this->o_auth = $o_auth;
	}

	public function generate() {
		add_shortcode( 'slack_button', [ $this, 'build_button' ] );
	}

	public function build_button() {
		return sprintf( '<a href="%s"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>',
			$this->build_url()
		);
	}

	private function build_url() {
		$args = [
			'scope'        => 'incoming-webhook',
			'client_id'    => get_option( Defaults::SLACK_APP_ID ),
			'redirect_uri' => $this->o_auth->get_endpoint_url(),
		];

		return add_query_arg( $args, self::ENDPOINT );
	}

}
