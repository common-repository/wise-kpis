<?php
// Settings Page: Wise KPIs Settings

if ( ! class_exists( 'Codekamino_Kpis_Settings_Page' ) ) :
	class Codekamino_Kpis_Settings_Page {

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
			add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
			add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
		}

		public function wph_create_settings() {
			$page_title = __( 'Wise KPIs Settings', 'wise-kpis');
			$menu_title = __( 'Wise KPIs Settings', 'wise-kpis');
			$capability = 'manage_options';
			$slug       = 'woowisekpissettings';
			$callback   = array( $this, 'wph_settings_content' );
			add_options_page( $page_title, $menu_title, $capability, $slug, $callback );
		}

		public function wph_settings_content() {
			?>
			<div class="wrap">
				<h1><?php _e( 'Wise KPIs Settings', 'wise-kpis'); ?></h1>
				<?php settings_errors(); ?>
				<form method="POST" action="options.php">
					<?php
					settings_fields( 'woowisekpissettings' );
					do_settings_sections( 'woowisekpissettings' );
					submit_button();
					?>
				</form>
			</div> <?php
		}

		public function wph_setup_sections() {
			add_settings_section( 'woowisekpissettings_section', __( 'Settings', 'wise-kpis'), [], 'woowisekpissettings' );
		}

		public function wph_setup_fields() {
			$fields = array(
				array(
					'label'   => __( 'KPIs Blocks Design', 'wise-kpis'),
					'id'      => 'woowise-kpis-block-design',
					'type'    => 'select',
					'section' => 'woowisekpissettings_section',
					'options' => array(
						'simple-clean'              => __( 'Simple', 'wise-kpis'),
						'dark-mode'                 => __( 'Dark', 'wise-kpis'),
						'gradient-background'       => __( 'Gradient Background', 'wise-kpis'),
						'centered-text'             => __( 'Centered', 'wise-kpis'),
						'vertical-aligned-centered' => __( 'Vertical Aligned Centered', 'wise-kpis'),
					),
					'desc'    => __( 'Will change the look and feel of the KPIs display', 'wise-kpis'),
				),
			);
			foreach ( $fields as $field ) {
				add_settings_field( $field['id'], $field['label'], array(
					$this,
					'wph_field_callback'
				), 'woowisekpissettings', $field['section'], $field );
				register_setting( 'woowisekpissettings', $field['id'] );
			}
		}

		public function wph_field_callback( $field ) {
			$value       = get_option( $field['id'] );
			$placeholder = '';
			if ( isset( $field['placeholder'] ) ) {
				$placeholder = $field['placeholder'];
			}
			switch ( $field['type'] ) {
				case 'select':
				case 'multiselect':
					if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
						$attr    = '';
						$options = '';
						foreach ( $field['options'] as $key => $label ) {
							$options .= sprintf(
								'<option value="%s" %s>%s</option>',
								$key,
								selected( $value, $key, false ),
								$label
							);
						}
						if ( $field['type'] === 'multiselect' ) {
							$attr = ' multiple="multiple" ';
						}
						printf(
							'<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
							$field['id'],
							$attr,
							$options
						);
					}
					break;
				default:
					printf(
						'<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
						$field['id'],
						$field['type'],
						$placeholder,
						$value
					);
			}
			if ( isset( $field['desc'] ) ) {
				if ( $desc = $field['desc'] ) {
					printf( '<p class="description">%s </p>', $desc );
				}
			}
		}
	}

	new Codekamino_Kpis_Settings_Page();
endif;
