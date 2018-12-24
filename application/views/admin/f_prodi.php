

<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
  
  	$idp		 = $datpil->id;
   	$ProdiID = $datpil->ProdiID;
  	$Nama	   = $datpil->Nama;
    $KaProdi = $datpil->KaProdi;
  	$Status	 = $datpil->Status;
  	$ro      ="readonly";
   
//	$tgl_surat	= $datpil->tgl_surat;
 // $tgl_surat     = date('d-m-Y' , strtotime($tgl_surat));
	 
	
} else {
	$act		  = "act_add";
	$idp		  = "";
  $ProdiID  = "";
 	$Nama	    = "";
  $KaProdi	= "";
	$Status	  = "1";
  $ro       = "";      
}
?>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-plus"></span> Tambah Program Studi</h3></div>
	</div>

	<form action="<?php echo base_URL(); ?>admin/prodi/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	<div class="row-fluid well" style="overflow: hidden">
		
	<div class="col-lg-6">
		<table  class="table-form">
  	 <tr><td width="25%">ProdiID</td><td><b><input type="text" name="ProdiID" id="ProdiID" <?php echo $ro;   ?> tabindex="2"  required value="<?php echo $ProdiID;   ?>"  style="width: 80px" class="form-control"></b></td></tr>		
  	 <tr><td width="25%">Nama Prodi</td><td><b><input type="text" name="Nama" id="Nama" <?php echo $ro;   ?> tabindex="3"  required value="<?php echo $Nama;   ?>"  style="width: 380px" class="form-control"></b></td></tr>		
   	 <tr><td width="25%">KaProdi</td><td><b><input type="text" name="KaProdi" id="KaProdi" tabindex="4"  required value="<?php echo $KaProdi;   ?>"  style="width: 380px" class="form-control"></b></td></tr>		
   
     <tr><td width="20%">Status</td>  <td>
     <select class="form-control required" tabindex="12" style="width: 200px"; id="Status" name="Status">
          
          <option value="1" <?php if($Status=="1") echo 'selected="selected"'; ?>>Aktif</option>
          <option value="0" <?php if($Status=="0") echo 'selected="selected"'; ?>>Non-Aktif</option>
     </select>
     </td></tr>     
   
    <tr><td colspan="2">
		<br><button type="submit" class="btn btn-primary"tabindex="30" ><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a href="<?php echo base_URL(); ?>admin/prodi" class="btn btn-success" tabindex="31" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
		</td></tr>  
  
		</table>
	</div>
	
	<div class="col-lg-6">	
		<table  class="table-form">
   	 <tr><td><hr></td></tr>
      
 
    
    
    	
		</table>	
	</div>

	</div>
	
	</form>
