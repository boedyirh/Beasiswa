 <style>
.label {
  min-width: 70px !important;
  display: inline-block !important
}
</style>


<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-4"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> Grade Mahasiswa</h3></div>
		<?php 
		if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>admin/grademahasiswa/add" class="btn btn-info"><i class="glyphicon glyphicon-plus-sign"> </i> Tambah Grade</a>
		</div>
		<?php } ?>
		
		<div class="col-md-6">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/grademahasiswa/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 180px" placeholder="Kata kunci  ..." >
				<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-search"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover table-striped">
	<thead>
	  <tr  bgcolor=#cce6ff>
			<th class="text-center" width="10%">No</th>
			<th class="text-center" width="30%">Nama Grade</th>
      <th class="text-center" width="7%">Status</th>
			<th class="text-center" width="25%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data)) {
			echo "<tr><td colspan='8'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
      	$nourut =1;
			foreach ($data as $b) {
		?>
		<tr>
			   <td class="text-center"><?php echo $b->GradeMahasiswaID; ?></td>
			   <td><?php echo $b->Nama; ?></td>
    	   <td class="text-center"><?php echo LabelStatus($b->Status); ?></td>
			<?php 
			if ($this->session->userdata('admin_level') == "a") {
			?>
			<td class="text-center" class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>admin/grademahasiswa/edt/<?php echo $b->GradeMahasiswaID; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?php echo base_URL()?>admin/grademahasiswa/del/<?php echo $b->GradeMahasiswaID?>" class="btn btn-warning btn-sm" onclick="return confirm('Jenis Beasiswa ini akan dihapus..?')">	<i class="icon-trash icon-white"> </i> Hapus</a>
			  
      
      	</div>					
			</td>
			<?php 
			} else {
				echo "<td class='ctr'> -- </td>";
			}
			?>
		</tr>
		<?php 
			$no++;
			}
		}
		?>
	</tbody>
</table>
<center><ul class="pagination"><?php echo $pagi; ?></ul></center>
</div>
