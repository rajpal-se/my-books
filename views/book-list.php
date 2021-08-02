<?php
global $wpdb;
$table = $wpdb->prefix . 'book_books';
$table_author = $wpdb->prefix . 'book_authors';
$select = "{$table}.id, {$table}.name, {$table_author}.name AS author, {$table}.about, {$table}.book_image, {$table}.created_at";
$results = $wpdb->get_results(
    $wpdb->prepare("SELECT {$select} FROM {$table} LEFT JOIN {$table_author} ON {$table}.author_id={$table_author}.id ORDER BY {$table}.id DESC", '')
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
                                    <th>Name</th>
                                    <th>Author</th>
                                    <th>About</th>
                                    <th>Image</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                            ';
                        ?>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        foreach($results as $v){
                            $t = strtotime($v->created_at);
                            $date = date("d-m-Y", $t);
                            $date .= '<br>'.date("h:i:s A", $t);
                            
                            $about = htmlentities(stripslashes($v->about));
                            if(strlen($about) > 22) $about = substr($about, 0, 22) . '...';
                            
                            $edit_url = admin_url('admin.php?page=edit-book&book-id=') . $v->id;
                            $view_book_url = admin_url('admin.php?page=view-book&book-id=') . $v->id;

                            $name = htmlentities(stripslashes($v->name));
                            $author = htmlentities(stripslashes($v->author));
                            $book_image = htmlentities(stripslashes($v->book_image));
                            
                            echo "
                            <tr data-id=\"{$v->id}\">
                                <td>{$i}</td>
                                <td><a href='{$view_book_url}'>{$name}</a></td>
                                <td>{$author}</td>
                                <td>{$about}</td>
                                <td class='text-center'><img src='{$book_image}' style='max-height: 60px; max-width: 60px;'></td>
                                <td>{$date}</td>
                                <td>
                                    <a href='{$edit_url}' class='btn btn-primary mb-1' title='Edit'><i class='dashicons dashicons-edit-large'></i></a>
                                    &nbsp;
                                    <a href='' class='btn btn-danger mb-1 delete-btn' title='Delete' data-id='{$v->id}'><i class='dashicons dashicons-trash'></i></a>
                                </td>
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