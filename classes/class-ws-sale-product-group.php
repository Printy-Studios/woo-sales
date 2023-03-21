<?php

require_once 'class-ws-discount.php';
require_once 'class-ws-sale-product-group-condition.php';

class WS_Sale_Product_Group {
    private WS_Discount $discount;
    private array $conditions;

    function from_post( $post_data ) {
        $this->clear();

        if ( isset($post_data['discount'] ) ) {
            $this->discount->from_post( $post_data['discount'] );
        }

        if ( isset( $post_data['condition'] ) ) {
            $conditions = $post_data['condition'];
            foreach ( $conditions as $condition ) {
                $index = array_push( $this->conditions, new WS_Sale_Product_Group_Condition()) - 1;
                $this->conditions[$index]->from_post($condition);
            }
            
        }

        
        
    }

    function clear() {
        $this->discount = new WS_Discount();
        $this->conditions = [];
    }
}