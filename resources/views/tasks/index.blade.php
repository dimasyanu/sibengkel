
    <div class="container">
        <div id="sib-index-header">
            <h1>All {{ $menu_title }}</h1>
            <a id="sib-btn-create" data-id="0" data-toggle="modal" data-target="#sib-modal-create" data-action="create"><i class="material-icons">add</i></a>
            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </div>
        <div id="sib-table-container">
            <table id="sib-admin-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">NO.</th>
                        @foreach($columns as $key => $column)
                            <th class="{{ $column }}">{{ strtoupper($column) }}</th>
                        @endforeach
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                <?php $itemCount = 1; ?>
                @if(sizeof($results))
                    @foreach($results as $id => $data)
                        <tr>
                            <td class="text-center"><?php echo $itemCount++; ?></td>
                            @foreach($data as $column => $value)
                                <td>{{ $value }}</td>
                            @endforeach
                            <!-- add show, edit, and delete buttons -->
                            <td>
                                <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                <!-- we will add this later since its a little more complicated than the other two buttons -->

                                <!-- show the item (uses the show method found at GET /nerds/{id} -->
                                <a class="btn btn-small btn-info sib-btn-details" data-id="{{ $id }}" data-action="details"><i class="material-icons">playlist_add_check</i></a>

                                <!-- edit this item (uses the edit method found at GET /nerds/{id}/edit -->
                                <a class="btn btn-small btn-warning sib-btn-edit" data-id="{{ $id }}" data-action="edit"><i class="material-icons">mode_edit</i></a>

                                <!-- delete this item (uses the edit method found at GET /nerds/{id}/edit -->
                                <a class="btn btn-small btn-danger sib-btn-delete" data-id="{{ $id }}" data-action="delete"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="{{ sizeof($columns)+2 }}">No data</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <?php 
        $column_list = '';
        foreach ($columns as $key => $column)
            $column_list .= (($column_list == ""?'':',') . $column); 
    ?>
    <input type="hidden" id="columns" name="columns" value="{{ $column_list }}">

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
                $('.modal-dialog').html(data.details);
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
                    $('.modal-dialog').html(data.details);
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
                    $('.modal-dialog').html(data.form);
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
                $('.modal-dialog').html(data.alert);
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