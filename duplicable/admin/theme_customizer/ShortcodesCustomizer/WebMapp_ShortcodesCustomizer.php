<?php

$settings = array(
    'webmapp_shortcodes_color1' => array(
        'label' => 'Color 1',
        'default' => '#466434',
        'description' => "<ul><li><p>AnyPost<ul><li>Main tax background</li><li>Post title color</li><li>Other taxs icons</li></ul></p></li></ul>",
    ),
    'webmapp_shortcodes_color2' => array(
        'label' => 'Color 2',
        'default' => '#2D2D37'
    ),
    'webmapp_shortcodes_color3' => array(
        'label' => 'Color 3',
        'default' => '#96969B'
    ),
    'webmapp_shortcodes_font1' => array(
        'label' => 'Font 1',
        'default' => 'Merriweather Bold'
    ),
    'webmapp_shortcodes_font2' => array(
        'label' => 'Font 2',
        'default' => 'Montserrat Medium'
    ),
    'webmapp_shortcodes_font3' => array(
        'label' => 'Font 3',
        'default' => 'Roboto Regular'
    )
);

$section_description = __('Allows you to customize some example settings for MyTheme.', WebMapp_TEXTDOMAIN );
$js_url = WebMapp_URL . 'duplicable/admin/theme_customizer/ShortcodesCustomizer/shortcodes_customizer.js';//live customizer
$WebMapp_ShortcodeCustomizer = new WebMapp_ThemeCustomizer( 'webmapp_shortcodes_customizer' , 'Webmapp Shortcodes Style' ,$section_description ,$settings, $js_url );

/**
 * Prints css in head ( frontend, on live site )
 */

/**
 * ANY POST SHORTCODE
 */

//Colors

//color 1
$WebMapp_ShortcodeCustomizer->generate_css('div.webmapp_post_terms .webmapp_single_term a i, .webmapp_shortcode_any_post .webmapp_post-title h2 a', 'color', 'webmapp_shortcodes_color1' );//2 in 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_main_tax i, .pagination_link_wrapper.active .pagination_link', 'background-color', 'webmapp_shortcodes_color1' );//2 in 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_main_tax, .pagination_link_wrapper .pagination_link', 'background-color', 'webmapp_shortcodes_color1' ,'','7F' );//2 in 1

//color 3
$WebMapp_ShortcodeCustomizer->generate_css('div.webmapp_post_terms .webmapp_single_term a', 'color', 'webmapp_shortcodes_color3' );

//Fonts

//font 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_shortcode_any_post .webmapp_post-title h2 a', 'font-family', 'webmapp_shortcodes_font1' );
//font 2
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp_single_term a span', 'font-family', 'webmapp_shortcodes_font2' );

/**
 * ANY TERM SHORTCODE
 */

//Colors

//color 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-list-terms ul.webmapp-terms li a', 'color', 'webmapp_shortcodes_color1' );
//color 2
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-title', 'color', 'webmapp_shortcodes_color2' );
//color 3
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-subtitle', 'color', 'webmapp_shortcodes_color3' );

//Fonts

//font 1
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-title', 'font-family', 'webmapp_shortcodes_font1' );
//font 2
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-list-terms ul.webmapp-terms li a', 'font-family', 'webmapp_shortcodes_font2' );
//font 3
$WebMapp_ShortcodeCustomizer->generate_css('.webmapp-any-terms-subtitle', 'font-family', 'webmapp_shortcodes_font3' );



