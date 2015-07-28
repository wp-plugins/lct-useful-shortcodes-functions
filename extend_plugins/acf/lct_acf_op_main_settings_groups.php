<?php
//Set this to 1 if you need to edit the fields
$dev = 0;

if( function_exists( 'acf_add_local_field_group' ) && ! $dev ):

	acf_add_local_field_group( [
		'key'                   => 'group_55b007453cd60',
		'title'                 => 'General Settings',      //TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE
		'fields'                => [
			[
				'key'               => 'field_55b7d1ecd6712',
				'label'             => 'Hide the admin bar on the front-end',
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
			[
				'key'               => 'field_55b27e8dd2719',
				'label'             => 'For All...',
				'name'              => 'lct:::hide_admin_bar__by_role',
				'type'              => 'checkbox',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '//TODO: cs - make_this_dynamic',
					'id'    => '',
				],
				'choices'           => [
					'administrator' => 'Administrators',
					'author'        => 'Authors',
					'editor'        => 'Editors',
					'contributor'   => 'Contributors',
					'subscriber'    => 'Subscribers',
					'shop_manager'  => 'Shop_managers',
					'customer'      => 'Customers',
				],
				'default_value'     => [
					'contributor' => 'contributor',
					'subscriber'  => 'subscriber',
					'customer'    => 'customer',
				],
				'layout'            => 'vertical',
				'toggle'            => 1,
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
