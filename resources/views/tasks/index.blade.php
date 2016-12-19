
    
    <div class="container">
        <h1>All {{ $menu }}</h1>
        <a id="sib-btn-create" class="btn" data-id="0" data-toggle="modal" data-target="#sib-modal-create" data-action="create"><i class="material-icons">add</i></a>
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td class="text-center">No.</td>
                    @foreach($column_list as $colKey => $column)
                        <td class="{{ $column }}">{{ $column }}</td>
                    @endforeach
                    <td>actions</td>
                </tr>
            </thead>
            <tbody>
            <?php $itemCount = 1; ?>
            @if(sizeof($items))
                @foreach($items as $key => $item)
                    <tr>
                        <td class="text-center"><?php echo $itemCount++; ?></td>
                        @foreach($item['original'] as $infoKey => $info)
                            @if($infoKey != 'id')
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