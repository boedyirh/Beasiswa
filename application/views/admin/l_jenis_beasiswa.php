 <style>
.label {
  min-width: 70px !important;
  display: inline-block !important
}
</style>


<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> Jenis Beasiswa</h3></div>
		<?php 
		if ($this->session->userdata('admin_level') == "a") {
		?>
		<div class="col-md-3">
			<a href="<?php echo base_URL(); ?>admin/jenis_beasiswa/add" class="btn btn-info"><i class="glyphicon glyphicon-plus-sign"> </i> Tambah Beasiswa</a>
		</div>
		<?php } ?>
		
		<div class="col-md-6">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/jenis_beasiswa/cari" style="margin-top: 0px">
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
    	<th class="text-center" width="4%">No</th>
			<th class="text-center" width="10%">Kode</th>
			<th class="text-center" width="25%">Nama</th>
			<th class="text-center" width="10">Periode</th>
     	<th class="text-center" width="6">Pendaftar</th>
     	<th class="text-center" width="6">Kode Warna</th>
     
      <th class="text-center" width="10%">Status</th>
			<th class="text-center" width="15%">Aksi</th>
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
        $total_mhsw		= $this->db->query("SELECT * FROM bsw_pemohon WHERE BeasiswaID='$b->BeasiswaID' and Status='11'")->num_rows();
    
		?>
		<tr>
    <td class="text-center"> <?php echo $nourut; $nourut++; ?> </td>
			<td class="text-center"><?php echo $b->Kode; ?></td>
			<td><?php echo LabelBeasiswa($b->BeasiswaID); ?></td>
			<td class="text-center"><?php echo LabelPeriode($b->Periode); ?></td>
     <td  class="text-center"><?php echo $total_mhsw ; ?></td>
     	<td class="text-center"><?php echo $b->Warna; ?></td>
       
    
            <td class="text-center"><?php echo LabelStatus($b->Status); ?></td>
			<?php 
			if ($this->session->userdata('admin_level') == "a") {
			?>
			<td class="text-center" class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>admin/jenis_beasiswa/edt/<?php echo $b->RandomChar; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?php echo base_URL()?>admin/jenis_beasiswa/del/<?php echo $b->RandomChar?>" class="btn btn-warning btn-sm" onclick="return confirm('Jenis Beasiswa ini akan dihapus..?')">	<i class="icon-trash icon-white"> </i> Hapus</a>
		  
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
