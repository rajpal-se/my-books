<?php
global $wpdb;
$table = $wpdb->prefix . 'book_authors';
$results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$table} ORDER BY id DESC", '')
);
?>

<div class="container my-book">
    <div class="row g-0">
        <div><br></div>
        <div class="alert alert-info">
            <h5>Author's List</h5>
        </div>
        <div class="card p-0">
            <div class="card-header bg-primary text-white">All Authors</div>
            <div class="card-body">
                <table id="authors_list" class="display" style="width:100%">
                    <thead>
                        <?php
                        echo $tbody = '
                                <tr>
                                    <th>S No.</th>
                                    <th>Name</th>
                                    <th>Facebook</th>
                                    <th>About</th>
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

                            $about = (strlen($v->about) > 25) ? substr($v->about, 0, 25) . '...' : $v->about;
                            $fb_link = (strlen($v->fb_link) > 25) ? substr($v->fb_link, 0, 25) . '...' : $v->fb_link;
                            
                            $edit_url = admin_url('admin.php?page=edit-book-author&author-id=') . $v->id;
                            $view_author_url = admin_url('admin.php?page=preview-book-author&author-id=') . $v->id;
                            
                            $name = htmlspecialchars(stripslashes($v->name));
                            $fb_link = htmlspecialchars(stripslashes($fb_link));
                            $about = htmlspecialchars(stripslashes($about));
                            $date = stripslashes($date);
                            echo "
                            <tr data-id=\"{$v->id}\">
                                <td>{$i}</td>
                                <td><a href='{$view_author_url}'>{$name}</a></td>
                                <td>{$fb_link}</td>
                                <td>{$about}</td>
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