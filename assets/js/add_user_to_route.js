jQuery(document).ready(function($) {

    var user_id = getUrlVars()['add_user'];

    $.post({
        url: webmapp_config.ajax_url,
        type: 'POST',
        data: {'action': 'add_user_to_route', 'user_id': user_id},
        cache: false,
        dataType: 'json',
        success: function(data) {
            console.log(data);

            var html = '<li class="select2-search-choice"><div>' + data.user_login + '</div>';
            html += '<a href="#" class="select2-search-choice-close" tabindex="-1"></a>';
            html += '<input type="hidden" class="select2-search-choice-hidden" name="acf[n7webmap_route_users][]" value="' + data.ID + '"></li>';
            $('#s2id_acf-n7webmap_route_users-input ul.select2-choices').append(html);

        }
    });
});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
        vars[key] = value;
    });
    return vars;
}