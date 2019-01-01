





<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Proses Persetujuan</h3></div>
	 
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/beasiswa_disetujui/cari" style="margin-top: 0px">
			<div>
      	<?php
      
           $JenisBeasiswa = AmbilSesi('BeasiswaID','beasiswa_disetujui');
        	ComboBoxPenjaringan("JenisBeasiswa", "bsw_jenis", "BeasiswaID", "Nama", $JenisBeasiswa, "JenisID", "form-control","240px","--Jenis Beasiswa--",'0');	
  
     ?>
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
					if ($this->session->userdata('admin_level') == "a") {
				?>
				<div class="btn-group">
              <?php 
         if ($b->Terkunci=='N') { ?>
         
         
					<a href="<?php echo base_URL()?>admin/beasiswa_disetujui/ubahstatus/<?php echo $b->RandomChar?>" class="btn btn-primary btn-sm" title="Ubah Status" ><i class="glyphicon glyphicon-edit">  </i> Edit</a>			
			    <a href="<?php echo base_URL()?>admin/beasiswa_disetujui/kunci/<?php echo $b->RandomChar?>" class="btn btn-warning btn-sm" title="Hapus Data" onclick="return confirm('Data akan dikunci, dan tidak bisa dirubah lagi. Yakin?')"><i class="glyphicon glyphicon-lock">  </i> Kunci</a>
			    	</div>	
         <?php  } else {?>
                         
           <a href="<?php echo base_URL()?>admin/beasiswa_disetujui/bukakunci/<?php echo $b->RandomChar?>" class="btn btn-default btn-sm" title="Buka Kunci" onclick="return confirm('Kunci akan akan dikunci, data akan bisa diubah. Yakin?')"><i class="glyphicon glyphicon-lock">  </i> Buka Kunci</a>
			    	</div>	
         
         <?php
          } } else {
         
         if ($b->Terkunci=='N') { ?>
         
         
					<a href="<?php echo base_URL()?>admin/beasiswa_disetujui/ubahstatus/<?php echo $b->RandomChar?>" class="btn btn-primary btn-sm" title="Ubah Status" ><i class="glyphicon glyphicon-edit">  </i> Edit</a>			
			    <a href="<?php echo base_URL()?>admin/beasiswa_disetujui/kunci/<?php echo $b->RandomChar?>" class="btn btn-warning btn-sm" title="Hapus Data" onclick="return confirm('Data akan dikunci, dan tidak bisa dirubah lagi. Yakin?')"><i class="glyphicon glyphicon-lock">  </i> Kunci</a>
			     	</div>	
         <?php  } else {?>
                         
           <a href="#" class="btn btn-default btn-sm" title="Data Telah Terkunci" ><i class="glyphicon glyphicon-lock">  </i> Terkunci</a>
			    	</div>	
         
         <?php
          }}   
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
