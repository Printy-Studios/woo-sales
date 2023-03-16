<?php

//Render function of options page
function ws_sales_page(){

    $sales_table = new SalesTable();

    $sales_table->prepare_items();

    ?>
        <div class='ws-content'>
            <h1>WooSales</h1>
            <form id="sales-table" method="get">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <!-- Now we can render the completed list table -->
                <?php $sales_table->display() ?>
            </form>
        </div>
    <?php
}