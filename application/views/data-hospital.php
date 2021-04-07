<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('headerAdmin', $this->data);
?>
<div class="page-header">
	<h1>Data Hospital</h1>
	<form action="" method="get">
	<div class="col-md-4 pull-right">
       <div class="input-group" style="margin-top: -30px;">
           <input id="input-calendar" type="text" name="q" class="form-control" value="<?php echo $this->input->get('q') ?>" placeholder="Pencarian..">
           <span class="input-group-addon"><i class="fa fa-search"></i></span>
       </div>
	</div>
	</form>
</div>
<table class="table table-striped">
  	<thead>
  		<tr>
  			<th>No.</th>
  			<th class="text-center">Nama</th>
  			<th class="text-center">Location</th>
  			<th class="text-center">Latitude</th>
  			<th class="text-center">Longitude</th>
  			<th class="text-center">Alamat</th>
  			<th class="text-center">Description</th>
  		</tr>
  	</thead>
  	<tbody>
  	<?php foreach( $hospital as $row) : ?>
  		<tr>
  			<td><?php echo ++$this->page ?>.</td>
			<td class="td-action" width="250">
				<?php echo $row->name ?>
				<div class="button-action">
					<a href="<?php echo base_url('admin/updatehospital/'.$row->id); ?>">Edit</a> |
					<a href="#" data-id="<?php echo $row->id ?>" class="text-danger delete-hotel">Hapus</a>
				</div>	
			</td>
  			<td><?php echo $row->location ?></td>
  			<td><?php echo $row->latitude ?></td>
  			<td><?php echo $row->longitude ?></td>
  			<td width="200"><small><?php echo word_limiter($row->address, 15) ?></small></td>
  			<td width="200"><small><?php echo word_limiter($row->description, 15) ?></small></td>
  		</tr>
  	<?php endforeach; ?>
  	</tbody>
</table>
<?php if(!$hospital) : ?>
<div class="col-md-5 col-md-offset-3">
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Maa!</strong> Data yang anda cari tidak ditemukan.
	</div>
</div>
<?php endif; ?>
<div class="text-center" style="margin-bottom: 50px;">
	<?php echo $this->pagination->create_links(); ?>
</div>
<?php
$this->load->view('footerAdmin', $this->data);


/* End of file data-hotel.php */
/* Location: ./application/views/data-hotel.php */