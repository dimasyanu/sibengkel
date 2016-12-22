
    <div class="container">
        <h1>All {{ $menu }}</h1>
        <a id="sib-btn-create" class="btn" data-id="0" data-toggle="modal" data-target="#sib-modal-create" data-action="create"><i class="material-icons">add</i></a>
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table id="sib-admin-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td class="text-center">NO.</td>
                    @foreach($column_list as $colKey => $column)
                        <td class="{{ $column }}">{{ strtoupper($column) }}</td>
                    @endforeach
                    <td>ACTIONS</td>
                </tr>
            </thead>
            <tbody>
            <?php $itemCount = 1; ?>
            @if(sizeof($items))
                @foreach($items as $key => $item)
                    <tr>
                        <td class="text-center"><?php echo $itemCount++; ?></td>
                        @foreach($item['original'] as $infoKey => $info)
                            @if($infoKey != 'id' && $infoKey != 'created_at' && $infoKey != 'updated_at')
                                <td>{{ $info }}</td>
                            @endif
                        @endforeach
                        <td class="text-center">{{ $item->id }}</td>

                        <!-- add show, edit, and delete buttons -->
                        <td>
                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->

                            <!-- show the item (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-small btn-info sib-btn-details" href="#" data-id="{{ $item->id }}" data-action="details"><i class="material-icons">playlist_add_check</i></a>

                            <!-- edit this item (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-small btn-warning sib-btn-edit" data-id="{{ $item->id }}" data-action="edit"><i class="material-icons">mode_edit</i></a>

                            <!-- delete this item (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-small btn-danger sib-btn-delete" href="#" data-id="{{ $item->id }}" data-action="delete"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="{{ sizeof($column_list)+2 }}">No data</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <?php 
        $columns = '';
        foreach ($column_list as $key => $column) {
         if($column != 'id') $columns .= (($columns == "" ? '':',') . $column); 
        }
    ?>
    <input type="hidden" id="columns" name="columns" value="{{ $columns }}">

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var url = "/sibengkel/public/admin";
    var currentMenu = $('#current-menu').val();
    var my_url = url + '/' + currentMenu;
    
    //display modal for details
    $('.sib-btn-details').click(function(data) {
        $item_id    = $(this).data('id');
        $action     = $(this).data('action');

        $.ajax({
            type : 'get',
            url: my_url + '/' + $action + '/' + $item_id,
            success: function(data) {
                $('#sib-modal-body').html(data.details);
                $('#sib-modal-footer').html(data.footer);
                $('#sib-btn-save').css('display', 'none');
                $('#sib-modal-title').text('Details');
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
                if(data.menu == 'bengkel')
                    $('#sib-worksheet').html(data.details);
                else{
                    $('#sib-modal-body').html(data.details);
                    $('#sib-modal-footer').html(data.footer);
                    $('#sib-modal-title').text('Edit');
                    $('#sib-modal').modal('show');
                }
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
                if(data.menu == 'bengkel')
                    $('#sib-worksheet').html(data.form);
                else{
                    $('#sib-modal-body').html(data.form);
                    $('#sib-modal-footer').html(data.footer);
                    $('#sib-btn-save').css('display', 'inline');
                    $('#sib-modal-title').text('Create');
                    $('#sib-modal').modal('show');
                }
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
                $('#sib-modal-title').text('Delete');
                $('#sib-modal').modal('show');
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