<?php

namespace BinaryJazz\Slack\Endpoints;


use BinaryJazz\Slack\Settings\Defaults;

class Genre extends Base {

	const ENDPOINT = '/genre';

	public function register() {
		register_rest_route( self::PATH, self::ENDPOINT, [
			'methods'  => 'POST',
			'callback' => [ $this, 'genre' ],
		] );
	}

	public function endpoint() {
		return self::ENDPOINT;
	}

	public function genre() {
		if ( get_option( Defaults::SLACK_TOKEN) !== $_POST['token'] ) {
			return 'token failure';
		}

		if ( isset( $_POST['text'] ) && 'story' == $_POST['text'] ) {
			return [
				'response_type' => 'in_channe',
				'text'          => \BinaryJazz\Genrenator\Storynator\generate_story(),
			];
		}

		$count = (int) isset( $_POST['text'] ) ? $_POST['text'] : 1;

		$genre = '';
		$x     = 1;
		do{
			$genre .= \BinaryJazz\Genrenator\get_genre() . PHP_EOL;
			$x++;
		} while ( $x <= $count );

		return [
			'response_type' => 'in_channel',
			'text'          => $genre,
		];
	}

}