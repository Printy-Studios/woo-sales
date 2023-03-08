<?php

    /*
        * Plugin Name: WooSales
    */



//Register and enqueue styles/scripts
function ws_register_styles() {
	wp_register_style( 'woo-sales', plugins_url( 'style.css', __FILE__ ) );
}
function ws_enqueue_styles() {
    wp_enqueue_style("woo-sales");
}

add_action("admin_init", "ws_register_styles");
add_action("wp_enqueue_scripts", "ws_enqueue_styles");


//Render function of options page
function ws_render_options_page(){
    ?>
        <div class='ws-header'>
            <h1>WooSales</h1>
        </div>
    <?php
}

//Add submenu item
function ws_init_menu_items(){
    //add_submenu_page("woocommerce", "WooSales", "aaa", "manage_options", "ws_render_options_page", "test");
    add_submenu_page("woocommerce", "WooSales", "WooSales", "manage_options", "woo-sales", "ws_render_options_page");
}
add_action("admin_menu", "ws_init_menu_items");