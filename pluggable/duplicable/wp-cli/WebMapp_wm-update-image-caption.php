<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Returns all post meta of images id provided
 *
 *
 * @when after_wp_load
 */
$wm_update_image_caption = function( $args, $assoc_args )
{
    $results = new WP_Query( array( 'post_type' => 'attachment', 'posts_per_page' => -1 ,'post_status' => 'any','post_mime_type' => array('image/png','image/jpeg','image/jpg')) );
    
            $count = 1;
            foreach ( $results->posts as $post ) {
                $title = $post->post_title;
                $caption = $post->post_excerpt;
                if (empty($caption)) {
                    $my_image_meta = array(
                        // Specify the image (ID) to be updated
                        'ID' => $post->ID,
                        // Set image Caption (Excerpt) to sanitized title
                        'post_excerpt' => $title
                        );
                        // Set the image meta excerpt
                        wp_update_post( $my_image_meta );
                    WP_CLI::success( $count .' - Updating caption of image ID # ' . $post->ID .' from value: '.$title.' to new value: ' .$caption );
                    $count ++;
                }
            }



};

WP_CLI::add_command( 'wm-update-image-caption', $wm_update_image_caption );