<?php

namespace Irune\Plugins\CVMaker;

class Setup  {
	
	function __construct()
	{
		$this->setupPostType();
		$this->setupTaxonomy();
		if( is_admin() )
		{
			$this->setupConfigScreens();
		}
	}
	
	function setupPostType()
	{
		register_post_type( 'iru_positions',
    	array(
      		'labels' => array(
        		'name' => __( 'Positions' ),
        		'singular_name' => __( 'Position' )
      		),
      		'public' => true,
      		'has_archive' => false,
	    	)
	  	);
	}
	
	function setupTaxonomy()
	{
		// create a new taxonomy
		$labels = array(
				'name' => 'Skills',
				'add_new_item' => 'Add New Skill',
				'new_item_name' => "New Skill"
		);
		
		$args = array(
			'hierarchical'          => false,
			'labels'              	=> $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			//'rewrite'             => array( 'slug' => 'writer' ),
			'show_tagcloud' 		=> true
		);

		register_taxonomy( 'skills', 'iru_positions', $args );
		register_taxonomy_for_object_type( 'skills', 'iru_positions' );
	}
	
	function setupConfigScreens()
	{
		add_action( 'admin_init', array( $this, 'settingsInit' ) );
		add_action( 'admin_menu', array( $this, 'pageInit' ) );
	}
	
	function pageInit()
	{
		
		$settingsPage = function()
		{		
			?>
	        <div class="wrap">
	            <h2>CVMaker LinkedIn Integration</h2>
	            <?php settings_errors(); ?>           
	            <form method="post" action="options.php">
	            <?php
	                // This prints out all hidden setting fields
	                settings_fields( 'cvmaker-admin' );   
	                do_settings_sections( 'cvmaker-admin' );
	                submit_button(); 
	            ?>
	            </form>
	        </div>
			<?php
		};
		
		add_options_page(
				'CVMaker Settings',
				'CVMaker',
				'manage_options',
				'cvmaker-admin',
				$settingsPage //array($this, 'printSettingsPage')
				);
	}
	
	function settingsInit()
	{

		//Setup the configuration screen for the LI importer
		//Configuration variables: api_key, api_secret, callback_url

		add_settings_section(
				'cvmaker_linkedin_settings', // ID
				'LinkedIn Integration Settings', // Title
				array( $this, 'printHeaders' ), // Callback
				'cvmaker-admin' // Page
				);
		
		add_settings_field(
				'api_key', // ID
				'API key', // Title
				array( $this, 'printOption' ), // Callback
				'cvmaker-admin', // Page
				'cvmaker_linkedin_settings', // Section
				array (
						'label_for' => 'api_key',
						'type'      => 'text'
				)
				);
		
		add_settings_field(
				'api_secret',
				'API secret',
				array( $this, 'printOption' ),
				'cvmaker-admin',
				'cvmaker_linkedin_settings',
				array (
						'label_for' => 'api_secret',
						'type'      => 'text'
				)
				);
		add_settings_field(
				'callback_url',
				'Callback URL',
				array( $this, 'printOption' ),
				'cvmaker-admin',
				'cvmaker_linkedin_settings',
				array (
						'label_for' => 'callback_url',
						'type'      => 'text'
				)
				);
		register_setting(
				'cvmaker-admin', // Option group
				'api_key' // Option name
				);
		register_setting(
				'cvmaker-admin', // Option group
				'api_secret' // Option name
				);
		register_setting(
				'cvmaker-admin', // Option group
				'callback_url' // Option name
				);
	}
	
	function printOption(array $args)
	{
		$type   = $args['type'];
    	$id     = $args['label_for'];
    	$data   = get_option( $id);
    	
		
    	$value  = esc_attr($data  );
    	$name   = $id;
    	

    	print "<input type='$type' value='$value' name='$name' id='$id'
        	class='regular-text code' />";
	}
		
	function printHeaders()
	{
		print 'Enter LinkedIn API Integration settings below:';
	}
}