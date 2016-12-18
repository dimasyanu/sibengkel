<!DOCTYPE html>
<html>
<head>
    <title>SiBengkel</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/material-icons.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/adminstyle.css') }}" />

    <script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
    <div id="sib-header-bar" class="col-md-12 col-sm-12 col-xs-12">
        <img class="sib-header-brand" src="{{ URL::asset('images/bengkelke.png') }}" />
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('admin') }}">{{ $menu }}</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('admin') }}">View All Admin</a></li>
            <li><a href="{{ URL::to('admin/create') }}">Create an Admin</a>
        </ul>
        <!-- Authentication Links -->
        @if (Auth::guest())
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        @else
            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ url('/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        @endif
    </div>
    <div id="sib-container">
        <div id="sib-worksheet" class="col-md-9 col-md-offset-3">
            <div class="container">
                <h1>All {{ $menu }}</h1>
                <a id="sib-btn-create" class="btn" data-toggle="modal" data-target="#sib-modal-create" data-action="create"><i class="material-icons">add</i></a>
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
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td class="text-center">{{ $item->id }}</td>

                                <!-- add show, edit, and delete buttons -->
                                <td>
                                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                                    <!-- show the item (uses the show method found at GET /nerds/{id} -->
                                    <a class="btn btn-small btn-info sib-btn-details" href="#" value="{{ $item->id }}" data-action="show"><i class="material-icons">playlist_add_check</i></a>

                                    <!-- edit this item (uses the edit method found at GET /nerds/{id}/edit -->
                                    <a class="btn btn-small btn-warning sib-btn-edit" data-id="{{ $item->id }}" data-action="edit"><i class="material-icons">mode_edit</i></a>

                                    <!-- delete this item (uses the edit method found at GET /nerds/{id}/edit -->
                                    <a class="btn btn-small btn-danger sib-btn-delete" href="{{ URL::to('admin/' . $item->id . '/delete') }}" data-action="delete"><i class="material-icons">delete</i></a>
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
        </div>
        <div id="sib-sidebar" class="col-md-3">
            <div class="sib-menu-list list-group">
                @foreach($tables as $key => $table)
                    <a class="sib-menu-item list-group-item <?php if(strtolower($table) == $menu) echo 'active'; ?>" href="{{ URL::to('admin') }}/{{ $menu_lower[$key] }}">{{ $table }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <!--///////////////////////////////- Modal -///////////////////////////////-->
    <!-- ADD -->
    @include('tasks.details', ['column_list' => $column_list, 'menu_lower' => $menu_lower, 'items' => $items])
    @include('tasks.create', ['column_list' => $column_list, 'menu_lower' => $menu_lower, 'items' => $items])
    @include('tasks.edit', ['column_list' => $column_list, 'menu_lower' => $menu_lower, 'items' => $items])
    <input type="hidden" id="current-menu" name="current-menu" value="{{ $menu }}">
    <script src="{{ asset('js/ajax-crud.js') }}"></script>
</body>
</html>