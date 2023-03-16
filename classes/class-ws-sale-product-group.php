<?php

class WS_Sale_Product_Group {
    private WS_Discount $discount;
    private array $conditions;

    function from_post( $post_data ) {
        $this->discount->from_post( $post_data );
    }
}