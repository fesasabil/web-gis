<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('headerAdmin', $this->data);
?>
<div class="page-header">
  <h1>Update Hospital</h1>
</div>
<form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <?php if($this->session->flashdata('message')) : ?>
            <div class="col-sm-8 col-md-offset-2">
                <div class="form-group">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nama :</label>
      <div class="col-sm-8">
          <input type="text" name="name" class="form-control" value="<?php echo $hospital->name ?>" placeholder="">
            <p class="help-block"><?php  echo form_error('name', '<small class="text-red">', '</small>'); ?></p>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Category :</label>
      <div class="col-sm-5">
    <?php foreach($this->db->get('categories')->result() as $key => $row) : ?>
      <div class="checkbox checkbox-info checkbox-inline">
          <input type="checkbox" value="<?php echo $row->category_id; ?>" name="categories[<?php echo $key ?>]" <?php if($this->madmin->categoryHospital($hospital->id, $row->category_id)) echo 'checked' ?>>
          <label> <?php echo $row->name; ?></label>
      </div>
    <?php endforeach; ?>
      </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>
        <div class="col-sm-5">
            <select name="location" class="form-control">
                <option value="">--Select Location--</option>
                <option value="Jakarta Utara" <?php if($this->input->get('location') == 'Jakarta Utara') echo 'selected'; ?>>Jakarta Utara</option>
                <option value="Jakarta Barat" <?php if($this->input->get('location') == 'Jakarta Barat') echo 'selected'; ?>>Jakarta Barat</option>
                <option value="Jakarta Pusat" <?php if($this->input->get('location') == 'Jakarta Pusat') echo 'selected'; ?>>Jakarta Pusat</option>
                <option value="Jakarta Selatan" <?php if($this->input->get('location') == 'Jakarta Selatan') echo 'selected'; ?>>Jakarta Selatan</option>
                <option value="Jakarta Timur" <?php if($this->input->get('location') == 'Jakarta Timur') echo 'selected'; ?>>Jakarta Timur</option>
            </select>
            <span class="help-block"><?php echo form_error('location', '<small class="text-red">', '</small>'); ?></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Koordinat :</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input id="input-calendar" type="text" name="latitude" class="form-control" value="<?php echo $hospital->latitude ?>" placeholder="latitude">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
            </div>
            <p class="help-block"><?php echo form_error('latitude', '<small class="text-red">', '</small>'); ?></p>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <input id="input-calendar" type="text" name="longitude" class="form-control" value="<?php echo $hospital->longitude ?>" placeholder="longitude">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
            </div>
            <p class="help-block"><?php echo form_error('longitude', '<small class="text-red">', '</small>'); ?></p>
        </div>
        <div class="col-sm-8 col-md-offset-2">
      <?php echo $map['html'] ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Foto :</label>
        <div class="col-sm-4">
           <input type="file" name="photo" class="form-control">
        </div>
        <div class="col-md-4">
          <?php if($hospital->photo != '') : ?>
          <img src="<?php echo base_url("assets/image/{$hospital->photo}") ?>" height="150">
        <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Alamat :</label>
        <div class="col-sm-8">
           <textarea name="alamat" class="form-control" rows="3"><?php echo $hospital->address ?></textarea>
           <p class="help-block"><?php echo form_error('alamat', '<small class="text-red">', '</small>'); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Deskripsi :</label>
        <div class="col-sm-8">
           <textarea name="description" class="form-control" rows="8"><?php echo $hospital->description ?></textarea>
           <p class="help-block"><?php echo form_error('description', '<small class="text-red">', '</small>'); ?></p>
        </div>
    </div>
    <div class="form-group" style="margin-bottom: 50px;">
        <div class="col-sm-6 col-md-offset-3">
            <button type="submit" class="btn btn-lg btn-primary pull-right"><i class="fa fa-save"></i> Save Update</button>
        </div>
    </div>
</form>
<?php
$this->load->view('footerAdmin', $this->data);


/* End of file update-hotel.php */
/* Location: ./application/views/update-hotel.php */