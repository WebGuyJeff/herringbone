<?php
namespace Jefferson\Herringbone;

/**
 * Settings Tab Theme - Herringbone Theme.
 *
 * Settings Index
 * ==============/
 *
 * $hb_settings['hb_email_address'];           // Email Address
 * $hb_settings['hb_phone_number'];            // Phone Number
 * $hb_settings['hb_gmaps_api_key'];           // Google Maps API Key
 * $hb_settings['hb_facebook_url'];            // Facebook URL
 * $hb_settings['hb_instagram_url'];           // Instagram URL
 * $hb_settings['hb_twitter_url'];             // Twitter URL
 * $hb_settings['hb_github_url'];              // Github URL
 *
 * @package herringbone
 */
class Settings_Tab_Theme {

	public const PAGE  = 'hb_page_theme';
	public const GROUP = 'hb_group_theme';

	public $settings;

	public function init() {

		$this->settings = get_option( 'hb_theme_settings' );

		register_setting(
			self::GROUP,
			'hb_theme_settings',
			array( $this, 'hb_sanitize' )
		);


		// ============================================================= Contact Section


		add_settings_section(
			'hb_contact_section',
			'Contact Information',
			array( $this, 'hb_contact_section_callback' ),
			self::PAGE
		);

			add_settings_field(
				'hb_email_address',
				'Email address',
				array( $this, 'hb_email_address_callback' ),
				self::PAGE,
				'hb_contact_section'
			);

			add_settings_field(
				'hb_phone_number',
				'Phone number',
				array( $this, 'hb_phone_number_callback' ),
				self::PAGE,
				'hb_contact_section'
			);

			add_settings_field(
				'hb_gmaps_api_key',
				'Google Maps API key',
				array( $this, 'hb_gmaps_api_key_callback' ),
				self::PAGE,
				'hb_contact_section'
			);


		// ============================================== Social Media and External Links


		add_settings_section(
			'hb_social_section',
			'Social Media and External Links',
			array( $this, 'hb_social_section_section_callback' ),
			self::PAGE
		);

			add_settings_field(
				'hb_facebook_url',
				'Facebook URL',
				array( $this, 'hb_facebook_url_callback' ),
				self::PAGE,
				'hb_social_section'
			);

			add_settings_field(
				'hb_instagram_url',
				'Instagram URL',
				array( $this, 'hb_instagram_url_callback' ),
				self::PAGE,
				'hb_social_section'
			);

			add_settings_field(
				'hb_twitter_url',
				'Twitter URL',
				array( $this, 'hb_twitter_url_callback' ),
				self::PAGE,
				'hb_social_section'
			);

			add_settings_field(
				'hb_github_url',
				'Github URL',
				array( $this, 'hb_github_url_callback' ),
				self::PAGE,
				'hb_social_section'
			);

	}


	public function hb_sanitize( $input ) {
		$sanitary_values = array();

		if ( isset( $input['hb_email_address'] ) ) {
			$sanitary_values['hb_email_address'] = sanitize_email( $input['hb_email_address'] );
		}

		if ( isset( $input['hb_phone_number'] ) ) {
			$sanitary_values['hb_phone_number'] = sanitize_text_field( $input['hb_phone_number'] );
		}

		if ( isset( $input['hb_gmaps_api_key'] ) ) {
			$sanitary_values['hb_gmaps_api_key'] = sanitize_text_field( $input['hb_gmaps_api_key'] );
		}

		if ( isset( $input['hb_facebook_url'] ) ) {
			$sanitary_values['hb_facebook_url'] = sanitize_text_field( $input['hb_facebook_url'] );
		}

		if ( isset( $input['hb_instagram_url'] ) ) {
			$sanitary_values['hb_instagram_url'] = sanitize_text_field( $input['hb_instagram_url'] );
		}

		if ( isset( $input['hb_twitter_url'] ) ) {
			$sanitary_values['hb_twitter_url'] = sanitize_text_field( $input['hb_twitter_url'] );
		}

		if ( isset( $input['hb_github_url'] ) ) {
			$sanitary_values['hb_github_url'] = sanitize_text_field( $input['hb_github_url'] );
		}

		return $sanitary_values;
	}


	// ================================================ Section Description Callbacks


	public function hb_contact_section_callback() {
		echo '<p>Contact Information displayed across the website.</p>';
	}

	public function hb_social_section_section_callback() {
		echo '<p>Configure external links for social accounts.</p>';
	}


	// =============================================== Settings Input Field Callbacks


	public function hb_email_address_callback() {
		printf(
			'<input class="regular-text" type="email" name="hb_theme_settings[hb_email_address]" id="hb_email_address" value="%s">',
			isset( $this->settings['hb_email_address'] ) ? esc_attr( $this->settings['hb_email_address'] ) : ''
		);
	}

	public function hb_phone_number_callback() {
		printf(
			'<input class="regular-text" type="tel" pattern="[0-9 ]+" name="hb_theme_settings[hb_phone_number]" id="hb_phone_number" value="%s">',
			isset( $this->settings['hb_phone_number'] ) ? esc_attr( $this->settings['hb_phone_number'] ) : ''
		);
	}

	public function hb_gmaps_api_key_callback() {
		printf(
			'<input class="regular-text" type="text" name="hb_theme_settings[hb_gmaps_api_key]" id="hb_gmaps_api_key" value="%s">',
			isset( $this->settings['hb_gmaps_api_key'] ) ? esc_attr( $this->settings['hb_gmaps_api_key'] ) : ''
		);
	}

	public function hb_facebook_url_callback() {
		printf(
			'<input class="regular-text" type="url" name="hb_theme_settings[hb_facebook_url]" id="hb_facebook_url" value="%s">',
			isset( $this->settings['hb_facebook_url'] ) ? esc_url( $this->settings['hb_facebook_url'] ) : ''
		);
	}

	public function hb_instagram_url_callback() {
		printf(
			'<input class="regular-text" type="url" name="hb_theme_settings[hb_instagram_url]" id="hb_instagram_url" value="%s">',
			isset( $this->settings['hb_instagram_url'] ) ? esc_url( $this->settings['hb_instagram_url'] ) : ''
		);
	}

	public function hb_twitter_url_callback() {
		printf(
			'<input class="regular-text" type="url" name="hb_theme_settings[hb_twitter_url]" id="hb_twitter_url" value="%s">',
			isset( $this->settings['hb_twitter_url'] ) ? esc_url( $this->settings['hb_twitter_url'] ) : ''
		);
	}

	public function hb_github_url_callback() {
		printf(
			'<input class="regular-text" type="url" name="hb_theme_settings[hb_github_url]" id="hb_github_url" value="%s">',
			isset( $this->settings['hb_github_url'] ) ? esc_url( $this->settings['hb_github_url'] ) : ''
		);
	}

}
