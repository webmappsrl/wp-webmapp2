<?php


class WebMapp_GeoJson
{
    public $id;
    public $post_type;

    private $current_domain;

    private $curl_urls = array();
    private $curl_geoJsons = array();
    private $curl_geoJsons_php = array();


    function __construct( $id , $term = false )
    {
        $this->current_domain = $_SERVER['SERVER_NAME'];
        $this->id = $id;
        $this->post_type = get_post_type( $this->id );

        $this->curl_urls = $this->build_geoJson_server_url();

        $this->getGeoJsons();

    }

    public function build_geoJson_server_url()
    {
        $t = [];
        $url =  get_option('webmapp_map_apiUrl')."/geojson/$this->id.geojson";
        $t["geojson_{$this->id}"] = $url;
        //todo add filter here
        return $t;
    }


    protected function getGeoJsons()
    {

        foreach( $this->curl_urls as $varname => $url )
        {
            $temp = $this->getGeoJson_curl( $url );

            if ( $temp === false )
                trigger_error("Impossible to connect to $url. Unable to find geoJson.",E_USER_WARNING );
            else
            {
                $this->curl_geoJsons[$varname] = $temp;
                $this->curl_geoJsons_php[$varname] = json_decode( $temp );

            }
        }

        add_action( 'wp_footer' , array( $this , 'addGeoJsonInFooter' ) , 999 );

    }

    protected function getGeoJson_curl( $url )
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ( $httpcode >= 200 && $httpcode < 300 ) ? $data : false;
    }

    public function addGeoJsonInFooter()
    {
        ob_start();
        ?>
        <script type="text/javascript">

            <?php
                foreach ( $this->curl_geoJsons as $varname => $json )
                {
                    echo "var $varname = $json;";
                }
            ?>
        </script>
        <?php

        echo ob_get_clean();
    }

    /**
     * get helpers
     */
    public function get_php( $varname )
    {
        return isset( $this->curl_geoJsons_php['geojson_'.$varname] ) ? $this->curl_geoJsons_php['geojson_'.$varname] : array();
    }

    public function get_json( $varname )
    {
        return isset( $this->curl_geoJsons['geojson_'.$varname] ) ? $this->curl_geoJsons['geojson_'.$varname] : '{}';
    }


}