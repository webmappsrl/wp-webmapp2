<?php


class WebMapp_Utils
{

    /**
     * Todo check su path - filter
     * @param $rel_dir
     */
    static function load_dir( $rel_dir )
    {

            $files = glob( WebMapp_DIR . "/$rel_dir/*.php" );

            // Load WebMapp php files
            foreach ( (array) $files as $file )
            {
                if ( $file && strpos( $file , 'WebMapp_' ) !== false )
                {
                    require_once $file;
                }
            }
    }

    static function project_has_route()
    {
        $r = false;
        $option = get_option('webmapp_has_route');
        if ( ! empty( $option ) && $option != false )
            $r = true;
        return $r;
    }
}