<?php

$settings_general = array(

    'webmapp_customizer_general_color1' => array(
        'label' => 'Color 1',
        'default' => '#466434',
        'description' => "",
        'css_properties' => array(
            'color',
            'background-color'
        )
    ),

    'webmapp_customizer_general_color3' => array(
        'label' => 'Color 3',
        'default' => '#96969B',
        'css_properties' => array(
            'color'
        )
    ),

    'webmapp_customizer_general_font1' => array(
        'label' => 'Font 1',
        'default' => 'Merriweather',
        'css_properties' => array(
            'font-family'
        )

    ),
    'webmapp_customizer_general_font2' => array(
        'label' => 'Font 2',
        'default' => 'Montserrat',
        'css_properties' => array(
            'font-family'
        )
    ),
    'webmapp_customizer_general_font3' => array(
        'label' => 'Font 3',
        'default' => 'Montserrat',
        'css_properties' => array(
            'font-family'
        )
    ),
    'webmapp_customizer_general_size5' => array(
        'label' => 'Font Size 5',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),
    'webmapp_customizer_general_size6' => array(
        'label' => 'Font Size 6',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),
    'webmapp_customizer_general_size7' => array(
        'label' => 'Font Size 7',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),
    'webmapp_customizer_general_size8' => array(
        'label' => 'Font Size 8',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),

);
$section_general_description = __('Allows you to customize general style.', WebMapp_TEXTDOMAIN );



$settings_anyterm = array(
    'webmapp_customizer_anyterm_size1' => array(
        'label' => 'Font Size 1',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),

);
$section_anyterm_description = __('Allows you to customize AnyTerm shortcode style.', WebMapp_TEXTDOMAIN );



$settings_anypost = array(
    'webmapp_customizer_anypost_size2' => array(
        'label' => 'Font Size 2',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),

);
$section_anypost_description = __('Allows you to customize AnyPost shortcode style.', WebMapp_TEXTDOMAIN );


$settings_singlepost = array(
    'webmapp_customizer_singlepost_size9' => array(
        'label' => 'Font Size 9',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),
    'webmapp_customizer_singlepost_size10' => array(
        'label' => 'Font Size 10',
        'default' => '14px',
        'css_properties' => array(
            'font-size'
        )
    ),

);
$section_singlepost_description = __('Allows you to customize Single Post template style.', WebMapp_TEXTDOMAIN );




$theme_customizer_url = WebMapp_URL . 'pluggable/duplicable/admin/theme_customizer/js/';
$sections = array(
    array(
        'id' => 'webmapp_customizer_general',
        'js_url' => $theme_customizer_url . 'general_customizer.js',//live customizer,
        'title' => 'WebMapp General',
        'settings' => $settings_general,
        'description' => $section_general_description
    ),
    array(
        'id' => 'webmapp_customizer_anyterm',
        'js_url' => false,//live customizer,
        'title' => 'WebMapp AnyTerm',
        'settings' => $settings_anyterm,
        'description' => $section_anyterm_description

    ),
    array(
        'id' => 'webmapp_customizer_anypost',
        'js_url' => false,//live customizer,
        'title' => 'WebMapp AnyPost',
        'settings' => $settings_anypost,
        'description' => $section_anypost_description
    ),
    array(
        'id' => 'webmapp_customizer_singlepost',
        'js_url' => false,//live customizer,
        'title' => 'WebMapp Single Post',
        'settings' => $settings_singlepost,
        'description' => $section_singlepost_description

    )
);

$WebMapp_ThemeCustomizer = new WebMapp_ThemeCustomizer($sections );//inizialize webmapp theme customizer sections

$WebMapp_ThemeCustomizer->wm_sections[0]->generate_css(
    '.webmapp_customizer_general_color1-background-color-brightness',
    'background-color',
    'webmapp_customizer_general_color1',
    '',
    '7A'
);

/**
 * Prints css in head ( frontend, on live site )
 */

/**
 * ANY POST SHORTCODE


//Colors

//color 1
$WebMapp_ShortcodeCustomizer->generate_css('div.webmapp_post_terms .webmapp_single_term a i, .webmapp_shortcode_any_post .webmapp_post-title h2 a', 'color', 'webmapp_customizer_general_color1' );//2 in 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_main_tax i, .pagination_link_wrapper.active .pagination_link', 'background-color', 'webmapp_customizer_general_color1' );//2 in 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_main_tax, .pagination_link_wrapper .pagination_link', 'background-color', 'webmapp_customizer_general_color1' ,'','7F' );//2 in 1

//color 3
$WebMapp_ShortcodeCustomizer->generate_css('div.webmapp_post_terms .webmapp_single_term a', 'color', 'webmapp_customizer_general_color3' );

//Fonts

//font 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_shortcode_any_post .webmapp_post-title h2 a', 'font-family', 'webmapp_customizer_general_font1' );
//font 2
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_single_term a span', 'font-family', 'webmapp_customizer_general_font2' );

/**
 * ANY TERM SHORTCODE
 *

//Colors

//color 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-list-terms ul.webmapp-terms li a', 'color', 'webmapp_customizer_general_color1' );
//color 2
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-title', 'color', 'webmapp_customizer_general_color2' );
//color 3
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-subtitle', 'color', 'webmapp_customizer_general_color3' );

//Fonts

//font 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-title', 'font-family', 'webmapp_customizer_general_font1' );
//font 2
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-list-terms ul.webmapp-terms li a', 'font-family', 'webmapp_customizer_general_font2' );
//font 3
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-subtitle', 'font-family', 'webmapp_customizer_general_font3' );

*/
