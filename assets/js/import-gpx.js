/* FIX FOR A BUG OF WPML FLUGIN */
jQuery( document ).ajaxComplete(function( event, xhr, settings ) {
    if (typeof(settings.data.get) != 'undefined'
        && (settings.data.get('action') === 'webmapp_file_upload'
        || settings.data.get('action') === 'webmapp_kml_upload'
        || settings.data.get('action') === 'add_user_to_route' )
    ) {
    event.stopImmediatePropagation();
    return false;
  }
  
});



 jQuery(document).ready(function() {
  

   jQuery('#kml-upload-file').on('change', prepareKmlUpload);    
   
  function prepareKmlUpload(event){    
      var file = event.target.files;
      var type  = jQuery(this).data("type");
      var data = new FormData();
      data.append("action", "webmapp_kml_upload");
      data.append("post-type", type);
      jQuery.each(file, function(key, value)
      {
      data.append("webmapp_file_upload", value);
      });
      
      jQuery(".upload-kml .loader").removeClass("hidden-loader");
      jQuery("#create_obj_from_kml #preview-import").empty();
      jQuery('body').off("submit", "#create_obj_from_kml", handleImportKlm);
      jQuery.ajax({
          url: webmapp_config.ajax_url,
          type: 'POST',
          data: data,
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request      
          success: function(data) {
            jQuery(".upload-kml .loader").addClass("hidden-loader");            
            jQuery('#create_obj_from_kml #preview-import').append("<h3>Preview of import</h3>");            
            if(data["poi"].length > 0){
              jQuery('#create_obj_from_kml #preview-import').append("<table class='acf-table'></table>");
              jQuery('#create_obj_from_kml #preview-import table').append("<thead><tr><th>OSM</th><th>Name</th><th>Desc</th><th>Categories <a href='#' title='add POI categories' class='dashicons dashicons-plus-alt add-poi-cat'><input type='hidden' id='massive_selected_cat'></th><th>Import POI <input type='checkbox' name='check_all_rows' checked value=''></th></tr></thead>");
              
              data["poi"].forEach(function(entry, index){
                jQuery('#create_obj_from_kml #preview-import table').append("<tr><td><a href='#' class='osm-dialog' data-lat='"+entry["lat"]+"' data-lon='"+entry["lon"]+"'><i class='fa fa-globe' aria-hidden='true'></i></a></td>"+
                        "<td> <input type='text' name='object_name' disabled value='"+entry["name"]+"'><button type='button' class='button button-small hide-if-no-js enable-poi-edit' aria-label='Edit name'>Edit</button> </td><td>"+entry["desc"]+"</td><td class='poi_cat_cell'><a href='#' title='edit POI categories' class='dashicons dashicons-edit edit-poi-cat' data-poi='"+index+"'></a></td><td><input type='checkbox' name='poi_to_import' checked value='"+index+"'></td></tr>")
              })
            }
            jQuery('#create_obj_from_kml #preview-import').prepend("<br><input type='submit' class='acf-button button button-primary' value='Import "+type+"'>" );
            jQuery('#create_obj_from_kml #preview-import').append("<br><input type='submit' class='acf-button button button-primary' value='Import "+type+"'>" );
            
            jQuery('body').on("submit", "#create_obj_from_kml", data, handleImportKlm);
          }

	});
    }
    
    
    jQuery('#gpx-upload-file').on('change', prepareUpload);
    
    
    function prepareUpload(event){
      var file = event.target.files;
      var parent = jQuery("#" + event.target.id).parent();
      
      var data = new FormData();
      data.append("action", "webmapp_file_upload");
      
      jQuery.each(file, function(key, value)
      {
      data.append("webmapp_file_upload", value);
      });
      
      jQuery(".acf-field-parse-gpx .loader").removeClass("hidden-loader");
      jQuery("#webmapp-gpx-import input[type=submit]").remove();
      jQuery(".acf-field-parse-gpx #track-import-preview").empty();
      jQuery('.acf-field-parse-gpx').off("submit","#webmapp-gpx-import", handleImportGpx);
      
      jQuery.ajax({
          url: webmapp_config.ajax_url,
          type: 'POST',
          data: data,
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request      
          success: function(data) {
            jQuery(".acf-field-parse-gpx .loader").addClass("hidden-loader");            
             jQuery(".acf-field-parse-gpx .loader").addClass("hidden-loader");
            if(data["error"] && data["error"] != "" ){
              jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<h4>"+data["error"]+"</h4>");              
            }
            else{
              jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<h3>Preview of track before import</h3>");
              jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<h4>"+data["label"]+" <input type='text' name='track_name' disabled value='"+data["title"]+"'>" 
                                                                                      +'<button type="button" id="enable-track-name" class="button button-small hide-if-no-js" aria-label="Edit name">Edit</button>'
                                                                                      +"</h4>");

              if(data["poi"].length > 0){
                jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<table class='acf-table'></table>");
                jQuery('.acf-field-parse-gpx .acf-input #track-import-preview table').append("<thead><tr><th>OSM</th><th>Name</th><th>Desc</th><th>Categories <a href='#' title='add POI categories' class='dashicons dashicons-plus-alt add-poi-cat'><input type='hidden' id='massive_selected_cat'></th><th>Import POI <input type='checkbox' name='check_all_rows' checked value=''></th></tr></thead>");

                data["poi"].forEach(function(entry, index){
                  jQuery('.acf-field-parse-gpx .acf-input #track-import-preview table').append("<tr><td><a href='#' class='osm-dialog' data-lat='"+entry["lat"]+"' data-lon='"+entry["lon"]+"'><i class='fa fa-globe' aria-hidden='true'></i></a></td>"
                          +"<td> <input type='text' name='object_name' disabled value='"+entry["name"]+"'><button type='button' class='button button-small hide-if-no-js enable-poi-edit' aria-label='Edit name'>Edit</button> </td><td>"+entry["desc"]+"</td><td class='poi_cat_cell'><a href='#' title='edit POI categories' class='dashicons dashicons-edit edit-poi-cat' data-poi='"+index+"'></a></td><td><input type='checkbox' name='poi_to_import' checked value='"+index+"'></td></tr>")
                })
              }
              jQuery('.acf-field-parse-gpx .acf-input #webmapp-gpx-import').append("<input type='submit' class='acf-button button button-primary' value='Import track'>" );
              jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<input type='submit' class='acf-button button button-primary' id='import_track' value='Import track'>" );

              jQuery('.acf-field-parse-gpx').on("submit", "#webmapp-gpx-import", data, handleImportGpx);
              jQuery('.acf-field-parse-gpx').on("click", "#import_track",function(){
                jQuery("#webmapp-gpx-import").submit();
              })
            }
          }
	});
    }
    
  jQuery("#track-import-preview").on("click", "#enable-track-name",function (){
    jQuery('input[name="track_name"]').removeAttr('disabled');
  })
  
  jQuery("body").on("click", ".enable-poi-edit",function (){
    jQuery(this).prev("input").removeAttr('disabled');
  })  
  
  jQuery("body").on("click", ".edit-poi-cat", function(e){
    e.preventDefault();
    jQuery('#webmap_category_dialog').dialog("option", "position", { my: "right bottom",
    of: e});
   jQuery("#webmap_category_dialog input").attr("checked",false);
    jQuery("#webmap_category_dialog").dialog("open");      
    jQuery("#webmap_category_dialog #poi_el").val(jQuery(this).data("poi"));
    
    var categories = jQuery(this).parent("td").eq(0).children("span");  
    categories.each(function(){      
      jQuery("#webmap_category_dialog input[type='checkbox'][value="+jQuery(this).data("cat")+"]").attr("checked", "checked");    
    })
    
    
  })
  
  jQuery("body").on("click", ".add-poi-cat", function(e){
    e.preventDefault();
    jQuery('#webmap_category_dialog').dialog("option", "position", { my: "center bottom -10 ",
    of: e});
    jQuery("#webmap_category_dialog input").attr("checked",false);
    var selected = jQuery("#massive_selected_cat").val().split(" ");
    for (var i = 0; i < selected.length; i++){
      if(selected[i] != ""){
        jQuery("#webmap_category_dialog input[type='checkbox'][value="+selected[i]+"]").attr("checked", "checked");  
      }
    }
    
    jQuery("#webmap_category_dialog").dialog("open");      
    jQuery("#webmap_category_dialog #poi_el").val("all");       
  })
  
  jQuery(".webmap_cat_checklist input").on("change", function(){
    
      var poi = jQuery("#webmap_category_dialog #poi_el").val();         
      var check = jQuery(this);
      if(poi == "all"){        
        
        var selected = jQuery("#massive_selected_cat").val();       
        
        if(this.checked) {
        jQuery("#massive_selected_cat").val(selected + " "+ jQuery(check).val());
          jQuery(".poi_cat_cell").each(function(){
            jQuery(this).prepend("<span data-cat='"+ jQuery(check).val() +"'><span class='remove-webmap-cat'></span>"+jQuery(check).parent("label").text()+"</span>");
          })          
        }
        else{
          selected = jQuery("#massive_selected_cat").val().split(" ");
          var index = selected.indexOf(jQuery(check).val());
          if (index >= 0) {
            selected.splice( index, 1 );
            jQuery("#massive_selected_cat").val(selected.join(" "));
          }
          jQuery(".poi_cat_cell").each(function(){
            jQuery(this).find("span[data-cat="+jQuery(check).val()+"]").remove();
          })
        }         
      }
      else{
        var table_el = jQuery("*[data-poi='"+poi+"']").parent("td").eq(0);     
        if(this.checked) {
          table_el.prepend("<span data-cat='"+ jQuery(this).val() +"'><span class='remove-webmap-cat'></span>"+jQuery(this).parent("label").text()+"</span>");
        }
        else{
          jQuery(table_el).find("span[data-cat="+jQuery(this).val()+"]").remove();

        }        
      }
      
    })
   
 
  
  jQuery("#track-import-preview").on("click", ".remove-webmap-cat", function(){   
    jQuery(this).parent().remove();
  })
  
  
  
  

  
  jQuery("body").on("click", "input[name='check_all_rows']",function (){
    if(jQuery(this).attr("checked") == "checked"){
      jQuery("input[name='poi_to_import']").attr("checked","checked");
    } else {      
      jQuery("input[name='poi_to_import']").removeAttr("checked");
    }
  })  
  
  
  /* OPENSTREETMAP */  
  jQuery( "#webmap_osm_dialog" ).dialog({
    modal: true,
    autoOpen: false,
    width: '500px'
  });  
  
  jQuery("body").on("click", ".osm-dialog", function(){   
    
    var a = parseFloat(jQuery(this).data('lon'));
    a = a - 0.01; 
    var b = parseFloat(jQuery(this).data('lat'));
    b = b + 0.01;
    var c = parseFloat(jQuery(this).data('lon'));
    c = c + 0.01;
    var d = parseFloat(jQuery(this).data('lat')) ;
    d = d - 0.01;
    var bb = a+","+b+","+c+","+d;
   
    var osm_link ="http://www.openstreetmap.org/export/embed.html?bbox=|bbox|&layer=cyclemap&marker=|lat|,|lon|";
    var href_link ="https://www.openstreetmap.org/#map=15/|lat|/|lon|&layers=C";
    
    var src = osm_link.replace("|lat|", jQuery(this).data('lat')).replace("|lon|", jQuery(this).data('lon')).replace("|bbox|", bb)
    var href = href_link.replace("|lat|", jQuery(this).data('lat')).replace("|lon|", jQuery(this).data('lon'));
    
    jQuery("#webmap_osm_dialog iframe").attr("src", src);
    jQuery("#webmap_osm_dialog a").attr("href", href);
    
    jQuery("#webmap_osm_dialog").dialog("open");
  })
  
  function handleImportGpx(event) {
      event.stopPropagation(); // Stop stuff happening
      event.preventDefault(); // Totally stop stuff happening
      var data = event.data;
      data["action"] = "webmapp_create_track";
      data["post_id"] = getQueryVariable("post");
      
      if(!data["post_id"]){
        data["post_id"] = jQuery("form#post input#post_ID").val();
      }
      
      data["track_name"] = jQuery('input[name="track_name"]').val();
      data["content_type"] = jQuery("#webmapp-gpx-import").data("type");
      
      var pois = data["poi"];
      var unselected_poi = jQuery("input[name='poi_to_import']:not(:checked)");
      
      unselected_poi.each(function(){      
        pois[jQuery(this).val()] = "";
      })
      
      for (var i = 0; i < pois.length; i++){
        var row = jQuery("input[name='poi_to_import']").eq(i).parents("tr");
        var cats = "";
        jQuery(row).find("span[data-cat]").each(function(){
          cats += jQuery(this).data("cat")+",";
        })
        var p = pois[i];
        p["cats"] = cats.slice(0, -1);
        p["name"] = jQuery(row).find("input[name='object_name']").val();
        pois[i] = p;
      }
      
      data["poi"] = pois;
    
      var r = true;
      if(data["content_type"] == "track"){
        r = confirm("Il contenuto della track corrente verrà sovrascritto e alla fine dell'import la pagina verrà ricaricata e ogni contenuto non salvato verrà perso. \n Vuoi proseguire?")        
      }

      if(r === true){
        jQuery(".acf-field-parse-gpx #track-import-preview").empty();
        jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<span class='loader'><img src='"+webmapp_config.loading_gif_path+"'>"+webmapp_config.loading_text+"</span>")
        jQuery.post(
              ajaxurl, 
              data, 
              function(response) {             
                jQuery(".acf-field-parse-gpx #track-import-preview").empty();
                if (response["redirect"] != ""){
                  window.onbeforeunload = function() {};
                  window.location = response["redirect"];
                }
                jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<h3>"+webmapp_config.track_created_success+"</h3>");
  //              jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<h4>"+webmapp_config.track_created_subtitle+"</h4>");
                jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<a target='_blank' href='"+response['url']+"'>"+webmapp_config.track_created_view+"</a>");
//                if (response["json_error"] != "undefined"){
//
//                  jQuery('.acf-field-parse-gpx .acf-input #track-import-preview').append("<div>"+response['json_error']+"</div>");
//                }

                jQuery('#acf-field_5859342579a1ee .values ul').append('<li class="">'+
                                                                      '<input type="hidden" name="acf[field_5859342579a1ee][]" value="'+response['track_id']+'">'+
                                                                      '<span data-id="916" class="acf-rel-item">'+
                                                                      response['track_name']+
                                                                      '<a href="#" class="acf-icon -minus small dark" data-name="remove_item"></a>'+
                                                                      '</span></li>')

                jQuery('#acf-field_5859342579a1ee .choices ul').append('<li class="">'+
                                                                      '<input type="hidden" name="acf[field_5859342579a1ee][]" value="'+response['track_id']+'">'+
                                                                      '<span data-id="916" class="acf-rel-item">'+
                                                                      response['track_name']+
                                                                      '</span></li>')


        }, 'json')
      }
    }
    
  function handleImportKlm(event) {
      event.stopPropagation(); // Stop stuff happening
      event.preventDefault(); // Totally stop stuff happening
      var data = event.data;
      var type  = jQuery("#kml-upload-file").data("type");
      data["action"] = "webmapp_import_create_"+type;
      
      var objects = data["poi"];
      var unselected_poi = jQuery("input[name='poi_to_import']:not(:checked)");
      
      unselected_poi.each(function(){      
        objects[jQuery(this).val()] = "";
      })
      
      for (var i = 0; i < objects.length; i++){
        var row = jQuery("input[name='poi_to_import']").eq(i).parents("tr");
        var cats = "";
        jQuery(row).find("span[data-cat]").each(function(){
          cats += jQuery(this).data("cat")+",";
        })
        
        var p = objects[i];
        objects[i]["name"] = jQuery(row).find("input[name='object_name']").val();
        p["cats"] = cats.slice(0, -1);
        objects[i] = p;
      }
      
      data["objects"] = objects;
     
      jQuery("#create_obj_from_kml #preview-import").empty();
      jQuery('#create_obj_from_kml #preview-import').append("<span class='loader'><img src='"+webmapp_config.loading_gif_path+"'>"+webmapp_config.loading_text+"</span>")
      jQuery.post(
            ajaxurl, 
            data, 
            function(response) {             
              jQuery("#create_obj_from_kml #preview-import").empty();           
              jQuery('#create_obj_from_kml #preview-import').append("<h3>"+webmapp_config.import_completed+"</h3><br>");
              for (var i in response){
                jQuery('#create_obj_from_kml #preview-import').append("<a target='_blank' href='"+response[i]+"'>"+i+"</a><br>")
              }

      }, 'json')
    } // end handleImportKlm   
 
    jQuery( "#webmap_category_dialog" ).dialog({maxHeight: 300, autoOpen: false});
  }); // end document ready

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
