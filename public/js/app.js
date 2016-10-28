// CRUD AJAX example: http://solutiisoft.com/laravel-crud-modals-ajax/client
$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip()

    // swap open/close side menu icons
    $('[data-toggle=collapse]').click(function(){
        // toggle icon
        $(this).find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
    });

    // Workorder search by company
    $('.company-dropdown').click(function(){
        $('.search-txtbx').val($(this).attr('data-value'));
    });

    // Delete user confirmation using Sweet Alert
    $('#delete').on('click', function(){
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data\n\n"+$(this).attr("data-label"),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, I'm sure",
            closeOnConfirm: true
        },
        function(){
            $("#delete-form").submit();
        });
    })

    // Image popup + edit description
    $("#ajax-load").on("click",".thumbnail-popup", function(){
        var src = $(this).attr('data-path');
        var description = $(this).attr('data-description');
        var update_route = $(this).attr("data-route");
        var token = $(this).attr("data-token");
        var width = $(window).width();
        var height = $(window).height();
        var image_width = 550;
        if(width <= 480){
            image_width = 280;
        }
        swal({
            title: "<img width='"+image_width+"px' height='auto' src='"+src+"'>",
            text: description,
            customClass: 'swal-wide',
            html: true,
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Edit description",
        },
        function(){
            swal({
                title: "Edit",
                text: "Current: "+description,
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "New description",
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                }
                $.ajax({
                    url: update_route,
                    type: 'PUT',
                    data: {
                        'description' : inputValue,
                        '_token' :token
                    },
                    dataType: 'html',
                    success: function(_response){
                        swal("Successful!", "The description has been updated", "success");
                        $('.image-thumbnail-div').html(_response);
                    },
                    error: function( _response ){
                        swal("Oops!", "Something went wrong, please try again", "error")
                        $('.image-thumbnail-div').html(_response);
                    }
                });
            });
        });
    })

    // Delete images using Sweet Alert
    $("#ajax-load").on("click",".delete-thumbnail", function(){
        var destroy_route = $(this).attr("data-route");
        var token = $(this).attr("data-token");
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this image",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, I'm sure",
            closeOnConfirm: true
        },
        function(){
            // alert(destroy_route);
            $.ajax({
                url: destroy_route,
                type: 'DELETE',
                data: {
                    '_method': 'delete',
                    '_token' :token
                },
                dataType: 'html',
                success: function(_response){
                    // alert(_response.path);
                    // setTimeout(function(){
                        swal("Successful!", "The image has been deleted", "success");
                        $('.image-thumbnail-div').html(_response);
                    // }, 1500);

                },
                error: function( _response ){
                    swal("Oops!", "Something went wrong, please try again", "error")
                    $('.image-thumbnail-div').html(_response);
                }
            });
        });
    })

    // Delete pdf using Sweet Alert
    $("#ajax-load").on("click",".delete-pdf-link", function(){
        var destroy_route = $(this).attr("data-route");
        var token = $(this).attr("data-token");
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this pdf",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, I'm sure",
            closeOnConfirm: true
        },
        function(){
            $.ajax({
                url: destroy_route,
                type: 'DELETE',
                data: {
                    '_method': 'delete',
                    '_token' :token
                },
                dataType: 'html',
                success: function(_response){
                    swal("Successful!", "The pdf has been deleted", "success");
                    $('.pdf-list-div').html(_response);
                },
                error: function( _response ){
                    swal("Oops!", "Something went wrong, please try again", "error")
                    $('.pdf-list-div').html(_response);
                }
            });
        });
    })

});
//# sourceMappingURL=app.js.map
