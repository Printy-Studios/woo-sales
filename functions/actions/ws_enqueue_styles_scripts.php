<?php

//Enqueue styles and scripts
function ws_enqueue_styles_scripts( $page_slug ) {
    $js_dir = plugin_dir_url(__FILE__) . "../../js/";
    $style_file = plugin_dir_url(__FILE__) . "../../style.css";

    wp_enqueue_style("woo-sales-style", $style_file);
    echo $page_slug;
    if($page_slug == 'admin_page_ws-sale-editor')
    wp_enqueue_script("woo-sales-scripts", $js_dir . "ws-sale-editor.js");
}
add_action("admin_enqueue_scripts", "ws_enqueue_styles_scripts");