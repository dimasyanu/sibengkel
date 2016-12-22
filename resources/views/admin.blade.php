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
        	<!-- Data table goes here -->
        </div>
        <div id="sib-sidebar" class="col-md-3">
            <div class="sib-menu-list list-group">
                @foreach($menus as $key => $menu)
                    <a id="{{ strtolower($menu) }}" class="sib-menu-item list-group-item <?php if(strtolower($menu) == $curr_menu) echo 'active'; ?>" href="#">{{ $menu }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <!--///////////////////////////////- Modal -///////////////////////////////-->
    <!-- ADD -->
    <div class="modal fade" id="sib-modal" tabindex="-1" role="dialog" aria-labelledby="sib-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="sib-modal-title" class="modal-title" id="sib-modal-label">Modal title</h4>
                </div>
                
                <div id="sib-modal-body" class="modal-body">
                </div>

                <div id="sib-modal-footer" class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="current-menu" name="current-menu" value="{{ $curr_menu }}">

    <script src="{{ asset('js/ajax-crud-view.js') }}"></script>
    <script src="{{ asset('js/ajax-crud-do.js') }}"></script>
    <meta name="_token" content="{!! csrf_token() !!}" />
</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {

        var url = "/sibengkel/public/admin";
        $currentMenu = $('#current-menu').val();
        var my_url = url + '/' + $currentMenu;

        $('.sib-menu-item').each(function() {
            $(this).click(function() {
                $('.sib-menu-item').each(function() {
                    if($(this).hasClass('active'))
                        $(this).removeClass('active');
                });

                $(this).addClass('active');
                loadWorksheet(url + '/' + $(this).attr('id'));
                $('#current-menu').val($(this).attr('id'));
            });
        });

        loadWorksheet(my_url);

        function loadWorksheet(my_url) {
            $.ajax({
                type: 'get',
                url: my_url,
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
        }
    });
</script>>