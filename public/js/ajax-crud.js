$(document).ready(function() {
	
	var url = "/sibengkel/public/admin";

	//display modal form for task editing
	$('.sib-btn-edit').click(function(data) {
		$item_id = $(this).data('id');
        $currentMenu = $('#current-menu').val();
        
		$.get(url + '/' + $currentMenu, function(data) {
			$('#item_id').val(data.id);
			$('#item').val(data.task);
			$('#description').val(data.description);
			$('#btn-save').val("update");

			$("#sib-modal").modal('show');
		})
	});

	//display modal form for creating new task
    $('#sib-btn-add').click(function(){
        $('#sib-btn-save').val("add");
        $('#modalForm').trigger("reset");
        $('#sib-modal').modal('show');
    });

    //delete task and remove it from list
    $('.sib-btn-delete').click(function(){
        var item_id = $(this).val();

        $.ajax({

            type: "DELETE",
            url: url + '/' + item_id,
            success: function (data) {
                console.log(data);

                $("#item" + item_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 

        var formData = {
            task: $('#task').val(),
            description: $('#description').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#task_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + task_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var task = '<tr id="task' + data.id + '"><td>' + data.id + '</td><td>' + data.task + '</td><td>' + data.description + '</td><td>' + data.created_at + '</td>';
                task += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-xs btn-delete delete-task" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#tasks-list').append(task);
                }else{ //if user updated an existing record

                    $("#task" + task_id).replaceWith( task );
                }

                $('#frmTasks').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});