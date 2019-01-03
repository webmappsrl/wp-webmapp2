<?php


global $wm_anypost_bootstrap_col_type,
       $wm_anypost_global_taxonomies,
       $wm_anypost_template,
       $wm_anypost_post_type;

$title_link = get_the_permalink();
$get_the_post_thumbanil = get_the_post_thumbnail_url(get_the_ID() ,'full');
$current_post_type = get_post_type();


?>

<div class="col-sm-12 col-md-<?php echo $wm_anypost_bootstrap_col_type?> webmapp_shortcode_any_post post_type_<?php echo $wm_anypost_post_type?>">

    <div class="webmapp_post-title">
        <h2>
            <?php echo "<a href='$title_link' title=\"".get_the_title()."\" class='webmapp_customizer_general_color1-color webmapp_customizer_general_font1-font-family webmapp_customizer_general_size2-font-size'>" . get_the_title() . "</a>"; ?>
        </h2>

        <?php
        WebMapp_Utils::theShortInfo();
        ?>

    </div>


    <div class="webmapp_post-featured-img">
        <?php
        echo "<a href='$title_link' title=\"".get_the_title()."\">";
        ?>
        <figure class="webmapp_post_image" style="background-image: url('<?php echo $get_the_post_thumbanil; ?>')">
        </figure>
        <?php
        echo "</a>";
        ?>
    </div>

    <?php
        the_excerpt();
    ?>

</div>
