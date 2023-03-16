<?php

    /*
        * Plugin Name: WooSales
    */


/*Require all action functions */
$files = glob( __DIR__ . '/functions/actions/*.php');
foreach ($files as $file) {
    require_once($file);   
}

//Requires
require_once("classes/tables/SalesTable.php");

//Enqueue styles and scripts
function ws_enqueue_styles_scripts() {
    //echo plugin_dir_url(__FILE__);
    wp_enqueue_style("woo-sales-style", plugin_dir_url(__FILE__) . "/style.css");
    wp_enqueue_script("woo-sales-scripts", plugin_dir_url(__FILE__) . "/scripts.js");
}
add_action("admin_enqueue_scripts", "ws_enqueue_styles_scripts");


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
                <select
                    class='ws-condition-evaluation'
                >
                    <option>Contains</option>
                </select>
                <input class='ws-condition-value' type='text'>
                <select
                    class='ws-condition-comparison'
                >
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
                        <input type="number" style='width: 80px' name="group_x_discount_value" class='ws-group-discount-value'>
                        <!-- Discount type input -->
                        <select name="group_x_discount_type" class='ws-group-discount-type'>
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
                        type='button'
                    >
                        + Add condition
                    </button>
                    </div>
        </div>  
    <?php
}

class WS_Discount {
    private string $type;
    private float $value;

    function __construct(){

    }

    /**
     * Generate object data from $_POST request data
     * 
     * @param array $post_data $_POST data
     */
    function from_post( $post_data ) {
        //$this->type = $post_data['']
    }
}

class WS_Sale_Product_Group {
    private WS_Discount $discount;
    private array $conditions;

    function from_post( $post_data ) {
        $this->discount->from_post( $post_data );
    }
}

class WS_Sale_Product_Group_Condition {
    private string $type;
    private string $evaluation;
    private array $values;
    private string $condition;

}

//Render function of options page
function ws_sale_editor_page(){

    //$sales_table = new SalesTable();

    //$sales_table->prepare_items();

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // wp_insert_post( array(
        //     'post_type' => 'sale',
        //     'meta_input' => array (
        //         'groups' => 'abc'
        //     )
        // ) );

        echo "<pre>";
            print_r($_POST);
        echo "</pre>";
    }

    ?>
        <div class='ws-content'>
            <?php ws_sale_editor_templates() ?>
                <form method='POST' action=''>
                    
                    <div class='ws-flex-row ws-align-center'>
                        <input class='ws-text-input-large' type="text" name="name" placeholder="Sale name"/>
                        <div class='ws-h-spacer-small'></div>
                        <button class='button button-primary'>Save</button>
                    </div>
                    
                    <div id='groups-list' class="ws-product-groups-list">
                        
                    </div>
                    <button
                        type='button'
                        onclick="addGroup()"
                        class='ws-link-button ws-button-large ws-margin-v-medium'
                    >
                        + Add Group
                    </button>
                    <script>
                        window.addEventListener("load", () => {
                            loadSaleEditPage();
                        })
                        
                    </script>
                </form>
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