<div class="container">
    <div class="row">
        <div><br></div>
        <div class="alert alert-info">
            <h5>Book Edit Page</h5>
        </div>
        <div class="card p-0">
            <div class="card-header bg-primary text-white">Update Book</div>
            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="author" class="col-sm-2 col-form-label">Author</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="author" name="author">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="about" class="col-sm-2 col-form-label">About</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="about" name="about"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-sm-2 col-form-label">Upload Image</label>
                        <div class="col-sm-2">
                            <input type="button" class="form-control" id="image" value="Upload">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="offset-sm-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                     
                </form>
            </div>
        </div>
    </div>
</div>