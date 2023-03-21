<?php

class WS_Sale_Product_Group_Condition {
    private string|null $type;
    private string|null $evaluation;
    private array $values;
    private string|null $comparison;


    /**
     * Generate data from $_POST data
     * 
     * @param array $post_data $_POST data of condition
     */
    function from_post( $post_data ) {
        $this->clear();

        //echo "Condition data:";

        //print_r( $post_data );

        if(isset($post_data['type'])){
            $this->type = $post_data['type'];
        }

        if(isset($post_data['evaluation'])){
            $this->evaluation = $post_data['evaluation'];
        }

        if(isset($post_data['value'])){
            $this->values = $post_data['value'];
        }

        if(isset($post_data['comparison'])){
            $this->comparison = $post_data['comparison'];
        }
    }

    function clear() {
        $this->type = null;
        $this->evaluation = null;
        $this->values = [];
        $this->comparison = null;
    }
    
}