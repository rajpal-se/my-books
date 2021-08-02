<?php
if(isset($_GET['book-id'])){

    wp_enqueue_media();

    global $wpdb;
    $table = $wpdb->prefix . 'book_books';
    $results = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$table} WHERE id=%d", $_GET['book-id'])
    );

    if($results){
        ?>
        <div class="container my-book">
            <div class="row g-0">
                <div><br></div>
                <div class="alert alert-info">
                    <h5>Book Details</h5>
                </div>
                <div class="card p-0 col-md-8 cold-lg-6 m-md-auto">
                    <div class="card-header bg-primary text-white">Book Information</div>
                    <div class="card-body">
                        <form class="book-edit" data-book-id='<?php echo $_GET['book-id']; ?>'>
                            <div class="row mb-3">
                                <label for="name" class="col-lg-4 col-form-label">Name</label>
                                <div class="col-lg-8">
                                    <input type="text" required class="form-control" id="name" name="name" value="<?= $results->name ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="author" class="col-lg-4 col-form-label">Author</label>
                                <div class="col-lg-8">
                                    <input type="text" required class="form-control" id="author" name="author" value="<?= $results->author ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="about" class="col-lg-4 col-form-label">About</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" required id="about" name="about" rows="5" readonly><?= $results->about ?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-lg-4 col-form-label">Book Image</label>
                                <div class="col-lg-8 d-flex">
                                    <img src="<?= $results->book_image; ?>" data-url="<?= $results->book_image ?>" class="ms-3" style="max-height: 100px; max-width: 100px;">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="created_at" class="col-lg-4 col-form-label">Created At</label>
                                <div class="col-lg-8">
                                    <input type="text" required class="form-control" id="created_at" name="author" value="<?= $results->created_at ?>" readonly>
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