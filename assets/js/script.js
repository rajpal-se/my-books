jQuery(document).ready(function() {
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
                    if(response.status == 1){
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
                    if(response.status == 1){
                        jQuery.notifyBar({
                            html: response.message,
                            delay: 600,
                            cssClass: 'success',
                            animationSpeed: "normal",
                            onHide: function(){
                                window.location.href = response.data.redirect;
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
                let data = 'action='+action+'&sub_action='+sub_action+'&'+'&book_id='+book_id;
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status == 1){
                        window.location.reload();
                    }
                });
            }
        });
    })();

    // Users
    (function(){
        jQuery('.my-book form.user-add').validate({
            rules : {
                username : {
                    minlength : 5
                },
                password : {
                    minlength : 5
                },
                confirm_password : {
                    minlength : 5,
                    equalTo : "#password"
                }
            },
            submitHandler: function(e){
                let form = jQuery('.my-book form.user-add');
                let action = 'my_book';
                let sub_action = 'mb_add_user';
                let data = 'action='+action+'&sub_action='+sub_action+'&'+form.serialize();
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status == 1){
                        jQuery.notifyBar({
                            html: response.message,
                            delay: 600,
                            cssClass: 'success',
                            animationSpeed: "normal",
                            onHide: function(){
                                window.location.href = response.data.redirect;
                            }
                        });
                        form[0].reset();
                    }
                }).error(function(e){
                    console.log(e);
                });
            }
        });
        jQuery('.my-book table#users').on('click', '.delete-btn', function(e){
            e.preventDefault();
            
            if(confirm("Are you sure to delete it?")){
                let action = 'my_book';
                let sub_action = 'delete_user';
                let user_id = jQuery(this).data('id');
                let data = 'action='+action+'&sub_action='+sub_action+'&'+'&user_id='+user_id;
                
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status == 1){
                        window.location.reload();
                    }
                });
            }
        });
    })();
    
    // Authors
    (function(){
        jQuery('.my-book form.author-add').validate({
            submitHandler: function(e){
                let form = jQuery('.my-book form.author-add');
                let action = 'my_book';
                let sub_action = 'add_author';
                let data = 'action='+action+'&sub_action='+sub_action+'&'+form.serialize();
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status == 1){
                        jQuery.notifyBar({
                            html: response.message,
                            delay: 700,
                            cssClass: 'success',
                            animationSpeed: "normal"
                        });
                        form[0].reset();
                    }
                });
            }
        });
        jQuery('.my-book form.author-edit').validate({
            submitHandler: function(e){
                let form = jQuery('.my-book form.author-edit');
                let action = 'my_book';
                let sub_action = 'edit_author';
                let author_id = form.first().attr('data-author-id');
                let data = 'action='+action+'&sub_action='+sub_action+'&'+'&author_id='+author_id+'&';
                data += form.serialize();
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status == 1){
                        jQuery.notifyBar({
                            html: response.message,
                            delay: 600,
                            cssClass: 'success',
                            animationSpeed: "normal",
                            onHide: function(){
                                window.location.href = response.data.redirect;
                            }
                        });
                    }
                });
            }
        });
        jQuery('.my-book table#authors_list').on('click', '.delete-btn', function(e){
            e.preventDefault();
            
            if(confirm("Are you sure to delete it?")){
                let action = 'my_book';
                let sub_action = 'delete_author';
                let author_id = jQuery(this).data('id');
                let data = 'action='+action+'&sub_action='+sub_action+'&'+'&author_id='+author_id+'&';
                jQuery.post(mb_ajaxurl, data, function(response){
                    if(console_log) console.log(response);
                    if(response.status == 1){
                        window.location.reload();
                    }
                });
            }
        });
    })();
       
} );

function add_book_dummy_data(){
    jQuery('.my-book form.book-add #name').attr('value', 'C Programming');
    jQuery('.my-book form.book-add #author').attr('value', 'Dennis Richite');
    jQuery('.my-book form.book-add #about').html('Learn about C Programming');
}