<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web gis</title>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap -->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">

<link href="<?= base_url()?>assets/css/BootSideMenu.css" rel="stylesheet">

<link href="<?= base_url()?>assets/leaflet/leaflet.css" rel="stylesheet">
<script src="<?= base_url()?>assets/leaflet/leaflet.js"></script>

<link href="<?= base_url()?>assets/leaflet-search/src/leaflet-search.css" rel="stylesheet">
<script src="<?= base_url()?>assets/leaflet-search/src/leaflet-search.js"></script>

<style type="text/css">
  .user{
    padding:5px;
    margin-bottom: 5px;
  }
  #mapid{
    height: 480px;
  }
</style>
</head>
<body>

  <!--Test -->
  <div id="test">
    <h2>Web gis</h2>
    <div class="list-group">
      <a href="<?= base_url()?>rumahsakit/admin" class="list-group-item active">Halaman Admin</a>
    </div>
  </div>
  <!--/Test -->

  <!--Normale contenuto di pagina-->
  <div class="container">
    

    <div class="row">
      <div class="col-md-12">
          <h1>Web gis</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div id="mapid"></div>
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-12">
        <h1 style="font-size:20pt">Data Rumah Sakit</h1>
        <br/>
        <br>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nama Rumah Sakit</th>
                    <th>Lat Rumah Sakit</th>
                    <th>Long Rumah Sakit</th>
                    <th>Location</th>
                    <!-- <th style="width:125px;">Action</th> -->
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <!--Normale contenuto di pagina-->

  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
  <script src="<?= base_url()?>assets/js/BootSideMenu.js"></script>

  <script type="text/javascript">
    $('#test').BootSideMenu({side:"left", autoClose:false});

    var data = [
        <?php foreach($rumahsakit as $key => $value) { ?>
            {"lokasi":[<?= $value->rumahsakit_lat; ?>,<?= $value->rumahsakit_long; ?>], "rumahsakit_nama":"<?= $value->rumahsakit_nama; ?>"},
        <?php } ?>
    ];

    var map = new L.Map('mapid', {zoom: 13, center: new L.latLng(-6.2293867, 106.6894315),     zoomControl: false
});	//set center from first location

L.control.zoom({
    position: 'bottomright'
}).addTo(map);

    map.addLayer(new L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
		zoomOffset: -1
    }));

    var icon1 = L.icon({
        iconUrl: '<?= base_url('assets/images/rumahsakit.png'); ?>',

        iconSize:     [30, 38], // size of the icon
        iconAnchor:   [15, 35], // point of the icon which will correspond to marker's location
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    // CONTROL SEARCH

	var markersLayer = new L.LayerGroup();	//layer contain searched elements
	
	map.addLayer(markersLayer);

	map.addControl( new L.Control.Search({
		position:'topright',		
		layer: markersLayer,
		initial: false,
		zoom: 17,
        collapsed: true
	}) );


	////////////populate map with markers from sample data
	for(i in data) {
		var rumahsakit_nama = data[i].rumahsakit_nama,	//value searched
			lokasi = data[i].lokasi,		//position found
			marker = new L.Marker(new L.latLng(lokasi), {title: rumahsakit_nama, icon: icon1} );//se property searched
		marker.bindPopup('Nama Rumah Sakit: '+ rumahsakit_nama );
		markersLayer.addLayer(marker);
	}


  $(document).ready(function() {

  //datatables
  table = $('#table').DataTable({ 

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo site_url('rumahsakit/list')?>",
          "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
      },
      ],

  });

    });
  </script>
</body>
</html>