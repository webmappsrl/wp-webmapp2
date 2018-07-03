<?php


function my_myme_types($mime_types) {

    $mime_types['gpx'] = 'application/gpx+xml'; //Adding svg extension

    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types');