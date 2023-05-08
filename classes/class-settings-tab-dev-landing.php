<?php
namespace Jefferson\Herringbone;

/**
 * Settings Tab Developer Landing Page - Herringbone Theme.
 *
 * Settings Index
 * ==============/
 *
 * $hb_dev_landing_settings['welcome_title'];
 * $hb_dev_landing_settings['welcome_intro'];
 * $hb_dev_landing_settings['welcome_intro_cta_title'];
 * $hb_dev_landing_settings['welcome_intro_cta_text'];
 *
 * @package herringbone
 */
class Settings_Tab_Dev_Landing {

	public const PAGE  = 'hb_page_dev_landing';
	public const GROUP = 'hb_group_dev_landing';

	public $settings;

	public function init() {

		$this->settings = get_option( 'hb_dev_landing_settings' );

		register_setting(
			self::GROUP,
			'hb_dev_landing_settings',
			array( $this, 'sanitize' )
		);


		// ====================================================================== Welcome

		
		add_settings_section(
			'section_welcome',
			'Welcome Section',
			array( $this, 'section_welcome_callback' ),
			self::PAGE
		);

			add_settings_field(
				'welcome_title',
				'Page title',
				array( $this, 'welcome_title_callback' ),
				self::PAGE,
				'section_welcome'
			);

			add_settings_field(
				'welcome_intro',
				'Welcome intro',
				array( $this, 'welcome_intro_callback' ),
				self::PAGE,
				'section_welcome'
			);

			add_settings_field(
				'welcome_intro_cta_title',
				'Welcome CTA title',
				array( $this, 'welcome_intro_cta_title_callback' ),
				self::PAGE,
				'section_welcome'
			);

			add_settings_field(
				'welcome_intro_cta_text',
				'Welcome CTA text',
				array( $this, 'welcome_intro_cta_text_callback' ),
				self::PAGE,
				'section_welcome'
			);
	}


	public function sanitize( $input ) {
		$sanitary_values = array();

		if ( isset( $input['welcome_title'] ) ) {
			$sanitary_values['welcome_title'] = sanitize_text_field( $input['welcome_title'] );
		}

		if ( isset( $input['welcome_intro'] ) ) {
			$sanitary_values['welcome_intro'] = sanitize_textarea_field( $input['welcome_intro'] );
		}

		if ( isset( $input['welcome_intro_cta_title'] ) ) {
			$sanitary_values['welcome_intro_cta_title'] = sanitize_text_field( $input['welcome_intro_cta_title'] );
		}

		if ( isset( $input['welcome_intro_cta_text'] ) ) {
			$sanitary_values['welcome_intro_cta_text'] = sanitize_textarea_field( $input['welcome_intro_cta_text'] );
		}

		return $sanitary_values;
	}


	// ================================================ Section Description Callbacks


	public function section_welcome_callback() {
		echo '<p>These fields store content for the developer landing page.</p>';
	}


	// =============================================== Settings Input Field Callbacks


	public function welcome_title_callback() {
		printf(
			'<input class="regular-text" type="text" name="hb_dev_landing_settings[welcome_title]" id="welcome_title" value="%s">',
			isset( $this->settings['welcome_title'] ) ? esc_attr( $this->settings['welcome_title'] ) : ''
		);
	}

	public function welcome_intro_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[welcome_intro]" id="welcome_intro" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['welcome_intro'] ) ? esc_attr( $this->settings['welcome_intro'] ) : ''
		);
	}

	public function welcome_intro_cta_title_callback() {
		printf(
			'<input class="regular-text" type="text" name="hb_dev_landing_settings[welcome_intro_cta_title]" id="welcome_intro_cta_title" value="%s">',
			isset( $this->settings['welcome_intro_cta_title'] ) ? esc_attr( $this->settings['welcome_intro_cta_title'] ) : ''
		);
	}

	public function welcome_intro_cta_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[welcome_intro_cta_text]" id="welcome_intro_cta_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['welcome_intro_cta_text'] ) ? esc_attr( $this->settings['welcome_intro_cta_text'] ) : ''
		);
	}

}
