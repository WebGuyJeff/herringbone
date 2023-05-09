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
 * $hb_dev_landing_settings['welcome_cta_title'];
 * $hb_dev_landing_settings['welcome_cta_text'];
 *
 * @package herringbone
 */
class Settings_Tab_Dev_Landing {

	public const PAGE  = 'hb_page_dev_landing';
	public const GROUP = 'hb_group_dev_landing';

	public $settings;


	/**
	 * Register the settings.
	 */
	public function init() {

		$this->settings = get_option( 'hb_dev_landing_settings' );

		register_setting(
			self::GROUP,
			'hb_dev_landing_settings',
			array( $this, 'sanitize' )
		);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  Welcome


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
				'Intro',
				array( $this, 'welcome_intro_callback' ),
				self::PAGE,
				'section_welcome'
			);

			add_settings_field(
				'welcome_cta_title',
				'CTA title',
				array( $this, 'welcome_cta_title_callback' ),
				self::PAGE,
				'section_welcome'
			);

			add_settings_field(
				'welcome_cta_text',
				'CTA text',
				array( $this, 'welcome_cta_text_callback' ),
				self::PAGE,
				'section_welcome'
			);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - Services


		add_settings_section(
			'section_services',
			'Services Section',
			array( $this, 'section_services_callback' ),
			self::PAGE
		);

			add_settings_field(
				'services_title',
				'Title',
				array( $this, 'services_title_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'services_intro',
				'Intro',
				array( $this, 'services_intro_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service1_bullets',
				'Service 1 bullets',
				array( $this, 'service1_bullets_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service1_text',
				'Service 1 text',
				array( $this, 'service1_text_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service2_bullets',
				'Service 2 bullets',
				array( $this, 'service2_bullets_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service2_text',
				'Service 2 text',
				array( $this, 'service2_text_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service3_bullets',
				'Service 3 bullets',
				array( $this, 'service3_bullets_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service3_text',
				'Service 3 text',
				array( $this, 'service3_text_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service4_bullets',
				'Service 4 bullets',
				array( $this, 'service4_bullets_callback' ),
				self::PAGE,
				'section_services'
			);

			add_settings_field(
				'service4_text',
				'Service 4 text',
				array( $this, 'service4_text_callback' ),
				self::PAGE,
				'section_services'
			);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  USP


		add_settings_section(
			'section_usp',
			'USP Section',
			array( $this, 'section_usp_callback' ),
			self::PAGE
		);

			add_settings_field(
				'usp_title',
				'Title',
				array( $this, 'usp_title_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp_intro',
				'Intro',
				array( $this, 'usp_intro_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp1_text',
				'USP 1 Text',
				array( $this, 'usp1_text_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp2_text',
				'USP 2 Text',
				array( $this, 'usp2_text_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp3_text',
				'USP 3 Text',
				array( $this, 'usp3_text_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp4_text',
				'USP 4 Text',
				array( $this, 'usp4_text_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp5_text',
				'USP 5 Text',
				array( $this, 'usp5_text_callback' ),
				self::PAGE,
				'section_usp'
			);

			add_settings_field(
				'usp6_text',
				'USP 6 Text',
				array( $this, 'usp6_text_callback' ),
				self::PAGE,
				'section_usp'
			);
	}


	// ================================================ Section Description Callbacks


	public function section_welcome_callback() {
		echo '<p>Content for the developer landing page welcome section.</p>';
	}

	public function section_services_callback() {
		echo '<p>Content for the developer landing page services section.</p>
		      <p>Separate bullet points with new lines.</p>';
	}

	public function section_usp_callback() {
		echo '<p>Content for the developer landing page USP section.</p>';
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

	public function welcome_cta_title_callback() {
		printf(
			'<input class="regular-text" type="text" name="hb_dev_landing_settings[welcome_cta_title]" id="welcome_cta_title" value="%s">',
			isset( $this->settings['welcome_cta_title'] ) ? esc_attr( $this->settings['welcome_cta_title'] ) : ''
		);
	}

	public function welcome_cta_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[welcome_cta_text]" id="welcome_cta_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['welcome_cta_text'] ) ? esc_attr( $this->settings['welcome_cta_text'] ) : ''
		);
	}

	public function services_title_callback() {
		printf(
			'<input class="regular-text" type="text" name="hb_dev_landing_settings[services_title]" id="services_title" value="%s">',
			isset( $this->settings['services_title'] ) ? esc_attr( $this->settings['services_title'] ) : ''
		);
	}

	public function services_intro_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[services_intro]" id="services_intro" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['services_intro'] ) ? esc_attr( $this->settings['services_intro'] ) : ''
		);
	}

	public function service1_bullets_callback() {
		printf(
			'<textarea class="narrow-text" type="text" name="hb_dev_landing_settings[service1_bullets]" id="service1_bullets" cols="30" rows="8">%s</textarea>',
			isset( $this->settings['service1_bullets'] ) ? esc_attr( $this->settings['service1_bullets'] ) : ''
		);
	}

	public function service1_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[service1_text]" id="service1_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['service1_text'] ) ? esc_attr( $this->settings['service1_text'] ) : ''
		);
	}

	public function service2_bullets_callback() {
		printf(
			'<textarea class="narrow-text" type="text" name="hb_dev_landing_settings[service2_bullets]" id="service2_bullets" cols="30" rows="8">%s</textarea>',
			isset( $this->settings['service2_bullets'] ) ? esc_attr( $this->settings['service2_bullets'] ) : ''
		);
	}

	public function service2_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[service2_text]" id="service2_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['service2_text'] ) ? esc_attr( $this->settings['service2_text'] ) : ''
		);
	}

	public function service3_bullets_callback() {
		printf(
			'<textarea class="narrow-text" type="text" name="hb_dev_landing_settings[service3_bullets]" id="service3_bullets" cols="30" rows="8">%s</textarea>',
			isset( $this->settings['service3_bullets'] ) ? esc_attr( $this->settings['service3_bullets'] ) : ''
		);
	}

	public function service3_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[service3_text]" id="service3_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['service3_text'] ) ? esc_attr( $this->settings['service3_text'] ) : ''
		);
	}

	public function service4_bullets_callback() {
		printf(
			'<textarea class="narrow-text" type="text" name="hb_dev_landing_settings[service4_bullets]" id="service4_bullets" cols="30" rows="8">%s</textarea>',
			isset( $this->settings['service4_bullets'] ) ? esc_attr( $this->settings['service4_bullets'] ) : ''
		);
	}

	public function service4_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[service4_text]" id="service4_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['service4_text'] ) ? esc_attr( $this->settings['service4_text'] ) : ''
		);
	}

	public function usp_title_callback() {
		printf(
			'<input class="regular-text" type="text" name="hb_dev_landing_settings[usp_title]" id="usp_title" value="%s">',
			isset( $this->settings['usp_title'] ) ? esc_attr( $this->settings['usp_title'] ) : ''
		);
	}

	public function usp_intro_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp_intro]" id="usp_intro" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp_intro'] ) ? esc_attr( $this->settings['usp_intro'] ) : ''
		);
	}

	public function usp1_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp1_text]" id="usp1_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp1_text'] ) ? esc_attr( $this->settings['usp1_text'] ) : ''
		);
	}

	public function usp2_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp2_text]" id="usp2_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp2_text'] ) ? esc_attr( $this->settings['usp2_text'] ) : ''
		);
	}

	public function usp3_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp3_text]" id="usp3_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp3_text'] ) ? esc_attr( $this->settings['usp3_text'] ) : ''
		);
	}

	public function usp4_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp4_text]" id="usp4_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp4_text'] ) ? esc_attr( $this->settings['usp4_text'] ) : ''
		);
	}

	public function usp5_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp5_text]" id="usp5_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp5_text'] ) ? esc_attr( $this->settings['usp5_text'] ) : ''
		);
	}

	public function usp6_text_callback() {
		printf(
			'<textarea class="regular-text" type="text" name="hb_dev_landing_settings[usp6_text]" id="usp6_text" cols="50" rows="6">%s</textarea>',
			isset( $this->settings['usp6_text'] ) ? esc_attr( $this->settings['usp6_text'] ) : ''
		);
	}


	// =========================================================== Sanitize Callbacks


	public function sanitize( $input ) {
		$sanitary_values = array();

		if ( isset( $input['welcome_title'] ) ) {
			$sanitary_values['welcome_title'] = sanitize_text_field( $input['welcome_title'] );
		}

		if ( isset( $input['welcome_intro'] ) ) {
			$sanitary_values['welcome_intro'] = sanitize_textarea_field( $input['welcome_intro'] );
		}

		if ( isset( $input['welcome_cta_title'] ) ) {
			$sanitary_values['welcome_cta_title'] = sanitize_text_field( $input['welcome_cta_title'] );
		}

		if ( isset( $input['welcome_cta_text'] ) ) {
			$sanitary_values['welcome_cta_text'] = sanitize_textarea_field( $input['welcome_cta_text'] );
		}

		if ( isset( $input['services_title'] ) ) {
			$sanitary_values['services_title'] = sanitize_text_field( $input['services_title'] );
		}

		if ( isset( $input['services_intro'] ) ) {
			$sanitary_values['services_intro'] = sanitize_textarea_field( $input['services_intro'] );
		}

		if ( isset( $input['service1_bullets'] ) ) {
			$sanitary_values['service1_bullets'] = sanitize_textarea_field( $input['service1_bullets'] );
		}

		if ( isset( $input['service1_text'] ) ) {
			$sanitary_values['service1_text'] = sanitize_textarea_field( $input['service1_text'] );
		}

		if ( isset( $input['service2_bullets'] ) ) {
			$sanitary_values['service2_bullets'] = sanitize_textarea_field( $input['service2_bullets'] );
		}

		if ( isset( $input['service2_text'] ) ) {
			$sanitary_values['service2_text'] = sanitize_textarea_field( $input['service2_text'] );
		}

		if ( isset( $input['service3_bullets'] ) ) {
			$sanitary_values['service3_bullets'] = sanitize_textarea_field( $input['service3_bullets'] );
		}

		if ( isset( $input['service3_text'] ) ) {
			$sanitary_values['service3_text'] = sanitize_textarea_field( $input['service3_text'] );
		}

		if ( isset( $input['service4_bullets'] ) ) {
			$sanitary_values['service4_bullets'] = sanitize_textarea_field( $input['service4_bullets'] );
		}

		if ( isset( $input['service4_text'] ) ) {
			$sanitary_values['service4_text'] = sanitize_textarea_field( $input['service4_text'] );
		}

		if ( isset( $input['usp_title'] ) ) {
			$sanitary_values['usp_title'] = sanitize_text_field( $input['usp_title'] );
		}

		if ( isset( $input['usp_intro'] ) ) {
			$sanitary_values['usp_intro'] = sanitize_textarea_field( $input['usp_intro'] );
		}

		if ( isset( $input['usp1_text'] ) ) {
			$sanitary_values['usp1_text'] = sanitize_textarea_field( $input['usp1_text'] );
		}

		if ( isset( $input['usp2_text'] ) ) {
			$sanitary_values['usp2_text'] = sanitize_textarea_field( $input['usp2_text'] );
		}

		if ( isset( $input['usp3_text'] ) ) {
			$sanitary_values['usp3_text'] = sanitize_textarea_field( $input['usp3_text'] );
		}

		if ( isset( $input['usp4_text'] ) ) {
			$sanitary_values['usp4_text'] = sanitize_textarea_field( $input['usp4_text'] );
		}

		if ( isset( $input['usp5_text'] ) ) {
			$sanitary_values['usp5_text'] = sanitize_textarea_field( $input['usp5_text'] );
		}

		if ( isset( $input['usp6_text'] ) ) {
			$sanitary_values['usp6_text'] = sanitize_textarea_field( $input['usp6_text'] );
		}

		return $sanitary_values;
	}
}
