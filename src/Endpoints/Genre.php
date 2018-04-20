<?php

namespace BinaryJazz\Slack\Endpoints;


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
		return \BinaryJazz\Genrenator\get_genre();
	}

}