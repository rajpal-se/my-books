<?php wp_enqueue_media(); ?>
<div class="container my-book">
    <div class="row g-0">
        <div><br></div>
        <div class="alert alert-info">
            <h5>User Add Page</h5>
        </div>
        <div class="card p-0 col-md-8 cold-lg-6 m-md-auto">
            <div class="card-header bg-primary text-white">Add User</div>
            <div class="card-body">
                <form class="book-add">
                    <div class="row mb-3">
                        <label for="name" class="col-lg-4 col-form-label">Name</label>
                        <div class="col-lg-8">
                            <input type="text" required class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="author" class="col-lg-4 col-form-label">Author</label>
                        <div class="col-lg-8">
                            <input type="text" required class="form-control" id="author" name="author">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="about" class="col-lg-4 col-form-label">About</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" required id="about" name="about"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-lg-4 col-form-label">Upload Image</label>
                        <div class="col-lg-8 d-flex">
                            <input type="button" class="form-control btn-primary w-auto px-3 align-self-start" id="image" value="Upload">
                            <img src="<?php echo $book_default_icon_url = MY_BOOK_PLUGIN_URL . 'assets/images/book-icon.png'; ?>" data-url="<?= $book_default_icon_url ?>" class="ms-3" style="max-height: 100px; max-width: 100px;">
                            <input type="hidden" name="image" value="<?= $book_default_icon_url ?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="offset-sm-4">
                            <br>
                            <input type="submit" class="btn btn-primary" value="Add">
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>