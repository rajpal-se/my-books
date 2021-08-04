jQuery(document).ready(function() {
    // Public Site
    (function(){
        jQuery(document).on('click', '.enroll_now_btn', function(){
            let action = 'my_book';
            let sub_action = 'enroll_in_book';
            let book_id = jQuery(this).data('id');

            let data = 'action='+action+'&sub_action='+sub_action+'&'+'&book_id='+book_id;

            jQuery.post(mb_ajaxurl, data, function(response){
                if(console_log) console.log(response);
                if(response.status == 1){
                    window.location.reload();
                }
            });
        });
    })();
});