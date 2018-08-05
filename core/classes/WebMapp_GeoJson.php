<?php


class WebMapp_GeoJson
{
    private $id;
    private $debug_mode;
    private $current_domain;

    private $curl_url;
    private $curl_geoJson;
    public $curl_response_array = false;

    //debug environment
    public $debug_domain = 'sgt.be.webmapp.it';
    public $debug_id = 1299;//sgt track

    function __construct( $id , $term = false, $debug_mode = false )
    {
        $this->current_domain = $_SERVER['SERVER_NAME'];
        $this->id = $id;
        $this->debug_mode = $debug_mode;
        $this->curl_url = $this->build_geoJson_server_url();

        $temp = $this->getGeoJson();

        if ( $temp === false )
            trigger_error("Impossible to connect to $this->curl_url. Unable to find geoJson.",E_USER_WARNING );
        else
        {
            $this->curl_geoJson = $temp;
            $this->curl_response_array = json_decode( $temp );
            add_action( 'wp_footer' , array( $this , 'addGeoJsonInFooter' ) , 999 );
        }


    }

    public function get_php()
    {
        return $this->curl_response_array;
    }

    public function get_json()
    {
        return $this->curl_geoJson;
    }

    private function build_geoJson_server_url()
    {
        $bool = strpos( $this->current_domain , '.local' ) !== false;
        if ( $this->debug_mode || $bool )
        {
            $t = "https://api.webmapp.it/a/$this->debug_domain/geojson/$this->debug_id.geojson";
            echo "<h3 style='color:red'>" . "DEBUG MODE ACTIVE. Curl Url: " . $t . "</h3>";

        }
        else
            $t = "https://api.webmapp.it/a/$this->current_domain/geojson/$this->id.geojson";



        return $t;
    }


    protected function getGeoJson()
    {
        $url = $this->curl_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }

    public function addGeoJsonInFooter()
    {
        ob_start();
        ?>

        <script type="text/javascript">
            var geoJson_<?php echo $this->id?> = <?php echo $this->get_json()?> ;
        </script>
        <?php

        echo ob_get_clean();
    }

}