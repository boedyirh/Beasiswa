<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Permohonan Beasiswa</h3></div>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>admin/pengajuan_beasiswa/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Permohonan</a>
		</div>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/pengajuan_beasiswa/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 180px" placeholder="Kata kunci ..." >
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>

<?php echo $this->session->flashdata("k");?>

  <table class="display table table-bordered table-striped table-condensed table-hover" id="suratMasuk">
	<thead>
		<tr  bgcolor=#cce6ff>
			<th class="text-center" width="3%">No</th>
			<th class="text-center" width="6%">NIM</th>
			<th class="text-center" width="20%">Nama</th>
			<th class="text-center" width="15%">Program Studi</th>
      <th class="text-center" width="10%">Jenis Beasiswa</th>
      <th class="text-center" width="5%">InputBy</th>
      <th class="text-center" width="5%">Status</th>
			<th class="text-center" width="10%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data)) {
			echo "<tr><td colspan='7'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
      $nourut =1;
			foreach ($data as $b) {
		?>
		<tr>
		     <td class="text-center"> <?php echo $nourut; $nourut++; ?> </td>
                 
     	<td class="text-center"><?php echo $b->MhswID;?></td>
     	<td><?php echo $b->Nama;?></td>
      <td class="text-center"><?php echo $b->NamaProdi;?></td>
      <td class="text-center"><?php echo $b->JenisBeasiswa.'<br>Periode :'.$b->Periode;?></td>
  
   
	 	 	<td class="text-center"><?php echo $b->InputBy;?></td> 
       <?php 
       $StatusAjuan = $b->Status;
          if( $StatusAjuan=='Diajukan')
                              {
                               $stts = "<span title='Telah disetujui untuk diajukan' class='label label-primary'>Diajukan</span>";
                              }
                              else
                              {
                              $stts =$StatusAjuan;
                              }
       
       
       
       
       ?>
      
      
      
        <td class="text-center"><?php echo $stts;?></td>  	
			<td class="text-center" class="ctr" >
				<?php  
					if ($this->session->userdata('admin_level') == "Super Admin") {
				?>
				<div class="btn-group">
					<a href="<?php echo base_URL()?>admin/pengajuan_beasiswa/edt/<?php echo $b->id?>" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Edt</a>
					<a href="<?php echo base_URL()?>admin/pengajuan_beasiswa/rubahstatus/<?php echo $b->id?>" class="btn btn-primary btn-sm" title="Rubah Status" onclick="return confirm('Anda Yakin..?')"><i class="icon-trash icon-remove">  </i> Status Ajuan</a>			
			
				</div>	
				<?php 
				} else {
				?>
				<div class="btn-group">
				<a href="<?php echo base_URL()?>admin/pengajuan_beasiswa/edt/<?php echo $b->id?>" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Edt</a>
					<a href="<?php echo base_URL()?>admin/pengajuan_beasiswa/rubahstatus/<?php echo $b->id?>" class="btn btn-primary btn-sm" title="Rubah Status" onclick="return confirm('Anda Yakin..?')"><i class="icon-trash icon-remove">  </i> Rubah</a>			
					</div>	
				<?php 
				}
				?>
				
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
