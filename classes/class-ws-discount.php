<?php

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