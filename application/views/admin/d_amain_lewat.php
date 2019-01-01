
 <style>
.label {
  min-width: 70px !important;
  display: inline-block !important
}
</style>

<?php
 $PeriodeAktif = gval("t_periode","Status","Nama","1");
?>


<div class="clearfix">

<div class="panel panel-primary">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-8"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span>Pendaftar/Pengajuan Beasiswa Periode <?php echo $PeriodeAktif ; ?></h3></div>
     
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>admin/beasiswa_lewat/cari" style="margin-top: 0px">
			<div>	
      	<?php
         
       	ComboBox("NamaPeriode", "t_periode", "Nama", "Nama", $PeriodeAktif, "PeriodeID", "form-control","130px","--Periode--");	
          ?>   
         
				<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-search"> </i> Tampilkan</button>
		</div>
    	</form>
	 
		<div class="col-md-3"></div>
 
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover table-striped">
	<thead>
	  <tr  bgcolor=#cce6ff>
			<th class="text-center" width="5%">No</th>
			<th class="text-center" width="30%">Nama Beasiswa</th>
       <th class="text-center" width="10%">Periode</th>
       <th class="text-center" width="10%">Status</th>
      <th class="text-center" width="10%">Matematika</th>
			<th class="text-center" width="10">Ekonomi</th>
      <th class="text-center" width="10%">PPKn</th>
      <th class="text-center" width="10%">Bhs Indo</th>
       <th class="text-center" width="10%">Bhs Inggris</th>
     	 
			<th class="text-center" width="10%">Total</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data)) {
			echo "<tr><td colspan='10'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
		  $nourut = 1;
      $xTotalMatematika =0;
      $xTotalEkonomi =0;
      $xTotalIndo =0;
      $xTotalInggris =0;
      $xTotalPPKn =0;
      $xTotalProdi=0;
    	foreach ($data as $b) {
      
      $Pendaftar_Matematika	= $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='84-202' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Pendaftar_Ekonomi		= $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='87-203' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Pendaftar_PPKn		    = $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='87-205' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Pendaftar_Indo		    = $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='88-201' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Pendaftar_Inggris		= $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='88-203' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $TotalPendaftar       = $Pendaftar_Matematika+$Pendaftar_Ekonomi+$Pendaftar_PPKn+ $Pendaftar_Indo+ $Pendaftar_Inggris;
      
     
		?>
		<tr>
			<td class="text-center"><?php echo $nourut;$nourut++; ?></td>
      <td>		<?php
							echo "<a href='".base_URL()."admin/detil_pengajuan/".$b->BeasiswaID."'>".$b->Nama."</a>"
						?>
      </td>      
			 
			<td class="text-center"><?php echo $b->Periode;; ?></td>
      <td class="text-center"><?php echo LabelStatus($b->Status); ?></td>
      <td class="text-center"><?php echo $Pendaftar_Matematika; ?></td>
      <td class="text-center"><?php echo $Pendaftar_Ekonomi; ?></td>
      <td class="text-center"><?php echo $Pendaftar_PPKn; ?></td>
      <td class="text-center"><?php echo $Pendaftar_Indo; ?></td>
      <td class="text-center"><?php echo $Pendaftar_Inggris; ?></td>
      
      <td class="text-center"><span class="label label-primary lb-sm"><?php echo $TotalPendaftar; ?></span></td>
     
		</tr>
		<?php 
			$no++;
      
         
      $xTotalMatematika = $xTotalMatematika+$Pendaftar_Matematika;
      $xTotalEkonomi = $xTotalEkonomi+ $Pendaftar_Ekonomi;
      $xTotalIndo =$xTotalIndo + $Pendaftar_Indo;
      $xTotalInggris =$xTotalInggris + $Pendaftar_Inggris ;
      $xTotalPPKn = $xTotalPPKn+ $Pendaftar_PPKn ;
      $xTotalProdi = $xTotalProdi + $TotalPendaftar;
			}
   
      ?>
     	<td class="text-center"><?php echo ''; ?></td> 
      <td class="text-center"><?php echo ''; ?></td> 
      <td class="text-center"><?php echo ''; ?></td> 
      <td class="text-center"><span class="label label-warna1 lb-sm"><?php echo 'Total'; ?></span></td> 
      <td class="text-center"><?php echo $xTotalMatematika; ?></td> 
      <td class="text-center"><?php echo $xTotalEkonomi; ?></td> 
      <td class="text-center"><?php echo $xTotalPPKn; ?></td> 
      <td class="text-center"><?php echo $xTotalIndo; ?></td>
      <td class="text-center"><?php echo $xTotalInggris; ?></td> 
     <td class="text-center"><span class="label label-warna1 lb-sm"><?php echo $xTotalProdi; ?></span></td>
    <?php   
		}
		?>
	</tbody>
</table>

</div>


<div class="clearfix">

<div class="panel panel-primary">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-8"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> Pendaftar Beasiswa disetujui (Sudah masuk SK) Periode <?php echo $PeriodeAktif ; ?></h3></div>
 
		<div class="col-md-3"></div>
 
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover table-striped">
	<thead>
	  <tr  bgcolor=#cce6ff>
			<th class="text-center" width="5%">No</th>
			<th class="text-center" width="30%">Nama Beasiswa</th>
      <th class="text-center" width="10%">Periode</th>
      <th class="text-center" width="10%">Status</th>
      <th class="text-center" width="10%">Matematika</th>
			<th class="text-center" width="10">Ekonomi</th>
      <th class="text-center" width="10%">PPKn</th>
      <th class="text-center" width="10%">Bhs Indo</th>
      <th class="text-center" width="10%">Bhs Inggris</th>
			<th class="text-center" width="10%">Total</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data)) {
			echo "<tr><td colspan='10'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
		  $nourut = 1;
      $TotalMatematika =0;
      $TotalEkonomi =0;
      $TotalIndo =0;
      $TotalInggris =0;
      $TotalPPKn =0;
      $TotalProdi=0;
      
    	foreach ($data as $b) {
       
      $Disetujui_Matematika	= $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='84-202' and Status='11' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Disetujui_Ekonomi		= $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='87-203' and Status='11' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Disetujui_PPKn		    = $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='87-205' and Status='11' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Disetujui_Indo		    = $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='88-201' and Status='11' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $Disetujui_Inggris		= $this->db->query("SELECT PemohonID FROM bsw_pemohon where ProdiID='88-203' and Status='11' and BeasiswaID='$b->BeasiswaID'  ")->num_rows();
      $TotalDisetujui       = $Disetujui_Matematika+$Disetujui_Ekonomi+$Disetujui_PPKn+ $Disetujui_Indo+ $Disetujui_Inggris;
     
		?>
		<tr>
			<td class="text-center"><?php echo $nourut;$nourut++; ?></td>
		  <td>		<?php
							echo "<a href='".base_URL()."admin/detil_beasiswa/".$b->BeasiswaID."'>".$b->Nama."</a>"
						?>
      </td>   
			<td class="text-center"><?php echo $b->Periode;; ?></td>
      <td class="text-center"><?php echo LabelStatus($b->Status); ?></td>
      <td class="text-center"><?php echo $Disetujui_Matematika; ?></td>
      <td class="text-center"><?php echo $Disetujui_Ekonomi; ?></td>
      <td class="text-center"><?php echo $Disetujui_PPKn; ?></td>
      <td class="text-center"><?php echo $Disetujui_Indo; ?></td>
      <td class="text-center"><?php echo $Disetujui_Inggris; ?></td>
      <td class="text-center"><span class="label label-primary lb-sm"><?php echo $TotalDisetujui; ?></span></td>
		</tr>
		<?php 
			$no++;
      $TotalMatematika = $Disetujui_Matematika +$TotalMatematika;
      $TotalEkonomi = $TotalEkonomi+ $Disetujui_Ekonomi;
      $TotalIndo =$TotalIndo + $Disetujui_Indo;
      $TotalInggris =$TotalInggris + $Disetujui_Inggris ;
      $TotalPPKn = $TotalPPKn+ $Disetujui_PPKn ;
      $TotalProdi = $TotalProdi + $TotalDisetujui;
			}
       ?>
     	<td class="text-center"><?php echo ''; ?></td> 
      <td class="text-center"><?php echo ''; ?></td> 
      <td class="text-center"><?php echo ''; ?></td> 
      <td class="text-center"><span class="label label-warna1 lb-sm"><?php echo 'Total'; ?></span></td> 
      <td class="text-center"><?php echo $TotalMatematika; ?></td> 
      <td class="text-center"><?php echo $TotalEkonomi; ?></td> 
      <td class="text-center"><?php echo $TotalPPKn; ?></td> 
      <td class="text-center"><?php echo $TotalIndo; ?></td>
      <td class="text-center"><?php echo $TotalInggris; ?></td> 
       <td class="text-center"><span class="label label-warna1 lb-sm"><?php echo $TotalProdi; ?></span></td> 
    <?php   
		}
		?>
	</tbody>
</table>

</div>