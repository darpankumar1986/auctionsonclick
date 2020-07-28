<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBULmzbAb2RGK6kViBw6cgjbyecvfNKIDQ"></script>
<section>
  <?php echo $breadcrumb;
  
  $lat = ($data->latitude == '')? 27.089084478427853 : $data->latitude;
  $lng = ($data->longitude == '')? 27.089084478427853 : $data->longitude;
  $event_title = ($data->event_title == '')? 'N/A' : $data->event_title;
  $property_desc = ($data->PropertyDescription == '')? 'N/A' : $data->PropertyDescription;
  ?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
      <div style="height:500px;width:100%;" id="map_canvas"></div>
         
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
var map;

function initialize() {
	//28.54901,77.2683132
    var latlng = new google.maps.LatLng(<?php echo $lat;?>, <?php echo $lng;?>);
    var myOptions = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
   var marker = new google.maps.Marker({
                    position: new google.maps.LatLng( <?php echo $lat;?>, <?php echo $lng;?>),
                    map: map
                });
        var contentString = '<div id="content" style="width: 250px; height: auto; padding-bottom:5px;"><h1 style="text-align: center; background-color: #e14424; margin-bottom:5px;">Property Detail</h1><br><?php echo trim(preg_replace('/\s+/', ' ', $property_desc));?></div>';
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});

	// To add the marker to the map, call setMap();
	marker.setMap(map);
}
google.maps.event.addDomListener(window, "load", initialize);

</script>
