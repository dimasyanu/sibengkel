<div class="modal-content">
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="sib-modal-title" class="modal-title" id="sib-modal-label">Create new service</h4>
    </div>
    
    <div id="sib-modal-body" class="modal-body">
		Delete <strong>{{ $name }}</strong> permanently?
		<input type="hidden" id="taskId" name="taskId" value="{{ $id }}">
		<input type="hidden" id="current-menu" value="{{ $menu }}">
    </div>

    <div id="sib-modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		<button id="btn-delete-confirm" type="button" class="btn btn-primary">Confirm</button>
    </div>
</div>
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