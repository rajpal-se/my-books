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

if(!defined('MY_BOOK_PLUGIN_ROLE')) define('MY_BOOK_PLUGIN_ROLE', 'my-book-reader' );
if(!defined('MY_BOOK_PLUGIN_CUSTOM_PAGE')) define('MY_BOOK_PLUGIN_CUSTOM_PAGE', 'mb-books' );
if(!defined('MY_BOOK_PLUGIN_SHORTCODE')) define('MY_BOOK_PLUGIN_SHORTCODE', 'mb-books' );
if(!defined('MY_BOOK_PLUGIN_OPT_CUSTOM_PAGE')) define('MY_BOOK_PLUGIN_OPT_CUSTOM_PAGE', 'mb-books-custom-page-id' );
if(!defined('MY_BOOK_PLUGIN_JS_CONSOLE')) define('MY_BOOK_PLUGIN_JS_CONSOLE', true );

function my_book_file_url($x){ return MY_BOOK_PLUGIN_URL.$x; }

function my_book_prefix($x){  return 'my_book_'.$x; }

function add_style($name, $url){
    wp_enqueue_style( my_book_prefix( $name ) , MY_BOOK_PLUGIN_URL.$url );
}
function add_script($name, $url){
    wp_enqueue_script( my_book_prefix( $name ) , MY_BOOK_PLUGIN_URL.$url, '', false, true);
}

add_action('admin_enqueue_scripts', function(){
    
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
            
            wp_localize_script(my_book_prefix('custom-js'), 'console_log', strval(MY_BOOK_PLUGIN_JS_CONSOLE));
            wp_localize_script(my_book_prefix('custom-js'), 'mb_ajaxurl', admin_url('admin-ajax.php'));
        }
    }
});

add_action('wp_enqueue_scripts', function(){
    if(strstr($_SERVER['REQUEST_URI'], '/mb-books')){
        // jQuery
        wp_enqueue_script('jquery');
        
        // BootStrap
        add_style('bootstrap', 'assets/libs/bootstrap-5.0.2-dist/css/bootstrap.min.css');
        add_script('bootstrap', 'assets/libs/bootstrap-5.0.2-dist/js/bootstrap.min.js');
        
        // Custom Files
        add_script('custom-js-fe', 'assets/js/script-fe.js');
        
        wp_localize_script(my_book_prefix('custom-js-fe'), 'console_log', strval(MY_BOOK_PLUGIN_JS_CONSOLE));
        wp_localize_script(my_book_prefix('custom-js-fe'), 'mb_ajaxurl', admin_url('admin-ajax.php'));
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

    $table = 'book_enrollments';
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

register_activation_hook( __FILE__, 'my_book_activation_handler');
function my_book_activation_handler(){
    // Create Table
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $tables = get_my_book_table_info();
    foreach($tables as $v) dbDelta($v);

    add_role(MY_BOOK_PLUGIN_ROLE, 'My Book Reader', ['read' => true]);

    $post = get_post( wp_insert_post([
        'post_name' => MY_BOOK_PLUGIN_CUSTOM_PAGE,
        'post_title' => 'All Books',
        'post_content' => '['.MY_BOOK_PLUGIN_SHORTCODE.'][/'.MY_BOOK_PLUGIN_SHORTCODE.']',
        'post_type' => 'page',
        'post_status' => 'publish'
    ]) );
    
    update_option(MY_BOOK_PLUGIN_OPT_CUSTOM_PAGE, $post->ID);
}
register_deactivation_hook( __FILE__, 'my_book_deactivation_handler');
function my_book_deactivation_handler(){
        // Drop Table
        my_book_uninstall_handler();

        if(get_role( MY_BOOK_PLUGIN_ROLE )) remove_role( MY_BOOK_PLUGIN_ROLE );
}
register_uninstall_hook( __FILE__, 'my_book_uninstall_handler');
function my_book_uninstall_handler(){
    // Drop Table
    global $wpdb;
    $table_names = get_my_book_table_info(true, true);
    foreach($table_names as $v) $wpdb->query('DROP TABLE IF EXISTS '. $v );

    $id = get_option(MY_BOOK_PLUGIN_OPT_CUSTOM_PAGE);
    if($id){
        wp_delete_post($id, true);
        delete_option(MY_BOOK_PLUGIN_OPT_CUSTOM_PAGE);
    }
}

add_action('wp_ajax_my_book', function(){
    require_once MY_BOOK_PLUGIN_DIR_PATH . 'library/ajax.php';
});

function get_field($field, $length = 22){
    $data = htmlentities(stripslashes($field));
    if($length == false) return $data;
    if(strlen($data) > $length) $data = substr($data, 0, $length) . '...';
    return $data;
}

add_action('profile_update', function($user_id, $user_old_data, $user_data){
    $text = 'redirect_to=' . MY_BOOK_PLUGIN_ROLE;
    if( strstr(wp_get_raw_referer() , $text)){
        wp_redirect( admin_url('admin.php?page=list-book-users'), 301 );
        exit;
    }
}, 10, 3);

add_action('init', function(){
    add_shortcode(MY_BOOK_PLUGIN_SHORTCODE, 'my_plugin_shortcode_handler');

    add_rewrite_rule( MY_BOOK_PLUGIN_CUSTOM_PAGE . '/([0-9]+)[/]?$', 'index.php?read_book_id=$matches[1]', 'top' );
});
add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'read_book_id';
    return $query_vars;
} );
add_action( 'template_include', function( $template ) {
    if ( get_query_var( 'read_book_id' ) == false || get_query_var( 'read_book_id' ) == '' ) {
        return $template;
    }
    return MY_BOOK_PLUGIN_DIR_PATH . 'views/custom-page-read-book.php';
} );

function my_plugin_shortcode_handler($atts, $content = ''){
    $attributes = shortcode_atts( array(), $atts );
     
    ob_start();
    echo "Working Fine.";
    // include template with the arguments (The $args parameter was added in v5.5.0)
    // get_template_part( 'template-parts/wpdocs-the-shortcode-template', null, $attributes );
 
    return ob_get_clean();
}

add_action('wp_login', 'redirect_to_my_page');
add_action('wp_logout', 'redirect_to_my_page');

function redirect_to_my_page(){
    $custom_page_id = get_option(MY_BOOK_PLUGIN_OPT_CUSTOM_PAGE, 0);
    if( $custom_page_id ){
        $link = get_permalink($custom_page_id);
        wp_redirect($link, 301);
        exit();
    }
}

add_filter('page_template', function($template, $type, $templates){
    if(in_array('page-'. MY_BOOK_PLUGIN_CUSTOM_PAGE . '.php', $templates)){
        return MY_BOOK_PLUGIN_DIR_PATH . 'views/custom-page.php';
    }
}, 10, 3);