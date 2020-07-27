<style>
	.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
	.datagrid table {width:100%; border:solid 1px #ccc;}
	table.dataTable thead th {font-weight: normal; border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
	table.dataTable thead th:last-child {border-right: none;}
	.datagrid table tbody td{border-right: solid 1px#ccc;}
	.datagrid table tbody td:last-child{border-right: none;}
	.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
	.dataTables_info{float:left; font-size:10px;}
	.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
	.selected{background:#cccccc !important;}
	.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
	#big_table_processing img{width: 50px;}
	#big_table_processing{background-color: transparent;border: 0px;}
	
	#menu1  {	 padding: 0px 0% 0 8%;  }
#menu1 li {display:inline-block; padding: 0px 2%; line-height:35px;    border-left: solid 1px #ccc; }
#menu1 li:last-child{border-right: solid 1px #ccc;}
#menu1 li a{color:#fff; text-decoration:none; font-size:.9em; text-transform:uppercase; }
#menu1 li:hover{background:#a71a00;}
.active{background:#a71a00;}
.color1{color:#F00;}
header {
    background: #fff;
    border-top: solid 3px #bd2000;
    width: 85%;
    border-bottom: solid 1px #961a00;
    padding: 5px 7.5%;
} 
</style>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBULmzbAb2RGK6kViBw6cgjbyecvfNKIDQ"></script>
<section>
  <?php echo $breadcrumb;
  
  $lat = ($data->latitude == '')? 27.089084478427853 : $data->latitude;
  $lng = ($data->longitude == '')? 27.089084478427853 : $data->longitude;
  //$event_title = ($data->event_title == '')? 'N/A' : $data->event_title;
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
    var latlng = new google.maps.LatLng(28.54901,77.2683132);
    var myOptions = {
        zoom: 8,
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
