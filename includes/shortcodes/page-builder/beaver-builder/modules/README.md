## WebMan Amplifier

### Page builder implementation: *Beaver Builder*

**Beaver Builder form fields** definitions reference:

	/**
	 * For module popup window
	 */
	$module_form = array(

		//Tab
		'field_test' => array(
			//Title
			'title'       => __( 'Fields test', 'webman-amplifier' ),
			'description' => '',
			//Sections
			'sections' => array(

				//Section
				'wm' => array(
					'title'  => 'WebMan Custom',
					//Sections doesn't contain 'description' parameter.
					'fields' => array(

						/**
						 * IMPORTANT WARNING:
						 *
						 * You can not declare a field with a name/ID of 'type'.
						 * @link  https://wordpress.org/support/topic/bug-module-not-rendering-when-type-setting-used
						 */

						'wm_radio' => array(
							'type' => 'wm_radio',
							//description
							'label'       => __( 'WM_Radio field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'options'    => array(
									'fa fa-cog' => 'fa fa-cog',
									'fa fa-camera' => 'fa fa-camera',
									'fa fa-pencil' => 'fa fa-pencil',
								),
							'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
							'hide_radio' => true,
							'inline'     => true,
							//preview
							'preview' => array( 'type' => 'none' ), //Defaults to array( 'type' => 'refresh' ).
						), // /wm_radio

					), // /fields
				), // /section

				//Section
				'text' => array(
					'title'  => 'Texts',
					'fields' => array(

						'wm_code' => array(
							'type' => 'code',
							//description
							'label'       => __( 'Code field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '...some default value',
							//type specific
							'class'  => '',
							'editor' => 'html',
							'rows'   => 10,
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_code

						'wm_suggest' => array(
							'type' => 'suggest',
							//description
							'label'       => __( 'Suggest field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '...some default value',
							//type specific
							'action'      => '',
							'class'       => '',
							'data'        => '',
							'placeholder' => 'Start typing...',
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_suggest

						'wm_text' => array(
							'type' => 'text',
							//description
							'label'       => __( 'Text field', 'webman-amplifier' ),
							'description' => 'px',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '...some default value',
							//type specific
							'class'       => '',
							'maxlength'   => 20,
							'placeholder' => 'Placeholder text',
							'size'        => 22,
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_text

						'wm_textarea' => array(
							'type' => 'textarea',
							//description
							'label'       => __( 'Textarea field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '...some default value',
							//type specific
							'class'       => '',
							'placeholder' => 'Placeholder text',
							'rows'        => 3,
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_textarea

					), // /fields
				), // /section

				//Section
				'selects' => array(
					'title'  => 'Selects',
					'fields' => array(

						'wm_color' => array(
							'type' => 'color',
							//description
							'label'       => __( 'Color field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => 'ffcc00',
							//type specific
							'class'      => '',
							'show_reset' => true,
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_color

						'wm_icon' => array(
							'type' => 'icon',
							//description
							'label'       => __( 'Icon field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'class'       => '',
							'show_remove' => true,
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_icon

						'wm_layout' => array(
							'type' => 'layout',
							//description
							'label'       => __( 'Layout field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'options' => array(
								'value1' => 'http://placehold.it/50/eee/666',
								'value2' => 'http://placehold.it/50/ddd/666',
								'value3' => 'http://placehold.it/50/ccc/666',
								'value4' => 'http://placehold.it/50/bbb/666',
							),
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_layout

						'wm_link' => array(
							'type' => 'link',
							//description
							'label'       => __( 'Link field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific - none
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_link

						'wm_multiple-photos' => array(
							'type' => 'multiple-photos',
							//description
							'label'       => __( 'Multiple photos field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'class' => '',
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_multiple-photos

						'wm_photo-sizes' => array(
							'type' => 'photo-sizes',
							//description
							'label'       => __( 'Photo sizes field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific - none
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_photo-sizes

						'wm_photo' => array(
							'type' => 'photo',
							//description
							'label'       => __( 'Photo field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'class' => '',
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_photo

						'wm_post-type' => array(
							'type' => 'post-type',
							//description
							'label'       => __( 'Post type field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'class' => '',
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_post-type

						'wm_select' => array(
							'type' => 'select',
							//description
							'label'       => __( 'Select field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'class'   => '',
							'toggle'  => '',
							'hide'    => '',
							'trigger' => '',
							'options' => array(
								'value1' => 'Value 1',
								'value2' => 'Value 2',
								'value3' => 'Value 3',
								'value4' => 'Value 4',
							),
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_select

						'wm_video' => array(
							'type' => 'video',
							//description
							'label'       => __( 'Video field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'class' => '',
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_video

					), // /fields
				), // /section

				//Section
				'others' => array(
					'title'  => 'Others',
					'fields' => array(

						'wm_form' => array(
							'type' => 'form',
							//description
							'label'       => __( 'Form field', 'webman-amplifier' ),
							'description' => '',
							'help'        => __( 'Field help text', 'webman-amplifier' ),
							//default
							'default' => '',
							//type specific
							'form'         => 'wm_popup_' . 'MODULE_SLUG', //See FLBuilder::register_settings_form(). Basically, a popup window name/ID.
							'preview_text' => 'popup_window_form_field_name', //Do not forget to set this up! It is being used to distinguish between repeater (multiple) fields.
							//multiple
							'multiple' => true, //This can be declared for any field, theoretically.
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /wm_form

					), // /fields
				), // /section

			), // /sections
		), // /tab

	); // /$module_form

	FLBuilder::register_module( 'WM_BB_Module_' . 'MODULE_NAME', $module_form );



	/**
	 * For items/children popup window
	 */
	$module_form_popup = array(

		//Title
		'title' => __( 'Popup window title', 'webman-amplifier' ),
		//Tabs
		'tabs' => array(

			//Tab
			...

		), // /tabs

	); // /$module_form_popup

	FLBuilder::register_settings_form( 'wm_popup_' . 'MODULE_SLUG', $module_form_popup );