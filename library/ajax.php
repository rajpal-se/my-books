<?php
if(!defined('ABSPATH')) die();

function reply_positive($data = '', $message = ''){
    header('Content-Type: application/json');
    exit(json_encode(['status' => 1, 'data' => $data, 'message' => $message]));
}
function reply_negitive($message = '', $data = ''){
    header('Content-Type: application/json');
    exit(json_encode(['status' => 0, 'message' => $message, 'data' => $data]));
}
if(!isset($_REQUEST['sub_action'])) reply_negitive('Please send "sub_action" variable');

if(function_exists($_REQUEST['sub_action'])) $_REQUEST['sub_action']();
else reply_negitive('"sub_action" param is Invalid.');
die();

function add_book(){
    global $wpdb;
    $table = $wpdb->prefix . 'book_books';
    if(!isset($_REQUEST['name'])) reply_negitive("Book name is Required.");
    if(!isset($_REQUEST['author_id'])) reply_negitive("Book Author ID is Required.");
    if(!isset($_REQUEST['about'])) reply_negitive("Book About information is Required.");
    if(!isset($_REQUEST['image'])) reply_negitive("Book Image URL is Required.");
    
    $data['name'] = $_REQUEST['name'];
    $data['author_id'] = $_REQUEST['author_id'];
    $data['about'] = $_REQUEST['about'];
    $data['book_image'] = $_REQUEST['image'];

    $format = ['%s', '%d', '%s', '%s'];

    if( $wpdb->insert($table, $data, $format) ){
        reply_positive(['insert_id' => $wpdb->insert_id], "Book added Successfully.");
    }
    else{
        reply_negitive('Failed to add New Book.');
    }
}
function edit_book(){
    global $wpdb;
    $table = $wpdb->prefix . 'book_books';
    if(!isset($_REQUEST['book_id'])) reply_negitive("Book ID is Required.");
    if(!isset($_REQUEST['name'])) reply_negitive("Book name is Required.");
    if(!isset($_REQUEST['author_id'])) reply_negitive("Book Author ID is Required.");
    if(!isset($_REQUEST['about'])) reply_negitive("Book About information is Required.");
    
    $data['name'] = $_REQUEST['name'];
    $data['author_id'] = $_REQUEST['author_id'];
    $data['about'] = $_REQUEST['about'];
    $data['book_image'] = $_REQUEST['image'];

    $where['id'] = $_REQUEST['book_id'];

    $update = $wpdb->update($table, $data, $where, ['%s', '%d', '%s', '%s'], ['%d']);

    if( $update !== false ){
        $redirect = admin_url('admin.php?page=book-list');
        reply_positive(['redirect' => $redirect ], "Book Updated Successfully.");
    }
    else{
        reply_negitive('Failed to Update Book.');
    }
}
function delete_book(){
    global $wpdb;
    $table = $wpdb->prefix . 'book_books';

    if(!isset($_REQUEST['book_id'])) reply_negitive('Book ID is required.');
    
    $where['id'] = $_REQUEST['book_id'];

    $delete = $wpdb->delete($table, $where, ['%d']);
    
    if( $delete ){
        reply_positive('', "Book Deleted Successfully.");
    }
    else{
        reply_negitive('Failed to Delete Book.');
    }
}
function add_author(){
    global $wpdb;
    $table = $wpdb->prefix . 'book_authors';
    
    if(!isset($_REQUEST['name'])) reply_negitive("Book name is Required.");
    if(!isset($_REQUEST['fb_link'])) reply_negitive("FB Link is Required.");
    if(!isset($_REQUEST['about'])) reply_negitive("Book About information is Required.");
    
    $data['name'] = $_REQUEST['name'];
    $data['fb_link'] = $_REQUEST['fb_link'];
    $data['about'] = $_REQUEST['about'];

    $format = ['%s', '%s', '%s'];

    if( $wpdb->insert($table, $data, $format) ){
        reply_positive(['insert_id' => $wpdb->insert_id], "Author added Successfully.");
    }
    else{
        reply_negitive('Failed to add New Author.');
    }
}
function edit_author(){
    global $wpdb;
    $table = $wpdb->prefix . 'book_authors';
    if(!isset($_REQUEST['author_id'])) reply_negitive("Author ID is Required.");
    if(!isset($_REQUEST['name'])) reply_negitive("Author name is Required.");
    if(!isset($_REQUEST['fb_link'])) reply_negitive("Facebook Link is Required.");
    if(!isset($_REQUEST['about'])) reply_negitive("Author About information is Required.");
    
    $data['name'] = $_REQUEST['name'];
    $data['fb_link'] = $_REQUEST['fb_link'];
    $data['about'] = $_REQUEST['about'];

    $where['id'] = $_REQUEST['author_id'];

    $update = $wpdb->update($table, $data, $where, ['%s', '%s', '%s'], ['%d']);
    
    if( $update !== false ){
        $redirect = admin_url('admin.php?page=list-book-authors');
        reply_positive(['redirect' => $redirect ], "Author Updated Successfully.");
    }
    else{
        reply_negitive('Failed to Update Author.');
    }
}
function delete_author(){
    global $wpdb;
    $table = $wpdb->prefix . 'book_authors';

    if(!isset($_REQUEST['author_id'])) reply_negitive('Author ID is required.');
    
    $where['id'] = $_REQUEST['author_id'];

    $delete = $wpdb->delete($table, $where, ['%d']);
    
    if( $delete ){
        reply_positive('', "Author Deleted Successfully.");
    }
    else{
        reply_negitive('Failed to Delete Author.');
    }
}