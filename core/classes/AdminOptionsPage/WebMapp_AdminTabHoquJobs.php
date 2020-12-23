<?php
function AdminTabHoquJobs () {
    
    ?>
    <div class="wrap">
            <div class="wm-jobs-relod-section">
                <p class="wm-jobs-relod-text-big"><?php echo __("List of the last 100 jobs per status processed by Hoqu.","webmap_net7") ?></p>
                <p class="wm-jobs-relod-text-light"><?php echo __("Click to get the latest results.","webmap_net7") ?></p>
                <button type="submit" id="hoqu-jobs-request" class="button-primary" value="Reload again"><?php echo __("Reload","webmap_net7") ?></button>
            </div>
        <div id="hoqu-jobs-get-result">
        </div>
    </div>
    <?php

}


// creates ajax function in admin footer of webmapp page
function wm_hoqu_jobs_request_footer() {
    ?>
    <script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            
            $( "#hoqu-jobs-request" ).on( "click", function() {
                var data = {
                    'action': 'wm_hoqu_jobs_request',
                };
                $.ajax({
                    url: ajaxurl,
                    type : 'post',
                    data: data,
                    beforeSend: function(){
                    },
                    success : function( response ) {
                    },
                    complete:function(response){
                        // console.log(response.responseText);
                        var activeTab = 0;
                        try {
                            activeTab = $('#tabs').tabs("option", "active");
                        } catch (e) {
                        }
                        $('#hoqu-jobs-get-result').html(response.responseText);
                        $( "#tabs" ).tabs();
                        $( "#tabs" ).tabs("option", "active", activeTab );
                    }
                });
            })
            $( '#hoqu-jobs-request' ).click();
        });
    })(jQuery);	
    </script>
    <?php
            
    }
// Adds JS function only in webmapp admin page ($GLOBALS['hook_suffix'];)
add_action('admin_footer-toplevel_page_webmap_netseven', 'wm_hoqu_jobs_request_footer');


function wm_admin_css_load() {
    if ( 'toplevel_page_webmap_netseven' == $GLOBALS['hook_suffix']) {
        wp_enqueue_style('style-jobs', WebMapp_ASSETS .'css/style-jobs.css');
        wp_enqueue_style('jqeury-ui-tabs-style', 'https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css');
        wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'));
    }
}
add_action('admin_enqueue_scripts', 'wm_admin_css_load');

// action that process ajax call : wm_hoqu_jobs_request() to update Hoqu jobs in admin page
add_action( 'wp_ajax_wm_hoqu_jobs_request', 'wm_hoqu_jobs_request' );
function wm_hoqu_jobs_request(){
    $home_url = wm_create_clean_home_url();
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_url = get_option("webmapp_hoqu_baseurl");
    if (strpos($hoqu_url, 'staging')) {
        $hoqu_api_url = 'https://hoqustaging.webmapp.it/api/jobsByInstance/'.$home_url;
    } else {
        $hoqu_api_url = 'https://hoqu.webmapp.it/api/jobsByInstance/'.$home_url;
    }

    $response = wp_remote_post(
        "$hoqu_api_url",
        array(
            'method'      => 'GET',
            'timeout'     => 20,
            'redirection' => 2,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(
                'Content-Type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
                'Authorization' => "Bearer $hoqu_token"                
            ),
            'cookies'     => array()
        )
    );

    // error_log(print_r($requestJson), print_r($response));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Something went wrong: $error_message");
    } 
    else {
        $response = json_decode(wp_remote_retrieve_body($response), true);

        $html = create_content_jobs($response);
        
        echo $html;
    }
    wp_die();
}



function create_content_jobs ($response) {
    ob_start();
    $html ='';

    ?>
        <div id="tabs">
            <ul>
                <?php foreach ($response as $k => $v) { ?>
                    <li class="hoqu-jobs-tab-li-<?php echo $k ?>"><a href="#tabs-<?php echo $k ?>"><?php echo $k ?></a></li>
                <?php  } ?>
            </ul>
                <?php foreach ($response as $k => $v) { ?>
                    <div id="tabs-<?php echo $k ?>">
                        <?php if (empty($v)) { ?>
                            <p><?php echo __("No available job","webmap_net7"); ?></p>
                        <?php } else {  ?>
                            <div class="job-item-row tabs-header">
                                <div class="job-item-cell"><strong><?php echo __("Hoqu ID","webmap_net7") ?></strong></div>
                                <div class="job-item-cell"><strong><?php echo __("Job name","webmap_net7")?></strong></div>
                                <div class="job-item-cell"><strong><?php echo __("Parameters","webmap_net7")?></strong></div>
                                <div class="job-item-cell"><strong><?php echo __("Status","webmap_net7")?></strong></div>
                                <div class="job-item-cell"><strong><?php echo __("Create date","webmap_net7")?></strong></div>
                                <div class="job-item-cell"><strong><?php echo __("Update date","webmap_net7")?></strong></div>
                            </div> 
                            <?php foreach ($v as $i) {?>
                                <div class="job-item-row tabs-body">
                                    <div class="job-item-cell"><?php echo $i['id']?></div>
                                    <div class="job-item-cell"><?php echo $i['job']?></div>
                                    <div class="job-item-cell"><?php echo $i['parameters']?></div>
                                    <div class="job-item-cell"><?php echo $i['process_status']?></div>
                                    <div class="job-item-cell"><?php echo date('Y-m-d H:i:s', strtotime($i['created_at']))?></div>
                                    <div class="job-item-cell"><?php echo date('Y-m-d H:i:s', strtotime($i['updated_at']))?></div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php  } ?>
        </div>
        <?php

    
    return ob_get_clean();
}