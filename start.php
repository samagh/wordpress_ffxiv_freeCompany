<?php


function ffxiv_install() {

    global $wpdb;

    // CREAMOS LA BBDD
    $init_sql = file_get_contents( dirname(__FILE__).'/schema.sql');
    $create_sql = explode(';',$init_sql);
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    foreach ($create_sql as $sql)
        dbDelta($sql.";");

    $the_page_title_1 = 'Nuestras Clases';
    $the_page_name_1 = 'members_classes';

    $the_page_title_2 = 'Nuestras Profesiones';
    $the_page_name_2 = 'members_jobs';

    // the menu entry...
    delete_option("ffxiv_page_title_1");
    add_option("ffxiv_page_title_1", $the_page_title_1, '', 'yes');
    // the slug...
    delete_option("ffxiv_page_name_1");
    add_option("ffxiv_page_name_1", $the_page_name_1, '', 'yes');
    // the id...
    delete_option("ffxiv_page_id_1");
    add_option("ffxiv_page_id_1", '0', '', 'yes');

    $the_page_1 = get_page_by_title( $the_page_title_1 );

    // the menu entry...
    delete_option("ffxiv_page_title_2");
    add_option("ffxiv_page_title_2", $the_page_title_2, '', 'yes');
    // the slug...
    delete_option("ffxiv_page_name_2");
    add_option("ffxiv_page_name_2", $the_page_name_2, '', 'yes');
    // the id...
    delete_option("ffxiv_page_id_2");
    add_option("ffxiv_page_id_2", '0', '', 'yes');

    $the_page_2 = get_page_by_title( $the_page_title_2 );


    if ( ! $the_page_1 ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $the_page_title_1;
        $_p['post_content'] = "[insert_php] ffxiv_freeCompany_classes_html(); [/insert_php]";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $the_page_id_1 = wp_insert_post( $_p );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...
        $the_page_id_1 = $the_page_1->ID;

        //make sure the page is not trashed...
        $the_page_1->post_status = 'publish';
        $the_page_id_1 = wp_update_post( $the_page_1 );

    }

    delete_option( 'ffxiv_page_id_1' );
    add_option( 'ffxiv_page_id_1', $the_page_id_1 );


    if ( ! $the_page_2 ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $the_page_title_2;
        //$_p['post_content'] = "[insert_php] ffxiv_freeCompany_jobs_html(); [/insert_php]";
        $_p['post_content'] = $init_sql;
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $the_page_id_2 = wp_insert_post( $_p );
    }
    else {
        // the plugin may have been previously active and the page may just be trashed...
        $the_page_id_2 = $the_page_2->ID;

        //make sure the page is not trashed...
        $the_page_2->post_status = 'publish';
        $the_page_id_2 = wp_update_post( $the_page_2 );

    }

    delete_option( 'ffxiv_page_id_2' );
    add_option( 'ffxiv_page_id_2', $the_page_id_2 );

    wp_schedule_event(time(), 'daily', 'ffxiv_update_db');
    // Forzamos que se ejecute dentro de 1 minuto
    wp_schedule_single_event( time() + 5, 'ffxiv_update_db' );
}

function ffxiv_remove() {

    global $wpdb;

    $the_page_title_1 = get_option( "ffxiv_page_title_1" );
    $the_page_name_1 = get_option( "ffxiv_page_name_1" );

    //  the id of our page...
    $the_page_id_1 = get_option( 'ffxiv_page_id_1' );
    if( $the_page_id_1 ) {
        wp_delete_post( $the_page_id_1 ); // this will trash, not delete
    }

    $the_page_title_2 = get_option( "ffxiv_page_title_2" );
    $the_page_name_2 = get_option( "ffxiv_page_name_2" );

    //  the id of our page...
    $the_page_id_2 = get_option( 'ffxiv_page_id_2' );
    if( $the_page_id_2 ) {
        wp_delete_post( $the_page_id_2 ); // this will trash, not delete
    }


    delete_option("ffxiv_page_title");
    delete_option("ffxiv_page_name");
    delete_option("ffxiv_page_id");
    wp_clear_scheduled_hook('ffxiv_update_db');
}
