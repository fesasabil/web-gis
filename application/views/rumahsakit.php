
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
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nama Rumah Sakit</th>
                    <th>Lat Rumah Sakit</th>
                    <th>Long Rumah Sakit</th>
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
  <script src="<?= base_url()?>assets/leaflet/leaflet.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
  <script src="<?= base_url()?>assets/js/BootSideMenu.js"></script>

  <script type="text/javascript">
    $('#test').BootSideMenu({side:"left", autoClose:false});

    var map = L.map('mapid').setView([-6.2293867,106.6894286], 13);
    var base_url = "<?= base_url()?>";

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    $.getJSON(base_url+"rumahsakit/rumahsakit_json/", function(data){
        $.each(data, function(i, field){

          var v_lat = parseFloat(data[i].rumahsakit_lat);
          var v_long = parseFloat(data[i].rumahsakit_long);
          var icon_rumahsakit = L.icon({
            iconUrl : base_url+'assets/images/rumahsakit.png',
            iconSize : [30, 30]
          });
          
          L.marker([v_long,v_lat], {icon:icon_rumahsakit}).addTo(map)
          .bindPopup(data[i].rumahsakit_nama)
          .openPopup();
        });
      });

      // MENAMBAHKAN TOOL PENCARIAN
  // var searchControl = new L.Control.Search({
  //   layer: layer_ADMINISTRASI, // ISI DENGAN ANAM VARIABEL LAYER
  //   propertyName: 'kab_kot', // isi dengan nama field dari file geojson bali yang akan dijadiakn acuan ketiak melakukan pencarian
  //   HidecircleLocation: false,
  //   moveToLocation: function(latlng, title, map) {
  //     //map.fitBounds( latlng.layer.getBounds() );
  //     var zoom = map.getBoundsZoom(latlng.layer.getBounds());
  //       map.setView(latlng, zoom); // access the zoom
  //   }
  // });

  // searchControl.on('search:locationfound', function(e) {
    
  //   e.layer.setStyle({});
  //   if(e.layer._popup)
  //     e.layer.openPopup();

  // }).on('search:collapsed', function(e) {

  //   featuresLayer.eachLayer(function(layer) {
  //     featuresLayer.resetStyle(layer);
  //   }); 
  // });
  
  // map.addControl( searchControl );  //menambahakn tool pencarian ke tampilan map
  // // menambahkan tools defautl extent
  // L.control.defaultExtent().addTo(map);


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

    function rumahsakit_map(id)
    {
      $.getJSON(base_url+"rumahsakit/detail/"+id, function(data){
        $.each(data, function(i, field){

          var v_lat = parseFloat(data[i].rumahsakit_lat);
          var v_long = parseFloat(data[i].rumahsakit_long);
          var icon_rumahsakit = L.icon({
            iconUrl : base_url+'assets/images/rumahsakit.png',
            iconSize : [30, 30]
          });
          
          L.marker([v_long,v_lat], {icon:icon_rumahsakit}).addTo(map)
          .bindPopup(data[i].rumahsakit_nama)
          .openPopup();
        });
      });
    }
  </script>
</body>
</html>