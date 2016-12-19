$(document).ready(function() {

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

	var url = "/sibengkel/public/admin";
    $currentMenu = $('#current-menu').val();
    var my_url = url + '/' + $currentMenu;
    
    //display modal for details
    $('.sib-btn-details').click(function(data) {
        $item_id    = $(this).data('id');
        $action     = $(this).data('action');

        $.ajax({
            type : 'GET',
            url: my_url + '/' + $action + '/' + $item_id,
            success: function(data) {
                $('#sib-modal-body').html(data.details);
                $('#sib-modal-footer').html(data.footer);
                $('#sib-btn-save').css('display', 'none');
                $('#sib-modal-title').text($action);
                $('#sib-modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('xhr : ' + xhr);
                console.log('status : ' + status);
                console.log('error : ' + error);
            }
        });
    });

	//display modal form for task editing
	$('.sib-btn-edit').click(function(data) {
		$item_id    = $(this).data('id');
        $action     = $(this).data('action');
        
        $.ajax({
            type : 'GET',
            url: my_url + '/' + $action + '/' + $item_id,
            success: function(data) {
                $('#sib-modal-body').html(data.details);
                $('#sib-modal-footer').html(data.footer);
                $('#sib-btn-save').css('display', 'inline');
                $('#sib-modal-title').text($action);
                $('#sib-modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('xhr : ' + xhr);
                console.log('status : ' + status);
                console.log('error : ' + error);
            }
        });
	});

	//display modal form for creating new task
    $('#sib-btn-create').click(function(){
        $item_id    = $(this).data('id');
        $action     = $(this).data('action');
        
        $.ajax({
            type : 'GET',
            url: my_url + '/' + $action + '/' + $item_id,
            success: function(data) {
                $('#sib-modal-body').html(data.form);
                $('#sib-modal-footer').html(data.footer);
                $('#sib-btn-save').css('display', 'inline');
                $('#sib-modal-title').text($action);
                $('#sib-modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('xhr : ' + xhr);
                console.log('status : ' + status);
                console.log('error : ' + error);
            }
        });
    });

    //delete task and remove it from list
    $('.sib-btn-delete').click(function(){
        $item_id    = $(this).data('id');
        $action     = $(this).data('action');
        
        $.ajax({
            type : 'GET',
            url: my_url + '/' + $action + '/' + $item_id,
            success: function(data) {
                $('#sib-modal-body').html(data.alert);
                $('#sib-modal-footer').html(data.footer);
                $('#sib-btn-save').html('Confirm');
                $('#sib-btn-close').html('Cancel');
                $('#sib-modal-title').text($action);
                $('#sib-modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('xhr : ' + xhr);
                console.log('status : ' + status);
                console.log('error : ' + error);
            }
        });
    });

    //create new task / update existing task
    $("#sib-btn-save").click(function (e) {
        // console.log("Save");

        e.preventDefault(); 

        var columns = $('#columns').val().split(',');
        var formData = [];
        for (var i = 0; i < columns.length; i++) {
            formData[columns[i]] = $('.input-' + columns[i]).val();
        }

        formData['_token'] = $('meta[name="_token"]').attr('content');

        console.log('formData : ' + formData['_token']);

        // var formData = {
        //     task: $('#task').val(),
        //     description: $('#description').val(),
        // }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#task_id').val();

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + task_id;
        }
        
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(res) {
                console.log("Success");
                $str = '<pre><?php echo "ananan"; ?></pre>';

                $('#sib-worksheet').html($str);
                // $('#warung-plain').load("/warung_plain/{category}");

                $('#frmTasks').trigger("reset");
                $('#myModal').modal('hide')
            },
            error: function(xhr, status, error) {
                console.log('xhr : ' + xhr);
                console.log('status : ' + status);
                console.log('error : ' + error);
            }
        });
    });
});