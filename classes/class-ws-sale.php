<?php

require_once WP_PLUGIN_DIR . '/woo-sales/classes/class-ws-sale-product-group.php';

class WS_Sale {
    private string|null $name;
    private $ID;
    private array $product_groups;

    /**
     * Generate data from $_POST request
     * 
     * @param array $post_data $_POST array
     */
    function from_post( $post_data ) {
        $this->clear();

        if ( isset( $_POST['sale_id'] ) ) {
            $this->ID = $_POST['sale_id'];
        }

        if ( isset( $_POST['sale_name'] ) ) {
            $this->name = $_POST['sale_name'];
        }

        if ( isset( $_POST['sale_product_group'] ) ) {
            $PRODUCT_GROUPS_POST_ARR = $_POST['sale_product_group'];
            foreach( $PRODUCT_GROUPS_POST_ARR as $product_group_post_arr ) {
                $index = array_push($this->product_groups, new WS_Sale_Product_Group()) - 1;
                $this->product_groups[$index]->from_post($product_group_post_arr);
            }
        }
    }

    /**
     * Clear all data
     */
    function clear() {
        $this->name = null;
        $this->ID = null;
        $this->product_groups = [];
    }

    /**
     * Check whether object data is valid
     * 
     * @return bool|array true on success, array of errors on failure
     */
    function validate() {

    }
}