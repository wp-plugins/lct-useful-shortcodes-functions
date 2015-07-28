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


	acf_add_local_field_group( [
		'key'                   => 'group_55b7ee000c834',
		'title'                 => 'Shortcodes',      //TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE----TITLE
		'fields'                => [
			[
				'key'               => 'field_55b7ee96f830d',
				'label'             => 'Copyright',
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'placement'         => 'top',
				'endpoint'          => 0,
			],
			[
				'key'               => 'field_55b7eea6f830e',
				'label'             => 'Copyright Shortcode Instructions',
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
				'message'           => 'Place this short code where you want the copyright text to go: <strong>[lct_copyright]</strong>',
				'esc_html'          => 0,
			],
			[
				'key'               => 'field_55b7f1dfd8450',
				'label'             => 'Use this shortcode?',
				'name'              => 'lct:::sc::use_this_shortcode',
				'type'              => 'checkbox',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => 'hide_label',
					'id'    => '',
				],
				'choices'           => [
					1 => 'Use this shortcode',
				],
				'default_value'     => [
				],
				'layout'            => 'vertical',
				'toggle'            => 0,
			],
			[
				'key'               => 'field_55b7f2ed35d96',
				'label'             => 'Title',
				'name'              => 'lct:::sc::title',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => 75,
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => 'Company ABC, Inc.',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
				'readonly'          => 0,
				'disabled'          => 0,
			],
			[
				'key'               => 'field_55b7f4214369d',
				'label'             => 'Link the Title',
				'name'              => 'lct:::sc::link_title',
				'type'              => 'checkbox',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => 25,
					'class' => 'hide_label',
					'id'    => '',
				],
				'choices'           => [
					1 => 'Link the Title',
				],
				'default_value'     => [
				],
				'layout'            => 'vertical',
				'toggle'            => 0,
			],
			[
				'key'               => 'field_55b7f4504369e',
				'label'             => 'Title Link',
				'name'              => 'lct:::sc::title_link',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'field'    => 'field_55b7f4214369d',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => 50,
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => 'default is: /',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
				'readonly'          => 0,
				'disabled'          => 0,
			],
			[
				'key'               => 'field_55b806ddcad96',
				'label'             => 'Open in New Tab',
				'name'              => 'lct:::sc::title_link_blank',
				'type'              => 'checkbox',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'field'    => 'field_55b7f4214369d',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => 25,
					'class' => 'hide_label',
					'id'    => '',
				],
				'choices'           => [
					1 => 'Open in New Tab',
				],
				'default_value'     => [
				],
				'layout'            => 'vertical',
				'toggle'            => 0,
			],
			[
				'key'               => 'field_55b80590aa4c1',
				'label'             => 'Disable Link on Posts',
				'name'              => 'lct:::sc::no_single_link',
				'type'              => 'checkbox',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'field'    => 'field_55b7f4214369d',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => 25,
					'class' => 'hide_label',
					'id'    => '',
				],
				'choices'           => [
					1 => 'Disable Link on Posts',
				],
				'default_value'     => [
				],
				'layout'            => 'vertical',
				'toggle'            => 0,
			],
			[
				'key'               => 'field_55b7f33935d98',
				'label'             => 'Builder Plug',
				'name'              => 'lct:::sc::builder_plug',
				'type'              => 'textarea',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => 'Web Designs, Inc.',
				'maxlength'         => '',
				'rows'              => '',
				'new_lines'         => '',
				'readonly'          => 0,
				'disabled'          => 0,
			],
			[
				'key'               => 'field_55b7f33835d97',
				'label'             => 'XML Sitemap URL',
				'name'              => 'lct:::sc::xml',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '/sitemap_index.xml',
				'placeholder'       => '/sitemap_index.xml',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
				'readonly'          => 0,
				'disabled'          => 0,
			],
			[
				'key'               => 'field_55b7f04b5c23b',
				'label'             => 'Copyright Layout Template',
				'name'              => 'lct:::sc::copyright_layout',
				'type'              => 'text',
				'instructions'      => '<strong>Layout Variables:</strong>
										<ul>
										<li>{copy_symbol} = &copy;</li>
										<li>{year} = the current year</li>
										<li>{title} = the title field entered above</li>
										<li>{builder_plug} = the builder_plug entered above</li>
										<li>{XML_sitemap} = link to the above sitemap URL</li>
										</ul>

										Let me know if you need other variables and I can add them for you.',
				'required'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_55b7f1dfd8450',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => 'Copyright {copy_symbol} {year} {title} | {builder_plug} | {XML_sitemap}',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
				'readonly'          => 0,
				'disabled'          => 0,
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
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
	] );

endif;
