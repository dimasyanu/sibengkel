<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
<button id="btn-delete-confirm" type="button" class="btn btn-primary">Confirm</button>

<script>
	$("#btn-delete-confirm").click(function (e) {

        e.preventDefault(); 

        var url = "/sibengkel/public/admin";
		$currentMenu = $('#current-menu').val();
		var my_url = url + '/' + $currentMenu + '/delete';
		
        $task_id = $('#taskId').val();
        
        $.ajax({
            type: 'post',
            url: my_url + '/' + $task_id,
            success: function(data) {
                $('#sib-worksheet').html(data.worksheet);
                $('#sib-modal').modal('hide')
            },
            error: function(xhr, status, error) {
                console.log('xhr : ' + xhr);
                console.log('status : ' + status);
                console.log('error : ' + error);
            }
        });
    });
</script>