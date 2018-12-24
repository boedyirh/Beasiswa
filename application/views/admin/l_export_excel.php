

<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Download Pengajuan Beasiswa</h3></div>
	 
		<div class="col-md-4"></div>
		<div class="col-md-6">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/export_excel/cari" style="margin-top: 0px">
		 	   		 <?php
             $JenisBeasiswa='xxx';
          		ComboBox("JenisBeasiswa", "bsw_jenis", "Kode", "Nama", $JenisBeasiswa, "JenisID", "form-control","320px","----Jenis Beasiswa-----");
        		echo "</tr>";
           ?>
          
       
      	<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-download-alt"> </i> Download</button>
			</form>
		</div>
	</div>
</div>


<?php echo $this->session->flashdata("k");?>
	
