<?php

function ws_register_post_types() {
    register_post_type( 'ws-sale', array(
        'label' => 'Sale'
    ) );
}
add_action( 'init', 'ws_register_post_types' );