(function($)
{
    var $tracks = $('div[data-name="n7webmap_route_related_track"]');
    var $activity_wrapper = $('.acf-field-wm-route-tax-activity');
    var $activity = $('#acf-wm_route_tax_activity');

    wm_get_values( $tracks );

    function wm_get_values( $this )
    {
        var $values = $this.find('.values li');
        var tracks_count = $values.length;

        if ( tracks_count > 0 )
            {
                $activity_wrapper.hide();
                $activity.find('option').remove();
            }
        else// tracks_count == 0
            {
                $activity_wrapper.show();
            }
    }

    $tracks.change(function(){
        wm_get_values( $(this) );
    });


})(jQuery);