<div class="modal-content">
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="sib-modal-title" class="modal-title" id="sib-modal-label">Create new service</h4>
    </div>
    
    <div id="sib-modal-body" class="modal-body">
        <form id="modalForm" class="form-horizontal" name="modalForm">
            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input class="form-control" name="name" id="create-service-name" placeholder="Name" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="create-service-description" placeholder="Some description..."></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Icon</label>
            	<div class="col-sm-10">
                    <?php
                        $dir = 'images/icons/';
                        chdir($dir);
                        foreach (glob('*.png') as $key => $icon):
                    ?>
                        <div class="col-sm-4 text-center pick-icon">
                            <img src="{{ URL::asset('images/icons/' . $icon) }}" data-icon="{{ $icon }}" />
                        </div>
                    <?php endforeach; ?>
            	</div>
            </div>
        </form>
        <input type="hidden" id="task-id" name="taskId" value="{{ $id }}">
    </div>

    <div id="sib-modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button id="btn-create-save" type="button" class="btn btn-primary">Save</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.pick-icon').click(function() {
            $('.pick-icon.selected').removeClass('selected');
            $(this).addClass('selected');
        });

        $("#btn-create-save").click(function (e) {
            e.preventDefault();

            var formData = {};

            formData['_token'] = $('meta[name="_token"]').attr('content');
            formData['name'] = $('#create-service-name').val();
            formData['description'] = $('#create-service-description').val();
            formData['icon'] = $('.pick-icon.selected img').data('icon');

            var url = "/sibengkel/public/admin/service";
            
            $task_id = $('#task-id').val();

            $.ajax({
                type: 'post',
                url: url + '/create/' + $task_id,
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
    });
</script>