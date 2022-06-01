<?php
/*

Plugin Name: Fundraising Donation Thermometer
Plugin URI: https://epirium.online/
Version: 1.0
Description: This is a short description of what the plugin does. It's displayed in the WordPress admin area.
Author: Epirium
Author URI: https://themeforest.net/user/epirium
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: fdt-epirium
Domain Path: /languages

*/


// Settings Page: Thermometer
// Retrieving values: get_option( 'your_field_id' )
class Thermometer_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
	}

	public function wph_create_settings() {

    //The icon in Base64 format
	$icon_base64 = 'PHN2ZyB3aWR0aD0iMjRweCIgaGVpZ2h0PSIyNHB4IiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgPHBhdGggZD0iTTExLjE3NTgwNDUsMTEuNTI5OTY0OSBDMTEuNzIyMjQ4MSwxMC43NjMwMjQ4IDExLjY2MTI2OTQsOS45NTUyOTU1NSAxMS4yODIzNjI2LDguNTAyMzQ0NjYgQzEwLjUzMjk5MjksNS42Mjg4MjE4NyAxMC44MzEzODkxLDQuMDUzODI4NjcgMTMuNDE0NzMyMSwyLjE4OTE2MDA0IEwxNC42NzU2MTM5LDEuMjc5MDQ5ODYgTDE0Ljk4MDU4MDcsMi44MDM4ODM4NiBDMTUuMzA0Njg2MSw0LjQyNDQxMDc1IDE1LjgzNjkzOTgsNS40MjY3MDY3MSAxNy4yMDM1NzY2LDcuMzU0NjQwNzggQzE3LjI1Nzg3MzUsNy40MzEyMjAyMiAxNy4yNTc4NzM1LDcuNDMxMjIwMjIgMTcuMzEyNDEwOCw3LjUwODE0MjI2IEMxOS4yODA5NzU0LDEwLjI4NTQxNDQgMjAsMTEuOTU5NjIwNCAyMCwxNSBDMjAsMTguNjg4MzUxNyAxNi4yNzEzNTY0LDIyIDEyLDIyIEM3LjcyODQwODc5LDIyIDQsMTguNjg4ODA0MyA0LDE1IEM0LDE0LjkzMTA1MzEgNC4wMDAwNzA2NiwxNC45MzMxNDI3IDMuOTg4Mzg4NTIsMTQuNjI4NDUwNiBDMy44OTgwMzI4NCwxMi4yNzE4MDU0IDQuMzMzODA5NDYsMTAuNDI3MzY3NiA2LjA5NzA2NjY2LDguNDM1ODYwMjIgQzYuNDY5NjE0MTUsOC4wMTUwODcyIDYuODkzMDgzNCw3LjYxMDY3NTM0IDcuMzY5NjI3MTQsNy4yMjM3MDc0OSBMOC40MjE2MTgwMiw2LjM2OTQ1OTI2IEw4LjkyNzY2MTIsNy42MjY1NzcwNiBDOS4zMDE1Nzk0OCw4LjU1NTQ2ODc4IDkuNzM5Njk3MTYsOS4yODU2NjQ5MSAxMC4yMzQ2MDc4LDkuODIxNTA4MDQgQzEwLjY1Mzc4NDgsMTAuMjc1MzUzOCAxMC45NjQ3NDAxLDEwLjg0NjA2NjUgMTEuMTc1ODA0NSwxMS41Mjk5NjQ5IFogTTcuNTk0NDg1MzEsOS43NjE2NTcxMSBDNi4yMzcxMTc3OSwxMS4yOTQ3MzMyIDUuOTE0NDA5MjgsMTIuNjYwNjA2OCA1Ljk4NjkyMDEyLDE0LjU1MTgyNTIgQzYuMDAwNDE5MDMsMTQuOTAzOTAxOSA2LDE0Ljg5MTUxMDggNiwxNSBDNiwxNy41Mjc4ODc4IDguNzgzNjAwMjEsMjAgMTIsMjAgQzE1LjIxNjEzNjgsMjAgMTgsMTcuNTI3NDcyIDE4LDE1IEMxOCwxMi40NTgyMDcyIDE3LjQzMTczMjEsMTEuMTM1MDI5MiAxNS42ODA3MzA1LDguNjY0Njk3MjUgQzE1LjYyNjQ4MDMsOC41ODgxODAxNCAxNS42MjY0ODAzLDguNTg4MTgwMTQgMTUuNTcxOTMzNiw4LjUxMTI0ODQ0IEMxNC41MDg1NDQyLDcuMDExMTA5OCAxMy44NzQ2ODAyLDUuOTY3NTg2OTEgMTMuNDU1MzMzNiw0LjgwMDUyMTEgQzEyLjc3MDQ3ODYsNS42MjExNzc3NSAxMi44MTA3NDQ3LDYuNDM3Mzg5ODggMTMuMjE3NjM3NCw3Ljk5NzY1NTM0IEMxMy45NjcwMDcxLDEwLjg3MTE3ODEgMTMuNjY4NjEwOSwxMi40NDYxNzEzIDExLjA4NTI2NzksMTQuMzEwODQgTDkuNjEyMjcyNTksMTUuMzc0MDU0NiBMOS41MDE4NDkxMSwxMy41NjA3ODQ4IEM5LjQzMTI5NzIzLDEyLjQwMjI0ODcgOS4xNjkwNjQ2MSwxMS42MTU1NTA4IDguNzY1MzkyMTcsMTEuMTc4NDkyIEM4LjM2NjU2NTY2LDEwLjc0NjY3OTggOC4wMDY0NjgzNSwxMC4yNDExNDI2IDcuNjgzNTUwMjcsOS42NjI3ODkyNSBDNy42NTM0Mjk4NSw5LjY5NTY1NjM4IDcuNjIzNzQyNTQsOS43Mjg2MTI1OSA3LjU5NDQ4NTMxLDkuNzYxNjU3MTEgWiIvPgo8L3N2Zz4K';

	//The icon in the data URI scheme
	$icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

		$page_title = 'Fundraising Donation Thermometer';
		$menu_title = 'Thermometer';
		$capability = 'manage_options';
		$slug = 'Thermometer';
		$callback = array($this, 'wph_settings_content');
        $icon_data_uri;
		$position = 99;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon_data_uri, $position);
		
	}
    
	public function wph_settings_content() { ?>
		<div class="wrap">
			<h1>Thermometer</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'Thermometer' );
					do_settings_sections( 'Thermometer' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function wph_setup_sections() {
		add_settings_section( 'Thermometer_section', '', array(), 'Thermometer' );
	}

	public function wph_setup_fields() {
		$fields = array(
                    array(
                        'section' => 'Thermometer_section',
                        'label' => 'Goal Amount',
                        'id' => 'fdt-epirium-goal',
                        'type' => 'number',
                    ),
        
                    array(
                        'section' => 'Thermometer_section',
                        'label' => 'Raised Amount',
                        'id' => 'fdt-epirium-raised',
                        'type' => 'number',
					),

		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'Thermometer', $field['section'], $field );
			register_setting( 'Thermometer', $field['id'] );
		}
	}

	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
            
            
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
    

}

new Thermometer_Settings_Page();

/**
 * Never worry about cache again!
 */
function Epirium_embed_enqueue_script() {   
    wp_enqueue_script( 'fdt-thermometer-script', plugin_dir_url( __FILE__ ) . 'js/embed.js' );
}
add_action('wp_enqueue_scripts', 'Epirium_embed_enqueue_script');

function HelloWorldShortcode() {
    $atts = plugin_dir_url( __FILE__ ) . 'js/embed.js';
	return '<svg id="fundraising-thermometer-411" width="800" height="1050"></svg>
    <script>
      var fundraising_thermometer_411 = {"layout":"1","fill-color":"[fillcolor-fdt]","goal-amount":"[goalamount]","progress-amount":"[progamount]","show-goal-amount":"1","show-progress-percentage":"1","show-progress-amount":"1","animate-progress-fill":"1"};
    </script>
    <script for="fundraising-thermometer-411" type="text/javascript" src="'.$atts.'"></script>';
}
add_shortcode('helloworld', 'HelloWorldShortcode');

function GoalAmmount() {
	$fdt_goal = get_option( 'fdt-epirium-goal' );
	

	return $fdt_goal;
}

add_shortcode('goalamount', 'GoalAmmount');

function ProgressAmt() {
	$fdt_prog = get_option('fdt-epirium-raised');

	return $fdt_prog;
}

add_shortcode('progamount','ProgressAmt');

function FillColor() {
	$fdt_fill = get_option('fdt-epirium-fill-color');

	return $fdt_fill;
}

add_shortcode('fillcolor-fdt','FillColor');


