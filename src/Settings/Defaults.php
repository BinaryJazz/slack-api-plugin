<?php

namespace BinaryJazz\Slack\Settings;

class Defaults {

	const SETTINGS_PAGE_NAME = 'rocket-launch-slack-notifier';

	const SETTINGS_GROUP = 'rocket-launch-slack-notifier-group';

	const SLACK_APP_ID     = 'slack_app_id';
	const SLACK_APP_SECRET = 'slack_app_secret';

	const SUCCESS_MESSAGE = 'slack_success_message';

	const SUCCESS_PAGE = 'slack_api_success';
	const FAILURE_PAGE = 'slack_api_failure';

	public function create_menu() {
		add_submenu_page(
			'options-general.php',
			__( 'Rocket App Settings', 'tribe' ),
			__( 'Rocket App Settings', 'tribe' ),
			'edit_posts',
			self::SETTINGS_PAGE_NAME,
			[ $this, 'default_settings' ]
		);
	}

	public function text_fields() {
		return [
			self::SLACK_APP_ID     => __( 'Slack APP ID', 'tribe' ),
			self::SLACK_APP_SECRET => __( 'Slack APP Secret', 'tribe' ),
			self::SUCCESS_MESSAGE  => __( 'Success Message', 'tribe' ),
		];
	}

	public function page_fields() {
		return [
			self::SUCCESS_PAGE => __( 'Success Page', 'tribe' ),
			self::FAILURE_PAGE => __( 'Failure Page', 'tribe' ),
		];
	}

	public function register_settings() {
		register_setting( self::SETTINGS_GROUP, self::SLACK_APP_ID );
		register_setting( self::SETTINGS_GROUP, self::SLACK_APP_SECRET );
		register_setting( self::SETTINGS_GROUP, self::SUCCESS_MESSAGE );
		register_setting( self::SETTINGS_GROUP, self::SUCCESS_PAGE );
		register_setting( self::SETTINGS_GROUP, self::FAILURE_PAGE );

		$this->text_input_settings();
		$this->page_input_settings();

	}

	public function default_settings() {

		?>
		<div class="wrap">
			<h1>Rocket App Settings</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( self::SETTINGS_GROUP );
				do_settings_sections( self::SETTINGS_PAGE_NAME );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	private function text_input_settings() {
		foreach ( $this->text_fields() as $field => $title ) {
			add_settings_section(
				$field . '_section',
				$title,
				function () use ( $field ) {
					printf( '<input value="%s" name="%s">',
						get_option( $field ),
						$field
					);
				},
				self::SETTINGS_PAGE_NAME
			);
		}
	}

	private function page_input_settings() {
		foreach ( $this->page_fields() as $field => $title ) {
			add_settings_section(
				$field . '_section',
				$title,
				function () use ( $field ) {
					wp_dropdown_pages( [
						'name' => $field,
						'selected' => get_option( $field ),
					] );
				},
				self::SETTINGS_PAGE_NAME
			);
		}
	}

}
