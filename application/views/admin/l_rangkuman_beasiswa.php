<div class="clearfix">

<div class="panel panel-primary">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-8"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span>Pendaftar Beasiswa</h3></div>
 
		<div class="col-md-3"></div>
 
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover">
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
			echo "<tr><td colspan='9'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
		  $nourut = 1;
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
			<td><?php echo $b->Nama; ?></td>
     
			<td class="text-center"><?php echo $b->Periode;; ?></td>
      <td class="text-center"><?php echo LabelStatus($b->Status); ?></td>
      <td class="text-center"><?php echo $Pendaftar_Matematika; ?></td>
      <td class="text-center"><?php echo $Pendaftar_Ekonomi; ?></td>
      <td class="text-center"><?php echo $Pendaftar_PPKn; ?></td>
      <td class="text-center"><?php echo $Pendaftar_Indo; ?></td>
      <td class="text-center"><?php echo $Pendaftar_Inggris; ?></td>
      
      <td class="text-center"><?php echo $TotalPendaftar; ?></td>
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


<div class="clearfix">

<div class="panel panel-primary">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-8"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> Pendaftar disetujui</h3></div>
 
		<div class="col-md-3"></div>
 
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover">
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
			echo "<tr><td colspan='9'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
		  $nourut = 1;
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
			<td><?php echo $b->Nama; ?></td>
     
			<td class="text-center"><?php echo $b->Periode;; ?></td>
      <td class="text-center"><?php echo LabelStatus($b->Status); ?></td>
      <td class="text-center"><?php echo $Disetujui_Matematika; ?></td>
      <td class="text-center"><?php echo $Disetujui_Ekonomi; ?></td>
      <td class="text-center"><?php echo $Disetujui_PPKn; ?></td>
      <td class="text-center"><?php echo $Disetujui_Indo; ?></td>
      <td class="text-center"><?php echo $Disetujui_Inggris; ?></td>
      <td class="text-center"><?php echo $TotalDisetujui; ?></td>
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