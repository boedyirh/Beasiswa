<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$idp		= $datpil->id;
	$username	= $datpil->username;
	$password	= "";
	$nama		= $datpil->nama;
	$nip		= $datpil->nip;
	$LevelID		= $datpil->LevelID;
  $ProdiID		= $datpil->ProdiID;
  
 
	
} else {
	$act		= "act_add";
	$idp		= "";
	$username	= "";
	$password	= "";
	$nama		= "";
	$nip		= "";
  $LevelID		= "";
  $ProdiID ="xx";
  
}
?>
<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Manage Admin</h3></div>
</div>
	
	<form action="<?php echo base_URL(); ?>index.php/admin/manage_admin/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	<div class="row-fluid well" style="overflow: hidden">
	
	<div class="col-lg-6">
		<table width="100%" class="table-form">
		<tr><td width="20%">Username</td><td><b><input type="text" name="username" required value="<?php echo $username; ?>" style="width: 300px" class="form-control" tabindex="1" autofocus></b></td></tr>
	
  <?php
   if ($act=='act_edt')
   {
    
   }
   else
   {
   ?>
   	<tr><td width="20%">Password</td><td><b><input type="password" name="password" value="<?php echo $password; ?>" id="dari" style="width: 300px" class="form-control" tabindex="2" ></b></td></tr>		
		<tr><td width="25%">Ulangi Password</td><td><b><input type="password" name="password2" value="<?php echo $password; ?>" id="dari" style="width: 300px" class="form-control" tabindex="3	" ></b></td></tr>
	
     <?php
   }
   
  
  ?>
  
		</table>
	</div>
	
	<div class="col-lg-6">	
		<table width="100%" class="table-form">
		<tr><td width="20%">Nama</td><td><b><input type="text" name="nama" required value="<?php echo $nama; ?>" style="width: 300px" class="form-control" tabindex="4" ></b></td></tr>
		<tr><td width="20%">N I P</td><td><b><input type="text" name="nip" required value="<?php echo $nip; ?>" style="width: 300px" class="form-control" tabindex="5" ></b></td></tr>
 		 <?php
  	echo "<tr><td>Level</td><td>";
		ComboBox("LevelID", "t_level", "LevelID", "Nama", $LevelID, "LevelID", "form-control","210px","----Level-----");
		echo "</tr>";
   ?>
      
      		 <?php
      
  	echo "<tr><td>Akses Prodi</td><td>";
		ComboBox("ProdiID", "t_prodi", "ProdiID", "Nama", $ProdiID, "ProdiID", "form-control","340px","Semua Prodi");
		echo "</tr>";
   ?>
     	<tr><td colspan="2">
		<br><button type="submit" class="btn btn-primary" tabindex="7" ><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a href="<?php echo base_URL(); ?>index.php/admin/manage_admin" class="btn btn-success" tabindex="8" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
		</td></tr>
		</table>
	</div>
	
	</div>
	
	</form>
