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

    if(isset($_GET['page'])){
        $pages =['book-list', 'add-new-book', 'edit-book', 'view-book'];
        array_push($pages, 'add-book-user', 'edit-book-user', 'list-book-users');
        array_push($pages, 'add-book-author', 'edit-book-author', 'list-book-authors', 'preview-book-author');
        array_push($pages, 'book-users-enrollment');
        if(in_array($_GET['page'], $pages)){
            // jQuery
            wp_enqueue_script('jquery');
    
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
            add_style('custom-css', 'assets/css/style.css');
            add_script('custom-js', 'assets/js/script.js');

            wp_localize_script(my_book_prefix('custom-js'), 'mb_ajaxurl', admin_url('admin-ajax.php'));
        }
    }
});

add_action('admin_menu', function(){
    add_menu_page('My Book', 'My Book', 'manage_options', 'book-list', 'book_list_handler', 'dashicons-book-alt', 30);
    
    add_submenu_page('book-list', 'All Books', 'All Books', 'manage_options', 'book-list', 'book_list_handler');
    add_submenu_page('book-list', 'Add New Book', 'Add Book', 'manage_options', 'add-new-book', 'add_new_book_handler');
    add_submenu_page(null, 'Edit Book', null, 'manage_options', 'view-book', 'view_book_handler');
    add_submenu_page(null, 'Edit Book', null, 'manage_options', 'edit-book', 'edit_book_handler');
    
    add_submenu_page('book-list', 'All Users', 'All Users', 'manage_options', 'list-book-users', 'list_book_users_handler');
    add_submenu_page('book-list', 'Add New User', 'Add User', 'manage_options', 'add-book-user', 'add_book_user_handler');
    add_submenu_page(null, 'Edit User', null, 'manage_options', 'edit-book-user', 'edit_book_user_handler');
    
    add_submenu_page('book-list', 'All Authors', 'All Authors', 'manage_options', 'list-book-authors', 'list_author_users_handler');
    add_submenu_page('book-list', 'Add New Author', 'Add Author', 'manage_options', 'add-book-author', 'add_book_author_handler');
    add_submenu_page(null, 'Edit Author', null, 'manage_options', 'edit-book-author', 'edit_book_author_handler');
    add_submenu_page(null, 'Preview Author', null, 'manage_options', 'preview-book-author', 'preview_book_author_handler');
    
    add_submenu_page('book-list', 'Users Enrollment', 'Users Enrollment', 'manage_options', 'book-users-enrollment', 'users_enrollment_handler');
    
});

function book_list_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/book-list.php'; }
function add_new_book_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/book-add.php'; }
function edit_book_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/book-edit.php'; }
function view_book_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/book-view.php'; }

function add_book_user_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/user-add.php'; }
function list_book_users_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/user-list.php'; }
function edit_book_user_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/user-edit.php'; }

function add_book_author_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/author-add.php'; }
function list_author_users_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/author-list.php'; }
function edit_book_author_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/author-edit.php'; }
function preview_book_author_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/author-preview.php'; }

function users_enrollment_handler() { require_once MY_BOOK_PLUGIN_DIR_PATH . 'views/list-enrollments.php'; }


register_activation_hook( __FILE__, 'my_book_activation_handler');

function my_book_activation_handler(){
    // Create Table
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $tables = get_my_book_table_info();
    foreach($tables as $v) dbDelta($v);
}

function get_my_book_table_info($names = false, $prefixed = false){
    global $wpdb;

    $table = 'book_books';
    $sql[$table] = '
            CREATE TABLE `'. $wpdb->dbname .'`.`'. $wpdb->prefix . $table .'` (
                `id` INT NOT NULL AUTO_INCREMENT ,
                `name` VARCHAR(255) NULL ,
                `author_id` INT NOT NULL ,
                `about` TEXT NULL ,
                `book_image` TEXT NULL ,
                `created_at` TIMESTAMP NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
    ';

    $table = 'book_users';
    $sql[$table] = '
            CREATE TABLE `'. $wpdb->dbname .'`.`'. $wpdb->prefix . $table .'` (
                `id` INT NOT NULL AUTO_INCREMENT ,
                `name` VARCHAR(100) NOT NULL ,
                `email` VARCHAR(100) NOT NULL ,
                `wp_users_id` INT NOT NULL ,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
    ';

    $table = 'book_authors';
    $sql[$table] = '
            CREATE TABLE `'. $wpdb->dbname .'`.`'. $wpdb->prefix . $table .'` (
                `id` INT NOT NULL AUTO_INCREMENT ,
                `name` VARCHAR(100) NOT NULL ,
                `fb_link` VARCHAR(100) NULL ,
                `about` TEXT NULL ,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
    ';

    $table = 'book_enrollment';
    $sql[$table] = '
            CREATE TABLE `'. $wpdb->dbname .'`.`'. $wpdb->prefix . $table .'` (
                `id` INT NOT NULL AUTO_INCREMENT ,
                `user_id` INT NOT NULL ,
                `book_id` INT NOT NULL ,
                `enrolled_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;
    ';
    
    if($names){
        $names = array_keys($sql);
        if($prefixed){
            $length = count($sql);
            for($i=0; $i<$length; $i++){
                $names[$i] = $wpdb->prefix . $names[$i];
            }
        }
        return $names;
    }
    return $sql;
}

register_deactivation_hook( __FILE__, 'my_book_uninstall_handler');
register_uninstall_hook( __FILE__, 'my_book_uninstall_handler');

function my_book_uninstall_handler(){
    // Drop Table
    global $wpdb;
    $table_names = get_my_book_table_info(true, true);
    foreach($table_names as $v) $wpdb->query('DROP TABLE IF EXISTS '. $v );
}

add_action('wp_ajax_my_book', function(){
    require_once MY_BOOK_PLUGIN_DIR_PATH . 'library/ajax.php';
});