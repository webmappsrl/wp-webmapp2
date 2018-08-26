<?php


class WebMapp_LoadGoogleFonts
{
    public $default_fonts = array(
        array(
            'name' => 'Merriweather',
            'weights' => array( 400 , 700 )
        ),
        array(
            'name' => 'Montserrat',
            'weights' => array( 500 )
        )
    );

    public $fonts;
    private $assetEnqueuer;

    function __construct( $fonts = array() )
    {
        $this->fonts = array_merge( $fonts , $this->default_fonts );

        add_action( 'wp_loaded' , array( $this ,  'enqueue_font' ) );
    }

    public function enqueue_font()
    {
        $base_url = 'https://fonts.googleapis.com/css?family=';
        $query_string = $this->build_fonts_query();

        if ( ! empty( $query_string ) ):
            $args = array(
                "webmapp_google_fonts" => array(
                    'src' => $base_url . $query_string
                )
            );
            $this->assetEnqueuer = new WebMapp_AssetEnqueuer( $args , 'wp' , 'style' );
        endif;

    }



    private function build_fonts_query()
    {
        $fonts = $this->fonts;
        $query_string = '';

        foreach ( $fonts as $font )
        {
            if( isset( $font['name'] ) )
            {
                $query_string .= str_replace(' ' , '+', $font['name']);
                if ( isset( $font['weights'] ) )
                    $query_string .= ':' . implode(',',$font['weights'] ) ;
                $query_string .= '|';
            }
        }

        if ( ! empty( $query_string ) )
            $query_string = substr( $query_string , 0,-1);

        return $query_string;
    }
}