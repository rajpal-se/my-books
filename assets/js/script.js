jQuery(document).ready(function() {
    let console_log = true;
    (function(){
        jQuery('.my-book table').DataTable();
    })();

    // books
    (function(){
        jQuery('.my-book').on('click', 'form #image', function(){
            let images = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open().on('select', function(){
                let uploadedImages = images.state().get('selection');
                let image = uploadedImages.first().toJSON();
                // console.log();
                jQuery('.my-book form img').attr('src', image.url);
                jQuery('.my-book form input[name="image"]').attr('value', image.url);
            });
        });
        
        // add_book_dummy_data();
        jQuery('.my-book form.book-add').validate({
            submitHandler: function(e){
                let form = jQuery('.my-book form.book-add');
                let action = 'my_book';
                let sub_action = 'add_book';
                let data = 'action='+action+'&sub_action='+sub_action+'&'+form.serialize();
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status = 1){
                        jQuery.notifyBar({
                            html: response.message,
                            delay: 1000,
                            cssClass: 'success',
                            animationSpeed: "normal"
                        });
                        console.log(form[0]);
                        form[0].reset();
                        let icon_url = form.find('img').first().attr('data-url');
                        form.find('img').first().attr('src', icon_url);
                        form.find('input[name="image"]').val(icon_url);
                    }
                });
            }
        });
        jQuery('.my-book form.book-edit').validate({
            submitHandler: function(e){
                let form = jQuery('.my-book form.book-edit');
                let action = 'my_book';
                let sub_action = 'edit_book';
                let book_id = form.first().attr('data-book-id');
                let data = 'action='+action+'&sub_action='+sub_action+'&'+'&book_id='+book_id+'&';
                data += form.serialize();
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status = 1){
                        jQuery.notifyBar({
                            html: response.message,
                            delay: 1000,
                            cssClass: 'success',
                            animationSpeed: "normal",
                            onHide: function(){
                                window.location.reload();
                            }
                        });
                    }
                });
            }
        });
        jQuery('.my-book table#my-book').on('click', '.delete-btn', function(e){
            e.preventDefault();
            
            if(confirm("Are you sure to delete it?")){
                let action = 'my_book';
                let sub_action = 'delete_book';
                let book_id = jQuery(this).data('id');
                let data = 'action='+action+'&sub_action='+sub_action+'&'+'&book_id='+book_id+'&';
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status = 1){
                        window.location.reload();
                    }
                });
            }
        });
    })();

    // Users
    (function(){

    })();
    
    // Authors
    (function(){

    })();
    
} );

function add_book_dummy_data(){
    jQuery('.my-book form.book-add #name').attr('value', 'C Programming');
    jQuery('.my-book form.book-add #author').attr('value', 'Dennis Richite');
    jQuery('.my-book form.book-add #about').html('Learn about C Programming');
}