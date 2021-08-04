<?php
global $wpdb;
$args = [
    'role' => MY_BOOK_PLUGIN_ROLE,
    'orderby' => 'ID',
    'order' => 'DESC'
];

$users = ( new WP_User_Query( $args ) )->get_results();

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
                <table id="users" class="display" style="width:100%">
                    <thead>
                        <?php
                        echo $tbody = '
                                <tr>
                                    <th>S No.</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            ';
                        ?>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        foreach($users as $v){
                            $data = $v->data;
                            $t = strtotime($data->user_registered);
                            $date = date("d-m-Y", $t);
                            $date .= '<br>'.date("h:i:s A", $t);
                            
                            $id = $data->ID;
                            
                            $username = get_field($data->user_login);
                            $display_name = get_field($data->display_name);
                            $email = get_field($data->user_email);

                            $edit_url = admin_url('user-edit.php?user_id=') . $id . '&redirect_to=' . MY_BOOK_PLUGIN_ROLE;
                            
                            echo "
                            <tr data-id=\"{$id}\">
                                <td>{$i}</td>
                                <td>{$display_name}</td>
                                <td>{$username}</td>
                                <td>{$email}</td>
                                <td>{$date}</td>
                                <td>
                                    <a href='{$edit_url}' class='btn btn-primary mb-1' title='Edit'><i class='dashicons dashicons-edit-large'></i></a>
                                    &nbsp;
                                    <a href='' class='btn btn-danger mb-1 delete-btn' title='Delete' data-id='{$id}'><i class='dashicons dashicons-trash'></i></a>
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