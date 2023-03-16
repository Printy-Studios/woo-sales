<?php

require_once WP_PLUGIN_DIR . '/woo-sales/const.php';
require_once WP_PLUGIN_DIR . '/woo-sales/functions/pages/ws_sale_editor_page.php';
require_once WP_PLUGIN_DIR . '/woo-sales/functions/pages/ws_sales_page.php';

function ws_add_menu_items(){
    global $SALE_EDITOR_PAGE_SLUG;

    //add_submenu_page("woocommerce", "WooSales", "aaa", "manage_options", "ws_render_options_page", "test");
    add_submenu_page("woocommerce", "WooSales", "WooSales", "manage_options", "woo-sales", "ws_render_options_page");

    add_submenu_page(null, "WooSales", "New Sale", "manage_options", $SALE_EDITOR_PAGE_SLUG, "ws_sale_editor_page");
}
add_action("admin_menu", "ws_add_menu_items");