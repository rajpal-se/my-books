<?php
if(isset($_GET['author-id'])){

    global $wpdb;
    $table = $wpdb->prefix . 'book_authors';
    $results = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$table} WHERE id=%d", $_GET['author-id'])
    );

    if($results){
        $id = $results->id;
        $name = htmlspecialchars(stripslashes($results->name));
        $fb_link = htmlspecialchars(stripslashes($results->fb_link));
        $about = htmlspecialchars(stripslashes($results->about));
        
        ?>
        <div class="container my-book">
            <div class="row g-0">
                <div><br></div>
                <div class="alert alert-info">
                    <h5>Author Edit Page</h5>
                </div>
                <div class="card p-0 col-md-8 cold-lg-6 m-md-auto">
                    <div class="card-header bg-primary text-white">Update Author Details</div>
                    <div class="card-body">
                        <form class="author-edit" data-author-id='<?= $id ?>'>
                            <div class="row mb-3">
                                <label for="name" class="col-lg-4 col-form-label">Name</label>
                                <div class="col-lg-8">
                                    <input type="text" required class="form-control" id="name" name="name" value="<?= $name ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="fb_link" class="col-lg-4 col-form-label">Facebook Link</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="fb_link" name="fb_link" value="<?= $fb_link ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="about" class="col-lg-4 col-form-label">About</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" id="about" name="about" rows="5"><?= $about ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="offset-sm-4">
                                    <br>
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    else{
        echo '"book-id" NOT found.';
    }
}
else{
    echo 'Please send "book-id".';
}
?>