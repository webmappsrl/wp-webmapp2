<?php

class WebMapp_WpmlLangSwitcher
{

    private $df_lang;
    private $curr_lang;

    function __construct()
    {
        //add_action( 'posts_selection' , array( $this , 'test222' ) );
        add_action( 'wp' , array( $this , 'frontend_init' ) , 99);


    }

    public function frontend_init()
    {
        global $wp_query;

        if (  isset( $wp_query->query['taxonomy'] ) && count( $wp_query->query ) == 1 )
        {

            $this->df_lang = apply_filters('wpml_default_language', NULL );
            $this->curr_lang = apply_filters('wpml_current_language', NULL );

            add_filter( 'icl_ls_languages', array( $this ,'edit_wpml_language_switcher' ) , 1, 1);
        }

    }


    public function edit_wpml_language_switcher( $w_active_languages )
    {
        global $sitepress, $wp_query;

        $t = $w_active_languages;

        if ( is_array( $t )  && count( $t ) > 0 )
        {
            $permalink_structure = $sitepress->get_setting( 'language_negotiation_type' );

            foreach ( $t as $lang => $settings )
            {
                if ( isset( $settings['url'] ) )
                {
                    $tax_name = $wp_query->query['taxonomy'];
                    $t[$lang]['url'] = WebMapp_Utils::get_tax_archive_link( $tax_name );

                   if ( $lang != $this->df_lang && $permalink_structure )
                   {

                       //Directory con lingue diverse
                       if ( $permalink_structure == 1 )
                       {
                           $partial_url = WebMapp_TemplatesRedirect::get_partial_tax_archive_link( $tax_name );
                           $t[$lang]['url'] = site_url() . '/' . $lang . $partial_url;
                       }
                       //Nome della lingua aggiunto come parametro
                       elseif ( $permalink_structure == 3 )
                       {
                           $tax_url = WebMapp_Utils::get_tax_archive_link( $tax_name );
                           $t[$lang]['url'] = add_query_arg( 'lang' , $lang , $tax_url );
                       }

                   }

                }
            }

        }

        return $t;

    }

}

new WebMapp_WpmlLangSwitcher();