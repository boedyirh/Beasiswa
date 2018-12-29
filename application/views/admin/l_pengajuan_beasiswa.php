<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Permohonan</h3></div>
		<div class="col-md-1">
			<a href="<?php echo base_URL(); ?>admin/pengajuan_beasiswa/add" class="btn btn-info"><i class="glyphicon glyphicon-plus-sign"> </i> Tambah</a>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-6">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/pengajuan_beasiswa/cari" style="margin-top: 0px">
			<div>	
        	<?php
      
           $JenisBeasiswa = AmbilSesi('BeasiswaID','pengajuan_beasiswa');
        	ComboBoxPenjaringan("BeasiswaID", "bsw_jenis", "BeasiswaID", "Nama", $JenisBeasiswa, "JenisID", "form-control","190px","--Jenis Beasiswa--");	
          ?> 
            
        <input type="text" class="form-control" name="q" style="width: 110px" placeholder="Nama.." >
				<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-search"> </i> Cari</button>
		</div>
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
      <td class="text-center"><?php echo LabelBeasiswa($b->BeasiswaID).'<br>Periode :'.$b->Periode;?></td>
      <td class="text-center"><?php echo LabelStatus($b->Status);?></td>  	
			<td class="text-center" class="ctr" >
				<?php  
					if ($this->session->userdata('admin_level') == "Super Admin") {
				?>
				<div class="btn-group">
					<a href="<?php echo base_URL()?>admin/pengajuan_beasiswa/edt/<?php echo $b->PemohonID?>" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Edit</a>
		 	
				</div>	
				<?php 
				} else {
				?>
				<div class="btn-group">
				<a href="<?php echo base_URL()?>admin/pengajuan_beasiswa/edt/<?php echo $b->PemohonID?>" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Edi</a>
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
