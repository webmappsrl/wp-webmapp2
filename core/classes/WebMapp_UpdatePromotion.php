<?php
/**
 * User: Alessio Piccioli
 * Date: 10/11/2019
 * Time: 11:00
 */

class WebMapp_UpdatePromotion
{

    public static function run($wm_cli=false){
        if($wm_cli) WP_CLI::line("WebMapp_UpdatePromotion::run() starting");
        $today = date('Y-m-d');
        $today_ts = strtotime($today);
        if($wm_cli) WP_CLI::line("Today is $today ($today_ts)\n");
        $max_all = 0;
        $max_all_name = '';
        $specific = array();

        if($wm_cli) WP_CLI::line("STEP 1: Build update array based on promotion dates and today\n");
        $args = array('post_type' => 'promotion','posts_per_page' => -1,);
        $promotion_array = get_posts($args);
        if (!empty($promotion_array)) {
            foreach($promotion_array as $promotion) {
                $active = false;
                $f = get_fields($promotion->ID);
                // print_r($f);
                if(isset($f['dates']) && is_array($f['dates']) && count($f['dates'])>0) {
                    // Check if today is active
                    foreach($f['dates'] as $date) {
                        if ($today_ts==strtotime($date['date'])) {
                            $active=true;
                        }
                    }
                }
                if(!$active && isset($f['periods']) && is_array($f['periods']) && count($f['periods'])>0) {
                    foreach($f['periods'] as $p) {
                        if($today_ts >= strtotime($p['start_date']) && $today_ts <= strtotime($p['stop_date'])) {
                            $active=true;
                        }
                    }
                }
                $value = $f['value'];
                if($f['all_routes']) {
                    if($value>$max_all) {
                        $max_all=$value;
                        $max_all_name=$promotion->post_title;
                    }
                } else {
                    if(isset($f['routes']) && is_array($f['routes']) && count($f['routes'])>0) {
                        foreach($f['routes'] as $route_id) {
                            if(isset($specific[$route_id])) {
                                if($value > $specific[$route_id] ) {
                                    $specific[$route_id]['value'] = $value;
                                    $specific[$route_id]['name'] = $promotion->post_title;
                                }
                            } else {
                                $specific[$route_id]['value'] = $value;
                                $specific[$route_id]['name'] = $promotion->post_title;
                            }
                        }
                    }
                }
                $active_val = $active ? 'ACTIVE' : 'INACTIVE';
                if ($wm_cli) {WP_CLI::line("Checking Promotion: $promotion->post_title (ID:$promotion->ID) $active_val - V:$value MAX:$max_all");}
            }
        }

        if($wm_cli) WP_CLI::line("\n\nSTEP 2: Uodate all route according to promotion\n");
        $args = array('post_type' => 'route','posts_per_page' => -1,);
        $routes_array = get_posts($args);
        if (!empty($routes_array))
        {
            foreach ($routes_array as $route)
            {
                $val = 0; $name='';
                if($max_all>0) {
                    if(isset($specific[$route->ID]) && $specific[$route->ID]['value'] > $max_all) {
                        $val=$specific[$route->ID]['value'];
                        $name=$specific[$route->ID]['name'];
                    } else {
                        $val = $max_all;
                        $name = $max_all_name;
                    }
                } else {
                    if(isset($specific[$route->ID])) {
                        $val=$specific[$route->ID]['value'];
                        $name=$specific[$route->ID]['name'];
                    }
                }
                update_post_meta($route->ID,'promotion_value',$val);
                update_post_meta($route->ID,'promotion_name',$name);
                if ($wm_cli) {WP_CLI::line("Route: $route->post_title (ID:$route->ID) - Val: $val Name:$name");}
            }
        }
    }
}