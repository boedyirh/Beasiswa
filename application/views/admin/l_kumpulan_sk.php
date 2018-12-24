<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> SK Beasiswa</h3></div>
		<?php 
		if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>admin/kumpulan_sk/add" class="btn btn-info"><i class="glyphicon glyphicon-plus-sign"> </i> Tambah SK</a>
		</div>
		<?php } ?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/v/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 180px" placeholder="Kata kunci  ..." >
				<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-search"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover">
	<thead>
	  <tr  bgcolor=#cce6ff>
			<th class="text-center" width="10%">Kode</th>
			<th class="text-center" width="30%">Nama</th>
           	<th class="text-center" width="6">Terdaftar</th>
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
			foreach ($data as $b) {
		?>
		<tr>
			<td class="text-center"><?php echo $b->Kode; ?></td>
			<td><?php echo $b->Nama; ?></td>
    	 	<td><?php echo "<i><a href='".base_URL()."upload/periode/".$b->File."' target='_blank'>".$b->File."</a>"?></td>
            <td class="text-center"><?php echo $b->Status; ?></td>
			<?php 
			if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			<td class="text-center" class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>admin/kumpulan_sk/edt/<?php echo $b->BeasiswaID; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?php echo base_URL()?>admin/kumpulan_sk/del/<?php echo $b->BeasiswaID?>" class="btn btn-warning btn-sm" onclick="return confirm('Jenis Beasiswa ini akan dihapus..?')">	<i class="icon-trash icon-white"> </i> Hapus</a>
			    	<a href="<?php echo base_URL()?>admin/kumpulan_sk/rubahstatus/<?php echo $b->BeasiswaID?>" class="btn btn-primary btn-sm" onclick="return confirm('Status Beasiswa ini akan dirubah..?')">	<i class="icon-trash icon-white"> </i> RubahStatus</a>
      
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
