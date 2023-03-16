<?php

require_once 'class-ws-discount.php';

class WS_Sale_Product_Group {
    private WS_Discount $discount;
    private array $conditions;

    function from_post( $post_data ) {
        $this->clear();

        if( isset($post_data['discount'] ) ) {
            $this->discount->from_post( $post_data['discount'] );
        }
        
    }

    function clear() {
        $this->discount = new WS_Discount();
        $this->conditions = [];
    }
}