<?php
global $wpdb;
$table = $wpdb->prefix . 'book_books';
$results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$table} ORDER BY id DESC", '')
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

                            $about = (strlen($v->about) > 22) ? substr($v->about, 0, 22) . '...' : $v->about;
                            
                            $edit_url = admin_url('admin.php?page=edit-book&book-id=') . $v->id;
                            $view_book_url = admin_url('admin.php?page=view-book&book-id=') . $v->id;
                            
                            echo "
                            <tr data-id=\"{$v->id}\">
                                <td>{$i}</td>
                                <td><a href='{$view_book_url}'>{$v->name}</a></td>
                                <td>{$v->author}</td>
                                <td>{$about}</td>
                                <td class='text-center'><img src='{$v->book_image}' style='max-height: 60px; max-width: 60px;'></td>
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