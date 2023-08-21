jQuery(document).ready(function($){
    
    $('.set-draft').on('click', function (event) {
		event.preventDefault();
			job_id = $(this).attr("data-id");
			job_name = $(this).attr("data-itemName");
            job_action = $(this).attr("data-itemAction");
			
            $(".set-delete").attr('data-id', job_id);
            $("#item_name").text(job_name);
	   }
    );

    $('.set-delete').on('click', 
        function (event) {
            event.preventDefault();
            var deleteButtonWidth = $( this ).width()
            if ( $( this ).hasClass( "delete-confirm" ) && !$( this ).hasClass( "clicked" ) && !$( this ).hasClass( "sent" )  ) {

                var job_id = $(this).attr("data-id");
                nonce = ajax_login_object.ctn_nonce;
                var adminURL = ajax_login_object.ajaxurl;
                var deleteButton = $( this );
                var here = this;

                deleteButton.html('<i class="fa fa-refresh fa-spin"></i>').width(deleteButtonWidth);


                $.ajax({
                    type : "post",
                    dataType : "json",
                    url : adminURL,
                    data : {action: "remove_job", job_id : job_id, security: nonce},
                    success: function(response) {
                        if(response.status == "success") {
                            var id = response.job_id;
                            $('#row-'+id).find('td, th').fadeOut('fast', 
                                function(id){ 
                                    $('#row-'+id).remove();                    
                                });  
                            deleteButton.html('Deleted <i class="fa fa-check"></i>').width('auto').removeClass('clicked').attr("disabled", true);;
                        } else {
                             alert("This item could not be deleted")
                        }
                    }
                }) 
            } else {
                $(this).html('Confirm').addClass('delete-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        $(this).removeClass('clicked');
                        next();
                    })

            }
        }
                            
    );

     $(document).on("hidden.bs.modal", "#deleteModal", function () {
        $(".set-delete").attr('data-id', '');
        $("#item_name").text('');
        $(".set-delete").removeClass('clicked').removeClass('delete-confirm').html('Delete').attr("disabled", false);
      });
    
});