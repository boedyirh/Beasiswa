

<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	  $act		= "act_edt";
    $idp		= $datpil->SKID;
	  $ro       = "readonly";
    $Periode	= $datpil->Periode;
    $Jumlah	= $datpil->Jumlah;  
    $Keterangan	= $datpil->Keterangan; 
	  $NoSK	= $datpil->NoSK; 
	  $BeasiswaID   = $datpil->BeasiswaID;
    $NamaBeasiswa = gval("bsw_jenis","BeasiswaID","Nama",$BeasiswaID);     
	  $Tgl_SK  = $datpil->Tgl_SK;     
    $Tgl_SK     = date('d-m-Y' , strtotime($Tgl_SK));
	 
	
} else {
		$act		= "act_add";
		$idp		= "";
   	$Keterangan		= "";
    $Jumlah		= "";
		$ro			= "";  
    $Periode= ""; 
		$NoSK	  = "";
    $Tgl_SK	  = "";  
		$BeasiswaID	= "xx"; 
	    
}
?>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Penambahan SK</h3></div>
	</div>

	<form action="<?php echo base_URL(); ?>admin/kumpulan_sk/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	
	<div class="row-fluid well" style="overflow: hidden">
		
	<div class="col-lg-6">
		<table  class="table-form">
   	<tr><td width="35%">Nama Beasiswa</td><td><b><input type="text" name="BeasiswaID" id="BeasiswaID" readonly tabindex="2"  required value="<?php echo $NamaBeasiswa;   ?>"  style="width: 400px" class="form-control"></b></td></tr>		
  
  	<tr><td width="35%">Nomer SK</td><td><b><input type="text" name="NoSK" id="NoSK" tabindex="2"  required value="<?php echo $NoSK;   ?>"  style="width: 400px" class="form-control"></b></td></tr>		
    	<tr><td width="35%">Tanggal SK</td><td><b><input type="text" name="Tgl_SK" tabindex="4" autocomplete="off"  value="<?php echo $Tgl_SK; ?>" id="tgl_mulai" style="width: 130px" class="form-control"></b></td></tr>
    	<tr><td width="35%">Keterangan</td><td><b><input type="text" name="Keterangan" id="Keterangan" tabindex="4"  required value="<?php echo $Keterangan;   ?>"  style="width: 400px" class="form-control"></b></td></tr>		
    	<tr><td width="35%">Jumlah Mahasiswa Sesuai SK </td><td><b><input type="text" name="Jumlah" id="Jumlah" tabindex="5"  required value="<?php echo $Jumlah;   ?>"  style="width: 60px" class="form-control"></b></td></tr>		
  
	</table>
	</div>
	
	<div class="col-lg-6">	
	<table  class="table-form">
   	<tr><td><hr></td></tr>
      
     
  
     
 
   	<tr><td width="25%">File SK (Scan PDF)</td><td><b><input type="file" name="file_surat" tabindex="18" class="form-control" style="width: 250px"></b></td></tr>
 	<tr>
	<td colspan="2">
		<br><button type="submit" class="btn btn-primary"tabindex="30" ><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a href="<?php echo base_URL(); ?>admin/kumpulan_sk" class="btn btn-success" tabindex="31" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td>
	</tr>   
    
    
    	
		</table>	
	</div>

	</div>
	
	</form>
