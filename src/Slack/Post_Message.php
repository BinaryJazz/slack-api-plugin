<?php

namespace BinaryJazz\Slack\Slack;


use BinaryJazz\Slack\Post_Types\Message_Log;

class Post_Message {

	const ENDPOINT = 'https://slack.com/api/chat.postMessage';

	public function send( $endpoint = null, $token, $channel, $message ) {

		if ( null == $endpoint ) {
			$endpoint = self::ENDPOINT;
		}

		$message['channel'] = $channel;

		$result = wp_remote_post( $endpoint,
			[
				'headers' => [
					'Content-Type'  => 'application/json',
					'Authorization' => "Bearer $token",
				],
				'body'    => json_encode( $message ),
			]
		);

		// Log the request results.
		$args = [
			'post_content' => print_r( $result, 1 ) . print_r( $message, 1 ),
			'post_status'  => 'publish',
			'post_type'    => Message_Log::POST_TYPE,
			'post_title'   => $channel,
		];

		return wp_insert_post( $args );
	}

}
