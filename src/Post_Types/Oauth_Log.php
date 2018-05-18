<?php

namespace BinaryJazz\Slack\Post_Types;


class Oauth_Log extends Post_Type {

	const POST_TYPE = 'oath_log';

	public function post_type() {
		return self::POST_TYPE;
	}

	public function args() {
		return [
			'public'       => false,
		];
	}

}