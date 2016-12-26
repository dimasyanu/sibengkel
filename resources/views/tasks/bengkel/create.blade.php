    <div class="container beng-container">  
        <div id="beng-action-box">
            <h1>Create new bengkel</h1>
            <label class="beng-actions" id="beng-btn-save"  data-toggle="tooltip" data-placement="bottom" title="Save">
                <i class="material-icons">check</i>
            </label>
            <label class="beng-actions" id="beng-btn-cancel"  data-toggle="tooltip" data-placement="bottom" title="Cancel">
                <i class="material-icons">clear</i>
            </label>
        </div>

        <div class="col-md-6" id="beng-input-sheet">
            <input type="hidden" id="cat-id" value="" />
            <form id="bengkel-form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="input-name" class="col-md-3 col-sm-2 control-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-name" placeholder="Name" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-category" class="col-md-3 col-sm-2 control-label">Category</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="input-category" >
                        <?php $icons = ''; $ids = ''; $iconDir = URL::asset('images/icons/marker'); ?>
                            @foreach ($categories as $catId => $category)
                                <option value="{{ $category['original']['id'] }}">{{ $category['original']['name'] }}</option>
                                <?php $icons .= ($icons==''?'':',') . $category['original']['icon']; 
                                      $ids .= ($ids==''?'':',') . $category['original']['id']; ?>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <img id="cat-icon-preview" src="" />
                    </div>
                    <input type="hidden" id="cat-icons-dir" name="cat-icons-dir" value="{{ $iconDir }}" />
                    <input type="hidden" id="cat-ids" name="cat-ids" value="{{ $ids }}" />
                    <input type="hidden" id="cat-icons" name="cat-icons" value="{{ $icons }}" />
                </div>
                <div class="form-group">
                    <label for="beng-input-services" class="col-sm-3 control-label">Services</label>
                    <div id="beng-input-services" class="col-sm-6">
                        @foreach($services as $key => $service)
                            <div class="checkbox">
                                <label><input class="input-service" type="checkbox" value="{{ $service['original']['id'] }}" > {{ $service['original']['name'] }} </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-pictures" class="col-sm-3 control-label">Pictures</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-pictures" placeholder="Pictures" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-description" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="description" id="input-description" placeholder="Some description..."></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-lat" class="col-sm-3 control-label">Lat</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-lat" placeholder="Lat" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-lng" class="col-sm-3 control-label">Lng</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="input-lng" placeholder="Lng" value="">
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
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        
    </div>
<script>
$(document).ready(function() {
    if(!window.google||!window.google.maps){
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB2B1uaimZdVEjVqypYPunSj-ryVXGBcS4&callback=initMap';
        document.body.appendChild(script);
    }
    else{
        initMap();
    }
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
    $('#input-category').change(function() {
        $('#cat-icon-preview').attr('src', $('#cat-icons-dir').val() + '/' + $icon_list[$(this).val()]);
    });

    $('#beng-btn-save').click(function() {
        var add_services = [];
        $('.input-service:checked').each(function() {
            add_services.push($(this).val());
        });

        var formData                = {};
        formData['_token']          = $('meta[name="_token"]').attr('content');
        formData['name']            = $('#input-name').val();
        formData['cat_id']          = $('#input-category').val();
        formData['add_services']    = add_services;
        formData['pictures']        = $('#input-pictures').val();
        formData['description']     = $('#input-description').val();
        formData['lat']             = $('#input-lat').val();
        formData['lng']             = $('#input-lng').val();

        $.ajax({
            type: 'post',
            url: url + "/create/0",
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