<div class="clearfix">

<div class="panel panel-primary">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-8"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-cog"></span> Rangkuman Pendaftar Beasiswa</h3></div>
 
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
     	<th class="text-center" width="10%">Kuota</th>
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
		?>
		<tr>
			<td class="text-center"><?php echo $nourut;$nourut++; ?></td>
			<td><?php echo $b->Nama; ?></td>
     
			<td class="text-center"><?php echo $b->Periode;; ?></td>
      <td class="text-center"><?php echo $b->Status;; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
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
     	<th class="text-center" width="10%">Kuota</th>
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
		?>
		<tr>
			<td class="text-center"><?php echo $nourut;$nourut++; ?></td>
			<td><?php echo $b->Nama; ?></td>
     
			<td class="text-center"><?php echo $b->Periode;; ?></td>
      <td class="text-center"><?php echo $b->Status;; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
      <td class="text-center"><?php echo '2018'; ?></td>
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