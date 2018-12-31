<?php



   $args = array(

        'key' => 'group_5c16994489b7e',
        'title' => 'Details',
        'fields' => array(
            array(
                'key' => 'wm_comment_gallery',
                'label' => 'galleria',
                'name' => 'wm_comment_gallery',
                'type' => 'gallery',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => '',
                'max' => '',
                'insert' => 'append',
                'library' => 'uploadedTo',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'wm_comment_journey_date',
                'label' => 'data viaggio',
                'name' => 'wm_comment_journey_date',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            )
        ),

        'location' => array(
            array(
                array(
                    'param' => 'comment',
                    'operator' => '==',
                    'value' => 'all',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => ''
    );

$WebMapp_RegisterMapFieldsComments = new WebMapp_RegisterFieldsGroup( 'comment', $args );