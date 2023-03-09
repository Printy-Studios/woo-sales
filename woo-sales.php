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

/**
 * Render hidden sale editor template elements. These elements can be then cloned using JavaScript.
 * IDs:
 *  Condition: 'condition-template'
 *  Group: 'group-template'
 */
function ws_sale_editor_templates(){

    global $woocommerce;

    ?>
        <!-- Template elements -->
        <div style='display:none'>
            <!-- Condition template -->
            <div id='condition-template' class="ws-group-item-condition ws-flex-row ws-align-center ws-v-margin-small">
                <!-- Condition -->
                <select
                    class='ws-condition-type'
                >
                    <option>Name</option>
                </select>
                <select>
                    <option>Contains</option>
                </select>
                <input type='text'>
                <select>
                    <option>AND</option>
                    <option>OR</option>
                </select>
            </div>
            <!-- Group template -->
            <div id='group-list-item-template' class='ws-product-group-list-item'>
                <h2 class='ws-group-name'>Group name</h2>
                    <!-- Discount specifier element -->
                    <div class="ws-group-discount-container">
                        <span>Apply &nbsp;</span>
                        <!-- Discount value input -->
                        <input type="number" style='width: 80px'name="group_x_discount_value">
                        <!-- Discount type input -->
                        <select name="group_x_discount_type">
                            <option value="percentage">%</option>
                            <option value="fixed"><?php echo get_woocommerce_currency_symbol() ?></option>
                        </select>
                        <span>&nbsp; Discount, if</span>
                    </div>
                    <!-- Conditions list -->
                    <div class="ws-group-item-conditions">
        
                    </div>
                    <!-- 
                        "Add condition" button. Through JS, 
                        the onclick event should be assigned to 
                        addGroupCondition(group_id) function when 
                        the group element gets created
                    -->
                    <button 
                        class="ws-group-add-condition-button"
                    >
                        + Add condition
                    </button>
                    </div>
        </div>  
    <?php
}

//Render function of options page
function ws_sale_editor_page(){

    //$sales_table = new SalesTable();

    //$sales_table->prepare_items();

    ?>
        <div class='ws-content'>
            <?php ws_sale_editor_templates() ?>
            <input type="text" name="name" placeholder="Sale name"/>
            <div id='groups-list' class="ws-product-groups-list">
                
            </div>
            <button
                onclick="addGroup()"
                class='ws-link-button ws-button-large'
            >
                + Add Group
            </button>
            <script>
                window.addEventListener("load", () => {
                    loadSaleEditPage();
                })
                
            </script>
        </div>
    <?php
}

//Add submenu item
function ws_init_menu_items(){
    //add_submenu_page("woocommerce", "WooSales", "aaa", "manage_options", "ws_render_options_page", "test");
    add_submenu_page("woocommerce", "WooSales", "WooSales", "manage_options", "woo-sales", "ws_render_options_page");

    add_submenu_page(null, "WooSales", "New Sale", "manage_options", "ws-new-sale", "ws_sale_editor_page");
}
add_action("admin_menu", "ws_init_menu_items");