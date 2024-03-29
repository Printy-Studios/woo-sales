<?php


require_once __DIR__ . '/../../const.php';

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

$text_domain = "woo-sales";

class SalesTable extends WP_List_Table {
    protected $example_data = array(
        array(
            'ID'       => 1,
            'name'    => 'Fall sale',
            'starts-on' => 'March 15th',
            'ends-on' => 'April 2nd',
            'purchases-count' => 24,
            'status'   => "active",
        ),
        array(
            'ID'       => 2,
            'name'    => 'Summer sale',
            'starts-on' => 'August 2nd',
            'ends-on' => 'June 5th',
            'purchases-count' => 0,
            'status'   => "inactive",
        ),
        array(
            'ID'       => 3,
            'name'    => 'Winter sale',
            'starts-on' => 'December 6th',
            'ends-on' => 'January 6th',
            'purchases-count' => 0,
            'status'   => "inactive",
        ),
    );

    public function __construct() {
        // Set parent defaults.
        parent::__construct( array(
            'singular' => 'sale',     // Singular name of the listed records.
            'plural'   => 'sales',    // Plural name of the listed records.
            'ajax'     => false,       // Does this table support ajax?
        ) );
    }

    public function get_columns() {
        global $text_domain;
        $columns = array(
            'cb'       => '<input type="checkbox" />', // Render a checkbox instead of text.
            'name'    => _x( 'Name', 'Column label', $text_domain ),
            'starts-on'   => _x( 'Starts on', 'Column label', $text_domain ),
            'ends-on' => _x( 'Ends on', 'Column label', $text_domain ),
            'purchases-count' => _x( 'Items purchased', 'Column label', $text_domain ),
            'status' => _x( 'Status', 'Column label', $text_domain)
        );

        return $columns;
    }

    protected function get_sortable_columns() {
        $sortable_columns = array(
            'name'    => array( 'name', false ),
            'starts-on'   => array( 'starts-on', false ),
            'ends-on' => array( 'ends-on', false ),
            'purchases-count' => array( 'purchases-count', false ),
        );

        return $sortable_columns;
    }

    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'name':
            case 'starts-on':
                return $item[ $column_name ];
            case 'ends-on':
                return $item[ $column_name ];
            case 'status':
                return $item[ $column_name ];
            case 'purchases-count':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ); // Show the whole array for troubleshooting purposes.
        }
    }

    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],  // Let's simply repurpose the table's singular label ("movie").
            $item['ID']                // The value of the checkbox should be the record's ID.
        );
    }

    protected function column_name( $item ) {
        $page = wp_unslash( $_REQUEST['page'] ); // WPCS: Input var ok.

        // Build edit row action.
        $edit_query_args = array(
            'page'   => $page,
            'action' => 'edit',
            'sale'  => $item['ID'],
        );

        $actions['edit'] = sprintf(
            '<a href="%1$s">%2$s</a>',
            esc_url( wp_nonce_url( add_query_arg( $edit_query_args, 'admin.php' ), 'editmovie_' . $item['ID'] ) ),
            _x( 'Edit', 'List table row action', 'wp-list-table-example' )
        );

        // Build delete row action.
        $delete_query_args = array(
            'page'   => $page,
            'action' => 'delete',
            'sale'  => $item['ID'],
        );

        $actions['delete'] = sprintf(
            '<a href="%1$s">%2$s</a>',
            esc_url( wp_nonce_url( add_query_arg( $delete_query_args, 'admin.php' ), 'deletemovie_' . $item['ID'] ) ),
            _x( 'Delete', 'List table row action', 'wp-list-table-example' )
        );

        // Return the title contents.
        return sprintf( '%1$s <span style="color:silver;">(id:%2$s)</span>%3$s',
            $item['name'],
            $item['ID'],
            $this->row_actions( $actions )
        );
    }

    protected function get_bulk_actions() {
        $actions = array(
            'delete' => _x( 'Delete', 'List table bulk action', 'wp-list-table-example' ),
        );

        return $actions;
    }

    protected function process_bulk_action() {
        // Detect when a bulk action is being triggered.
        if ( 'delete' === $this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
    }

    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /*
            * First, lets decide how many records per page to show
            */
        $per_page = 5;

        /*
            * REQUIRED. Now we need to define our column headers. This includes a complete
            * array of columns to be displayed (slugs & titles), a list of columns
            * to keep hidden, and a list of columns that are sortable. Each of these
            * can be defined in another method (as we've done here) before being
            * used to build the value for our _column_headers property.
            */
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        /*
            * REQUIRED. Finally, we build an array to be used by the class for column
            * headers. The $this->_column_headers property takes an array which contains
            * three other arrays. One for all columns, one for hidden columns, and one
            * for sortable columns.
            */
        $this->_column_headers = array( $columns, $hidden, $sortable );

        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();

        /*
            * GET THE DATA!
            * 
            * Instead of querying a database, we're going to fetch the example data
            * property we created for use in this plugin. This makes this example
            * package slightly different than one you might build on your own. In
            * this example, we'll be using array manipulation to sort and paginate
            * our dummy data.
            * 
            * In a real-world situation, this is probably where you would want to 
            * make your actual database query. Likewise, you will probably want to
            * use any posted sort or pagination data to build a custom query instead, 
            * as you'll then be able to use the returned query data immediately.
            *
            * For information on making queries in WordPress, see this Codex entry:
            * http://codex.wordpress.org/Class_Reference/wpdb
            */
        //$data = $this->example_data;
        $data = get_posts(array(
            'post_type' => array('ws-sale')
        ));
        echo "<pre>";
        print_r( $data );
        //print_r(get_posts());
        echo "</pre>";

        /*
            * This checks for sorting input and sorts the data in our array of dummy
            * data accordingly (using a custom usort_reorder() function). It's for 
            * example purposes only.
            *
            * In a real-world situation involving a database, you would probably want
            * to handle sorting by passing the 'orderby' and 'order' values directly
            * to a custom query. The returned data will be pre-sorted, and this array
            * sorting technique would be unnecessary. In other words: remove this when
            * you implement your own query.
            */
        usort( $data, array( $this, 'usort_reorder' ) );

        /*
            * REQUIRED for pagination. Let's figure out what page the user is currently
            * looking at. We'll need this later, so you should always include it in
            * your own package classes.
            */
        $current_page = $this->get_pagenum();

        /*
            * REQUIRED for pagination. Let's check how many items are in our data array.
            * In real-world use, this would be the total number of items in your database,
            * without filtering. We'll need this later, so you should always include it
            * in your own package classes.
            */
        $total_items = count( $data );

        /*
            * The WP_List_Table class does not handle pagination for us, so we need
            * to ensure that the data is trimmed to only the current page. We can use
            * array_slice() to do that.
            */
        $data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

        /*
            * REQUIRED. Now we can add our *sorted* data to the items property, where
            * it can be used by the rest of the class.
            */
        $this->items = $data;

        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                     // WE have to calculate the total number of items.
            'per_page'    => $per_page,                        // WE have to determine how many items to show on a page.
            'total_pages' => ceil( $total_items / $per_page ), // WE have to calculate the total number of pages.
        ) );
    }

    protected function usort_reorder( $a, $b ) {
        // If no sort, default to title.
        $orderby = ! empty( $_REQUEST['orderby'] ) ? wp_unslash( $_REQUEST['orderby'] ) : 'name'; // WPCS: Input var ok.

        // If no order, default to asc.
        $order = ! empty( $_REQUEST['order'] ) ? wp_unslash( $_REQUEST['order'] ) : 'asc'; // WPCS: Input var ok.

        // Determine sort order.
        $result = strcmp( $a[ $orderby ], $b[ $orderby ] );

        return ( 'asc' === $order ) ? $result : - $result;
    }

    protected function extra_tablenav($which){
        global $SALE_EDITOR_PAGE_SLUG;
        ?>
            <a
                href="<?php echo admin_url("admin.php?page={$SALE_EDITOR_PAGE_SLUG}") ?>"
                class='button button-secondary'
            >
                New Sale
            </a>
        <?php
    }
}