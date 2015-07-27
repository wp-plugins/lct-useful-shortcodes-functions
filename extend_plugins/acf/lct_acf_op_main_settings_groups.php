<?php
//Set this to 1 if you need to edit the fields
$dev = 0;

if( function_exists( 'acf_add_local_field_group' ) && ! $dev ):

	acf_add_local_field_group( [
		'key'                   => 'group_55b007453cd60',
		'title'                 => 'General Settings',      //TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE
		'fields'                => [
			[
				'key'               => 'field_55b27e8dd2719',
				'label'             => 'No Settings Yet',
				'name'              => '',
				'type'              => 'message',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'message'           => '',
				'esc_html'          => 0,
			],
		],
		'location'              => [
			[
				[
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'lct_acf_op_main_settings',
				],
			],
		],
		'menu_order'            => 1,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
	] );

endif;
