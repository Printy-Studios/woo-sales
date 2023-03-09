<?php

    /*
        * Plugin Name: WooSales
    */

//Requires
require_once("classes/tables/SalesTable.php");

//Enqueue styles and scripts
function ws_enqueue_styles_scripts() {
    //echo plugin_dir_url(__FILE__);
    wp_enqueue_style("woo-sales-style", plugin_dir_url(__FILE__) . "/style.css");
    wp_enqueue_script("woo-sales-scripts", plugin_dir_url(__FILE__) . "/scripts.js");
}
add_action("admin_enqueue_scripts", "ws_enqueue_styles_scripts");


//Register post types
function ws_register_post_types(){
    register_post_type("ws-sale", [
        "label" => "Sale"
    ]);
}
add_action( 'init', 'ws_register_post_types' );


//Render function of options page
function ws_render_options_page(){

    $sales_table = new SalesTable();

    $sales_table->prepare_items();

    ?>
        <div class='ws-content'>
            <h1>WooSales</h1>
            <form id="sales-table" method="get">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <!-- Now we can render the completed list table -->
                <?php $sales_table->display() ?>
            </form>
        </div>
    <?php
}

function ws_render_product_group_list_item($group_id){
    ?>
        <div id='group-<?php echo $group_id ?>'class="ws-product-group-list-item">
            <h2>Group name</h2>
            <div class="ws-group-type-container">
                <select name='group_<?php echo $group_id ?>_type'>
                    <option value='include'>Include</option>
                    <option value='include'>Exclude</option>
                </select>
                <span style='font-size: 16px'>&nbsp;Product if</span>
            </div>
            <div class="ws-group-type-conditions">

            </div>
            <button 
                onclick="addGroupCondition(<?php echo $group_id ?>)"
                class="ws-group-add-condition"
            >
                + Add condition
            </button>
        </div>
    <?php
}

//Render function of options page
function ws_new_sale_page(){

    //$sales_table = new SalesTable();

    //$sales_table->prepare_items();

    ?>
        <div class='ws-content'>
            <input type="text" name="name" placeholder="Sale name"/>
            <div id='condition-template' class="ws-group-type-condition">
                Condition
            </div>
            <div class="ws-product-groups-list">
                <?php 
                    ws_render_product_group_list_item(1);
                    ws_render_product_group_list_item(2);
                    ws_render_product_group_list_item(3);
                    ws_render_product_group_list_item(4);
                ?>
            </div>
        </div>
    <?php
}

//Add submenu item
function ws_init_menu_items(){
    //add_submenu_page("woocommerce", "WooSales", "aaa", "manage_options", "ws_render_options_page", "test");
    add_submenu_page("woocommerce", "WooSales", "WooSales", "manage_options", "woo-sales", "ws_render_options_page");

    add_submenu_page(null, "WooSales", "New Sale", "manage_options", "ws-new-sale", "ws_new_sale_page");
}
add_action("admin_menu", "ws_init_menu_items");