    <div class="container beng-container">

        <div id="beng-action-box">
            <h1>{{ $action_title }} {{ $name }}</h1>
            <label class="beng-actions" id="beng-btn-save"  data-toggle="tooltip" data-placement="bottom" title="Save">
                <i class="material-icons">check</i>
            </label>
            <label class="beng-actions" id="beng-btn-cancel"  data-toggle="tooltip" data-placement="bottom" title="Cancel {{ $action_title }}">
                <i class="material-icons">clear</i>
            </label>
        </div>

        <div class="col-md-6" id="beng-input-sheet">
            <form id="bengkel-form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="text-id" class="col-md-3 col-sm-2 control-label">Id</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control text-center" disabled id="text-id" placeholder="Id" value="{{ $id }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-name" class="col-md-3 col-sm-2 control-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-category" class="col-md-3 col-sm-2 control-label">Category</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="input-category" >
                        <?php $icons = ''; $ids = ''; ?>
                            @foreach ($categories as $catId => $category)
                                <option value="{{ $category['original']['id'] }}">{{ $category['original']['name'] }}</option>
                                <?php $icons .= ($icons==''?'':',') . $category['original']['icon']; 
                                      $ids .= ($ids==''?'':',') . $category['original']['id']; ?>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <img id="cat-icon-preview" src="{{ URL::asset('images/icons/'.$cat_icon) }}" />
                    </div>
                    <input type="hidden" id="cat-ids" name="cat-icons" value="{{ $ids }}" />
                    <input type="hidden" id="cat-icons" name="cat-icons" value="{{ $icons }}" />
                </div>
                <div class="form-group">
                    <label for="input-pictures" class="col-sm-3 control-label">Pictures</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-pictures" placeholder="Pictures">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-lat" class="col-sm-3 control-label">Lat</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-lat" placeholder="Lat">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-lng" class="col-sm-3 control-label">Lng</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-lng" placeholder="Lng">
                    </div>
                </div>
            </form> 
        </div>
        <div class="col-md-6" id="beng-map-view">
        </div>
        <script>
            var map;
            var marker;
            
            function createMarker(latlng){
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
            }

            function initMap() {
                var initLoc = {lat: -7.7884403, lng: 110.3681616};
                map = new google.maps.Map(document.getElementById('beng-map-view'), {
                    center: initLoc,
                    zoom: 12
                });

                marker = new google.maps.Marker({
                    position: initLoc,
                    map: map
                });

                google.maps.event.addListener(map, 'click', function( event ){
                    $('#input-lat').val(event.latLng.lat());
                    $('#input-lng').val(event.latLng.lng());
                    marker.setPosition(event.latLng);
                });
            };
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2B1uaimZdVEjVqypYPunSj-ryVXGBcS4&callback=initMap">
        </script>
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        
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

    var url = "/sibengkel/public/admin/bengkel";

    $icons = $('#cat-icons').val().split(',');
    $ids = $('#cat-ids').val().split(',');
    $icon_list = [];

    for (var i = 0; i < $icons.length; i++) {
        $icon_list[$ids[i]] = $icons[i];
    }

    $('[data-toggle="tooltip"]').tooltip();

    $('#beng-btn-cancel').click(function() {
        $.ajax({
            type : 'get',
            url: url,
            success: function(data) {
                $('#sib-worksheet').html(data.worksheet);
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