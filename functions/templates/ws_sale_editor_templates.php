<?php

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
