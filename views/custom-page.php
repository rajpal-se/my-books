<?php
get_header();

global $wpdb;
$table_books = $wpdb->prefix . 'book_books';
$table_authors = $wpdb->prefix . 'book_authors';
$table_enrollments = $wpdb->prefix . 'book_enrollments';

$user_id = get_current_user_id();

$sql = "
SELECT
    DISTINCT `{$table_books}`.`id`,
    `{$table_books}`.`name`,
    `{$table_authors}`.`name` AS `author`,
    `{$table_books}`.`about`,
    `{$table_books}`.`book_image`,
    `{$table_books}`.`created_at`,
    CASE WHEN `enrollments`.`user_id` != '' THEN 1 ELSE 0 END AS enrolled
FROM `{$table_books}`
LEFT JOIN {$table_authors}
    ON {$table_books}.`author_id` = {$table_authors}.`id` 
LEFT JOIN (SELECT `{$table_enrollments}`.`user_id`, `{$table_enrollments}`.`book_id` FROM `{$table_enrollments}` WHERE `{$table_enrollments}`.`user_id` = {$user_id}) `enrollments`
    ON `{$table_books}`.`id` = `enrollments`.`book_id`
ORDER BY `enrolled` DESC, `{$table_books}`.`created_at` DESC
";
$books = $wpdb->get_results(
    $wpdb->prepare($sql, '')
);

?>
<div class="container">
    <div class="row g-0 bg-light">
        <div class="card">
            <h5 class="card-header text-white bg-primary text-center p-3">All Books</h5>
            <div class="card-body row justify-content-center">
                <?php
                    // $books = [1,1,1,1,1,1,1,1,1,1,1,1,1];
                    if(count($books) > 0){
                        foreach($books as $book){
                            ?>  
                                <div class="p-2 col-10 col-sm-6 col-md-4">
                                    <div class="card" style="min-height: 250px;">
                                        <div style="height: 150px;" class="m-3 d-flex justify-content-center align-center">
                                            <img class="card-img-top" style="max-height: 150px; width: unset;" src="<?= get_field($book->book_image, false) ?>">
                                        </div>
                                        <h4 class="card-title text-center"><?= get_field($book->name, false) ?></h4>
                                        <p class="card-text px-3 fs-6" style="text-align: justify;"><?= get_field($book->about, 40) ?></p>
                                        <div class="text-center my-3">
                                            <?php
                                                if( is_user_logged_in() ){
                                                    if($book->enrolled){
                                                        $href = home_url(MY_BOOK_PLUGIN_CUSTOM_PAGE . '/' . $book->id);
                                                        echo '<a href="'.$href.'" type="button" role="button" class="btn btn-success px-4 has-background">Click to Read</a>';
                                                    }
                                                    else{
                                                        echo '<button type="button" role="button" class="btn btn-primary px-4 has-background enroll_now_btn" data-id="'.$book->id.'">Enroll Now</button>';
                                                    }
                                                }
                                                else{
                                                    echo '<a href="' . wp_login_url() . '" type="button" class="btn btn-primary px-4">Login to Read</a>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                        }
                    }
                    else{
                        echo '<h4 class="text-center">No Books Available</h4>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>