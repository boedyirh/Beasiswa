<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Manage Admin</h3></div>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/admin/manage_admin/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/admin/manage_admin/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci ..." required>
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>

<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover table-striped">
	<thead>
			<tr  bgcolor=#cce6ff>
      <th class="text-center" width="5%">No</th>
			<th class="text-center" width="5%">ID</th>
			<th class="text-center" width="30%">Username</th>
			<th class="text-center" width="30%">Nama, NIP</th>
			<th class="text-center" width="10%">Level</th>
			<th class="text-center" width="25%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data)) {
			echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
      $nourut = 1;
			foreach ($data as $b) {
		?>
		<tr>
    	<td class="text-center" class="ctr"><?php echo $nourut; $nourut++;?></td>
			<td class="text-center" class="ctr"><?php echo $b->id;?></td>
			<td><?php echo $b->username?></td>
			<td><?php echo $b->nama."<br>".$b->nip?></td>
			<td><?php echo $b->level?></td>
			<td class="text-center" class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>index.php/admin/manage_admin/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Edit</a>
          <a href="<?php echo base_URL(); ?>index.php/admin/manage_admin/reset/<?php echo $b->id?>" class="btn btn-warning btn-sm" title="Hapus Data" onclick="return confirm('Anda Yakin..?')"><i class="icon-trash icon-remove">  </i> Reset Password</a>		
				</div>					
			</td>
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
