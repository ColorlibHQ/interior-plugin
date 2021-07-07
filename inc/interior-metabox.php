<?php
function interior_page_metabox( $meta_boxes ) {

	$interior_prefix = '_interior_';
	$meta_boxes[] = array(
		'id'        => 'interior_metaboxes',
		'title'     => esc_html__( 'Additional Options', 'interior-companion' ),
		'post_types'=> array( 'project' ),
		'priority'  => 'high',
		'autosave'  => 'false',
		'fields'    => array(
			array(
				'id'    => $interior_prefix . 'project_excerpt_txt',
				'type'  => 'textarea',
				'name'  => esc_html__( 'Project Excerpt Text', 'interior-companion' ),
			),
			array(
				'id'    => $interior_prefix . 'project_date',
				'type'  => 'date',
				'js_options' => array(
					'dateFormat'      => 'dd-M-yy',
					'showButtonPanel' => false,
				),
				'name'  => esc_html__( 'Project Date', 'interior-companion' ),
			),
			array(
				'id'    => $interior_prefix . 'project_location',
				'type'  => 'text',
				'name'  => esc_html__( 'Project Location', 'interior-companion' ),
			),
			array(
				'id'    => $interior_prefix . 'project_imgs',
				'type'  => 'image_advanced',
				'multiple'  => true,
				'name'  => esc_html__( 'Project Images', 'interior-companion' ),
				'description' => esc_html__( 'Best size is 1146x680', 'interior-companion' ),
			),
			array(
				'id'    => $interior_prefix . 'project_quote_txt',
				'type'  => 'textarea',
				'name'  => esc_html__( 'Project Quote Box', 'interior-companion' ),
			),
			array(
				'id'    => $interior_prefix . 'project_left_txt',
				'type'  => 'textarea',
				'name'  => esc_html__( 'Project Left Box', 'interior-companion' ),
			),
			array(
				'id'    => $interior_prefix . 'project_right_txt',
				'type'  => 'textarea',
				'name'  => esc_html__( 'Project Right Box', 'interior-companion' ),
			),
		),
	);


	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'interior_page_metabox' );
