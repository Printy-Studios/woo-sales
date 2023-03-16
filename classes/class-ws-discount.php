<?php

class WS_Discount {
    private string|null $type;
    private float|null $value;

    function __construct(){

    }

    /**
     * Generate object data from $_POST request data
     * 
     * @param array $post_data $_POST data
     */
    function from_post( $post_data ) {
        $this->clear();
        //$this->type = $post_data['']
        if ( isset( $post_data['type'] ) ) {
            $this->type = $post_data['type'];
        }

        if ( isset( $post_data['value'] ) ) {
            $this->value = floatval($post_data['value']);
        }
    }

    function clear() {
        $this->type = null;
        $this->value = null;
    }
}