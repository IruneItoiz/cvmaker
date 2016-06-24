<?php

namespace Irune\Plugins\CVMaker;

class Setup  {
	
	function __construct()
	{
		$this->setupPostType();
		$this->setupTaxonomy();
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
}