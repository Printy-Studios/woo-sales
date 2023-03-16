<?php

    require_once WP_PLUGIN_DIR . '/woo-sales/functions/templates/ws_sale_editor_templates.php';


function ws_sale_editor_page_maybe_handle_post() {
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
}

//Render function of sales page
function ws_sale_editor_page(){

    ws_sale_editor_page_maybe_handle_post();

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