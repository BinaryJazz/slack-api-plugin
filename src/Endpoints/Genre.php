<?php

namespace BinaryJazz\Slack\Endpoints;


use BinaryJazz\Slack\Post_Types\Slack_Team;
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
		if ( get_option( Defaults::SLACK_TOKEN ) !== $_POST['token'] ) {
			return 'token failure';
		}

		if ( isset( $_POST['text'] ) && 'story' == $_POST['text'] ) {
			return [
				'response_type' => 'in_channel',
				'text'          => \BinaryJazz\Genrenator\Storynator\generate_story(),
			];
		}

		if ( isset( $_POST['text'] ) && 'status' == $_POST['text'] ) {
			$this->update_status();
		}

		if ( isset( $_POST['text'] ) && 'help' == $_POST['text'] ) {
			$help_text = '/genre will provide a music genre.';
			$help_text .= PHP_EOL . '/genre x where x is an integer will provide a list of genres.';
			$help_text .= PHP_EOL . '/genre story returns a short story.';
			$help_text .= PHP_EOL . '/genre help displays this text.';

			return [
				'context' => 'ephemeral',
				'text'    => $help_text,
			];
		}

		$count = (int) isset( $_POST['text'] ) ? $_POST['text'] : 1;

		$genre = '';
		$x     = 1;
		do {
			$genre .= \BinaryJazz\Genrenator\get_genre() . PHP_EOL;
			$x ++;
		} while ( $x <= $count );

		return [
			'response_type' => 'in_channel',
			'text'          => $genre,
		];
	}

	private function get_token( $team_id ) {
		return get_page_by_title( $team_id, OBJECT, Slack_Team::POST_TYPE )->post_content;
	}

	private function update_status() {
		return;
		// This is not updating as it should. leaving this dead for now.

		$this->message->send( 'https://slack.com/api/users.profile.set', $this->get_token( $_POST['team_id'] ), null, [
			'profile' => rawurlencode( json_encode( [
				'status_text'  => sprintf( 'listening to %s', \BinaryJazz\Genrenator\get_genre() ),
				'status_emoji' => ':musical_note:',
			] ) ),
		] );

		return 'please hold...';
	}
}