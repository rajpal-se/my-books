<?php
global $wpdb;
$table_books = $wpdb->prefix . 'book_books';
$table_authors = $wpdb->prefix . 'book_authors';
$table_enrollments = $wpdb->prefix . 'book_enrollments';
$table_users = $wpdb->prefix . 'users';

$user_id = get_current_user_id();

$sql = "
SELECT
    `{$table_enrollments}`.`id` AS `enrollment_id`,
    `$table_books`.`name` AS `book_name`,
    `{$table_authors}`.`name` AS `author`,
    `{$table_users}`.`display_name` AS `user_name`,
    `{$table_users}`.`user_email`,
    `$table_books`.`book_image`,
    `{$table_enrollments}`.`enrolled_at`
FROM `{$table_enrollments}`
LEFT JOIN `{$table_users}`
    ON `{$table_enrollments}`.`user_id` = `{$table_users}`.`ID` 
LEFT JOIN `$table_books`
    ON `{$table_enrollments}`.`book_id` = `$table_books`.`id` 
LEFT JOIN `{$table_authors}`
    ON `{$table_authors}`.`id` = `$table_books`.`author_id`
ORDER BY `enrollment_id` DESC 
";

$enrollments = $wpdb->get_results(
    $wpdb->prepare($sql, '')
);

?>

<div class="container my-book">
    <div class="row g-0">
        <div><br></div>
        <div class="alert alert-info">
            <h5>My Book List</h5>
        </div>
        <div class="card p-0">
            <div class="card-header bg-primary text-white">All Books</div>
            <div class="card-body">
                <table id="my-book" class="display" style="width:100%">
                    <thead>
                        <?php
                        echo $tbody = '
                                <tr>
                                    <th>S No.</th>
                                    <th>Username</th>
                                    <th>Book</th>
                                    <th>Author</th>
                                    <th>Image</th>
                                    <th>Enrolled at</th>
                                </tr>
                            ';
                        ?>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        foreach($enrollments as $v){
                            $t = strtotime($v->enrolled_at);
                            $date = date("d-m-Y", $t);
                            $date .= '<br>'.date("h:i:s A", $t);
                            
                            $enrollment_id = get_field($v->enrollment_id);
                            $book_name = get_field($v->book_name);
                            $user_name = get_field($v->user_name);
                            $user_email = get_field($v->user_email);
                            $author = get_field($v->author);
                            $book_image = get_field($v->book_image, false);
                            
                            echo "
                            <tr data-id=\"{$enrollment_id}\">
                                <td>{$i}</td>
                                <td>
                                    <span class='fw-bold'>{$user_name}</span><br>
                                    <span style='font-size: 0.8rem;'>{$user_email}</span>
                                </td>
                                <td>{$book_name}</td>
                                <td>{$author}</td>
                                <td class='text-center'><img src='{$book_image}' style='max-height: 60px; max-width: 60px;'></td>
                                <td>{$date}</td>
                            </tr>";
                            $i++;
                        }
                        ?>
                        
                    </tbody>
                    <tfoot>
                        <?= $tbody ?>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>