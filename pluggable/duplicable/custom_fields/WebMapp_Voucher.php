<?php

$location = array(
    array(
        array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'voucher',
        ),
    ),
);


$fields = array(
        array(
            'key' => 'wm_voucher_route',
            'label' => 'Route',
            'name' => 'route',
            'type' => 'post_object',
            'instructions' => 'Enter the ROUTE corresponding to the voucher you want to activate.',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'route',
            ),
            'taxonomy' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
            'ui' => 1,
        ),
        array(
            'key' => 'wm_voucher_total_number',
            'label' => 'Total Number',
            'name' => 'total_number',
            'type' => 'range',
            'instructions' => 'Enter the total number of VOUCHER codes. The codes will be generated automatically starting from the main code of the voucher you entered in the title. If for example the main code is 18-0040 and the total number you enter in this field is 3, the following 3 codes will automatically be activated: 18-0040-01, 18-0040-02, 18-0040-03',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'min' => 1,
            'max' => 99,
            'step' => '',
            'prepend' => '',
            'append' => '',
        ),
        array(
            'key' => 'wm_voucher_expire_date',
            'label' => 'Expire date',
            'name' => 'expire_date',
            'type' => 'date_picker',
            'instructions' => 'Enter the expiry date of the voucher.',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'd/m/Y',
            'return_format' => 'd/m/Y',
            'first_day' => 1,
        ),
    );

    $args = array (
        'key' => 'group_wm_user',
        'title' => 'User WEBMAPP Voucher',
        'fields' => $fields,
        'location' => $location,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    );



$WebMapp_RegisterPagesFields = new WebMapp_RegisterFieldsGroup('voucher' ,$args,false );