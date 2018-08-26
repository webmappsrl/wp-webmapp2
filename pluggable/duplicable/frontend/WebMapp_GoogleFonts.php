<?php

/**
 * fonts already loaded in class

$default_fonts = array(
    array(
        'name' => 'Merriweather',
        'weights' => array( 400 , 700 )
    ),
    array(
        'name' => 'Montserrat',
        'weights' => array( 500 )
    )
);
 *
 * you can add other google fonts using $fonts parameter
 *  */

$fonts = array();//load only default fonts

new WebMapp_LoadGoogleFonts($fonts );