<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
<button id="btn-create-save" type="button" class="btn btn-primary">Save</button>

<script>
	$("#btn-create-save").click(function (e) {

        e.preventDefault(); 

        var columns = $('#columns').val().split(',');
        var formData = {};
        formData['_token'] = $('meta[name="_token"]').attr('content');
        for (var i = 0; i < columns.length; i++) {
            if(columns[i] == 'icon')
                formData['icon'] = $('.pick-icon.selected img').data('icon');
            else
                formData[columns[i]] = $('#create-' + $('#current-menu').val() + '-' + columns[i]).val();
        }
        var url = "/sibengkel/public/admin";
		$currentMenu = $('#current-menu').val();
		var my_url = url + '/' + $currentMenu + '/create';
        $task_id = $('#task-id').val();

        $.ajax({
            type: 'post',
            url: my_url + '/' + $task_id,
            data: formData,
            dataType: 'json',
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