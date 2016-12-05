<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/material-icons.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/adminstyle.css') }}" />
</head>
<body>
    <div id="sib-header-bar" class="col-md-12 col-sm-12 col-xs-12">
        <a id="sib-icon" class="btn">
            <span class="sib-icon-line"></span>
            <span class="sib-icon-line"></span>
            <span class="sib-icon-line"></span>
        </a>
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('admin') }}">{{ $menu }}</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('admin') }}">View All Admin</a></li>
            <li><a href="{{ URL::to('admin/create') }}">Create an Admin</a>
        </ul>
    </div>
    <div id="sib-container">
        <div id="sib-worksheet" class="col-md-9 col-md-offset-3">
            <div class="container">
                <h1>All {{ $menu }}</h1>
                <a class="sib-new-button btn" href="#">New</a>
                <!-- will be used to show any messages -->
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            @foreach($column_list as $colKey => $column)
                                <td class="{{ $column }}">{{ $column }}</td>
                            @endforeach
                            <td>actions</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>

                            <!-- we will also add show, edit, and delete buttons -->
                            <td>

                                <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                <!-- we will add this later since its a little more complicated than the other two buttons -->

                                <!-- show the item (uses the show method found at GET /nerds/{id} -->
                                <a class="btn btn-small btn-info sib-btn-add" href="{{ URL::to('nerds/' . $item->id) }}"><i class="material-icons">playlist_add_check</i></a>

                                <!-- edit this item (uses the edit method found at GET /nerds/{id}/edit -->
                                <a class="btn btn-small btn-warning sib-btn-edit" href="{{ URL::to('admin/' . $item->id . '/edit') }}"><i class="material-icons">mode_edit</i></a>

                                <!-- delete this item (uses the edit method found at GET /nerds/{id}/edit -->
                                <a class="btn btn-small btn-danger sib-btn-delete" href="{{ URL::to('admin/' . $item->id . '/delete') }}"><i class="material-icons">delete</i></a>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="sib-sidebar" class="col-md-3">
            <div class="sib-menu-list list-group">
                @foreach($tables as $key => $table)
                    <a class="sib-menu-item list-group-item" href="{{ URL::to('admin') }}/{{ $menu_keys[$key] }}">{{ $table }}</a>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>