<?php
/**
 * Plugin Name:     My Books
 * Plugin URI:      https://www.rps34.com/
 * Description:     Add, edit, delete, view Books
 * Author:          RPS34
 * Author URI:      https://www.rps34.com/
 * Version:         1.0
**/


if(!defined('ABSPATH')) exit;
if(!defined('MY_BOOK_PLUGIN_DIR_PATH')) define('MY_BOOK_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
if(!defined('MY_BOOK_PLUGIN_URL')) define('MY_BOOK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function my_book_file_url($x){ return MY_BOOK_PLUGIN_URL.$x; }

function my_book_prefix($x){  return 'my_book_'.$x; }

add_action('admin_enqueue_scripts', function(){
    function add_style($name, $url){
        wp_enqueue_style( my_book_prefix( $name ) , MY_BOOK_PLUGIN_URL.$url );
    }

    function add_script($name, $url){
        wp_enqueue_script( my_book_prefix( $name ) , MY_BOOK_PLUGIN_URL.$url, '', false, true);
    }

    // BootStrap
    add_style('bootstrap', 'assets/libs/bootstrap-5.0.2-dist/css/bootstrap.min.css');
    add_script('bootstrap', 'assets/libs/bootstrap-5.0.2-dist/js/bootstrap.min.js');
    
    // DataTables
    add_style('datatables', 'assets/libs/DataTables/datatables.min.css');
    add_script('datatables', 'assets/libs/DataTables/datatables.min.js');
    
    // NotifyBar
    add_style('notifyBar', 'assets/libs/jQuery-Notify-bar-master/css/jquery.notifyBar.css');
    add_script('notifyBar', 'assets/libs/jQuery-Notify-bar-master/jquery.notifyBar.js');
    
    // Jquery Validation
    add_script('jquery-validate', 'assets/libs/jquery-validation-1.19.3/dist/jquery.validate.min.js');
    
    // Custom Files
    add_style('datatables-css', 'assets/css/style.css');
    add_script('datatables-js', 'assets/js/script.js');
});

add_action('admin_menu', function(){
    add_menu_page('My Book', 'My Book', 'manage_options', 'book-list', 'book_list_handler', 'dashicons-book-alt', 30);
    add_submenu_page('book-list', 'Book List', 'Book List', 'manage_options', 'book-list', 'book_list_handler', 'dashicons-book-alt');
    add_submenu_page('book-list', 'Add New Book', 'Add New', 'manage_options', 'add-new-book', 'add_new_book_handler', 'dashicons-book-alt');
});

function book_list_handler(){
    require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/book-list.php';
}

function add_new_book_handler(){
    require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/book-add.php';
}

function get_my_book_table_name(){
    return $GLOBALS['wpdb']->prefix . 'my_book';
}


register_activation_hook( __FILE__, 'my_book_activation_handler');

function my_book_activation_handler(){
    // Create Table
    global $wpdb;
    $create_table_sql = '
            CREATE TABLE `'. $wpdb->dbname .'`.`'. get_my_book_table_name() .'` (
                `id` INT NOT NULL AUTO_INCREMENT ,
                `name` VARCHAR(255) NULL ,
                `author` VARCHAR(255) NULL ,
                `about` TEXT NULL ,
                `boook_image` TEXT NULL ,
                `created_at` TIMESTAMP NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
    ';
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($create_table_sql);
}

register_uninstall_hook( __FILE__, 'my_book_uninstall_handler');

function my_book_uninstall_handler(){
    // Drop Table
    global $wpdb;
    $wpdb->query('DROP TABLE IF EXISTS '. get_my_book_table_name() );
}