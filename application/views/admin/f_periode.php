

<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
  
  	$idp		   = $datpil->PeriodeID;
  	$Nama	     = $datpil->Nama;
  	$Status	   = $datpil->Status;
    $Terlihat  = $datpil->Terlihat;
  	$ro        ="readonly";
   
//	$tgl_surat	= $datpil->tgl_surat;
 // $tgl_surat     = date('d-m-Y' , strtotime($tgl_surat));
	 
	
} else {
  	$act		   = "act_add";
  	$idp		   = "";
   	$Nama	     = "";
  	$Status	   = "1";
    $Terlihat	 = "1";
    $ro        = "";      
}
?>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-plus"></span> Penambahan Tahun Periode</h3></div>
	</div>

	<form action="<?php echo base_URL(); ?>admin/periode/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	
	<div class="row-fluid well" style="overflow: hidden">
		
	<div class="col-lg-6">
		<table  class="table-form">
	 
  
  	 <tr><td width="25%">Tahun Periode</td><td><b><input type="text" name="Nama" id="Nama" <?php echo $ro;   ?> tabindex="2"  required value="<?php echo $Nama;   ?>"  style="width: 80px" class="form-control"></b></td></tr>		
	  <tr><td width="20%">Status</td>  <td>
   <select class="form-control required" tabindex="12" style="width: 240px"; id="Status" name="Status">
          
          <option value="1" <?php if($Status=="1") echo 'selected="selected"'; ?>>Aktif</option>
          <option value="0" <?php if($Status=="0") echo 'selected="selected"'; ?>>Non-Aktif</option>
       </select>
     </td></tr>  
     
       <tr><td width="20%">Terlihat</td>  <td>
   <select class="form-control required" tabindex="12" style="width: 240px"; id="Terlihat" name="Terlihat">
         
          <option value="5" <?php if($Terlihat=="5") echo 'selected="selected"'; ?>>Terlihat</option>
          <option value="6" <?php if($Terlihat=="6") echo 'selected="selected"'; ?>>Tidak Terlihat</option>
       </select>
     </td></tr>   
       	<tr><td colspan="2">
		<br><button type="submit" class="btn btn-primary"tabindex="30" ><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a href="<?php echo base_URL(); ?>admin/periode" class="btn btn-success" tabindex="31" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
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
