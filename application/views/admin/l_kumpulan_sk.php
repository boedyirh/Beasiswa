<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-4"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> SK Beasiswa</h3></div>

		<div class="col-md-2 ">
			<a href="<?php echo base_URL(); ?>admin/kumpulan_sk/add" class="btn btn-info "><i class="glyphicon glyphicon-plus-sign"> </i> Tambah SK</a>
		</div>
		
 
		<div class="col-md-6 ">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/v/cari" style="margin-top: 0px">
				<input type="text" class="form-control " name="q" style="width: 180px" placeholder="Kata kunci  ..." >
				<button type="submit" class="btn btn-danger pull right"><i class="glyphicon glyphicon-search"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover">
	<thead>
	  <tr  bgcolor=#cce6ff>
			<th class="text-center" width="10%">No</th>
			<th class="text-center" width="30%">Nama Beasiswa</th>
     	<th class="text-center" width="8%">Periode</th>
      <th class="text-center" width="16">Nomer SK</th> 
      <th class="text-center" width="17%">Link</th>
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
		?>
		<tr>
	 <td class="text-center"> <?php echo $nourut; $nourut++; ?> </td>
			<td><?php echo $b->Nama; ?></td>
      <td class="text-center"><?php echo $b->Periode; ?></td>
      <td><?php echo $b->NoSK; ?></td>
    	<td><?php echo "<i><a href='".base_URL()."upload/SK/".$b->File."' target='_blank'>".$b->File."</a>"?></td>
      
			<?php 
			if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			<td class="text-center" class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>admin/kumpulan_sk/edt/<?php echo $b->SKID; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?php echo base_URL()?>admin/kumpulan_sk/del/<?php echo $b->SKID?>" class="btn btn-warning btn-sm" onclick="return confirm('Jenis Beasiswa ini akan dihapus..?')">	<i class="icon-trash icon-white"> </i> Hapus</a>
		  
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
