<?php
get_header();
$read_book_id = get_query_var( 'read_book_id' );

global $wpdb;
$table_books = $wpdb->prefix . 'book_books';
$table_authors = $wpdb->prefix . 'book_authors';


// $sql = "
// SELECT
//     `{$table_books}`.`id`,
//     `{$table_books}`.`name`,
//     `{$table_books}`.`about`,
//     `{$table_books}`.`book_image`,
//     `{$table_books}`.`created_at`
// FROM `{$table_books}`
// WHERE `{$table_books}`.`id` = {$read_book_id}
// ";
$sql = "
SELECT
    `{$table_books}`.`id`,
    `{$table_books}`.`name`,
    `{$table_authors}`.`name` AS `author`,
    `{$table_books}`.`about`,
    `{$table_books}`.`book_image`,
    `{$table_books}`.`created_at`
FROM `{$table_books}`
LEFT JOIN {$table_authors}
    ON {$table_books}.`author_id` = {$table_authors}.`id`
WHERE `{$table_books}`.`id` = {$read_book_id}
";
$book = $wpdb->get_row(
    $wpdb->prepare($sql, '')
);

?>
<div class="container">
    <div class="row g-0 bg-light">
        <p class="text-center my-3">
            <a href="<?= home_url(MY_BOOK_PLUGIN_CUSTOM_PAGE) ?>" class="btn btn-primary px-4" role="button" type="button">Go Back (All Books)</a>
        </p>
        <br>
        <div class="card ">
            <h5 class="card-header text-white bg-primary text-center p-3">
                <span class="fs-4">Book: <?= get_field($book->name, 30) ?></span>
                <span class="fs-6">&nbsp;&nbsp;(Author: <?= get_field($book->author, 30) ?>)</span>
            </h5>
            <div class="card-body row justify-content-center g-0">
                <p class="text-end">
                    <span class="fs-6">Created at: <?= get_field($book->created_at, 30) ?></span>
                </p>
                <p class="text-center">
                    <div class="border border-primary text-center p-4 m-3" style="max-width: 200px;">
                        <img src="<?= get_field($book->book_image, false) ?>" style="max-height: 150px;">
                    </div>
                </p>
                <p class="bg-light card-text mx-4 my-3 p-4">
                    <?= get_field($book->about, false) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>