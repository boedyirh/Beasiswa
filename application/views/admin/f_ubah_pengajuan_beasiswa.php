<?php
$mode		= $this->uri->segment(3);

if ($mode == "rubahstatus" || $mode == "act_rubahstatus") {
	$act		= "act_rubahstatus";
	$idp		= $datpil->PemohonID;
	$BeasiswaID		= $datpil->BeasiswaID;
  $Nama		= $datpil->Nama;	
  $StatusBeasiswa		= $datpil->Status; 
 
  
  		
} else {
	$act		     = "act_add";
	$idp		     = "";
	$BeasiswaID  = "";
	$Nama		     = "";
  $Jenis		   = "";
  $Periode		 = "";
 	$Besaran		 =  0;
  $Tgl_mulai	 = "";
  $Tgl_selesai = "";
  $Kuota		   = "";
  $IPKMinimal	 = "";
  $SKSMinimal	 = "";
  $SemesterMinimal		= "";
  $AktifKemahasiswaan	= "";
  $EkonomiLemah= "";
  $BeasiswaLain= "";
  $SyaratLain	 = "";
  $Deskripsi	 = "";
 
  
  
}
?>
<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px">Rubah Status Beasiswa</h3></div>
</div>

<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>admin/pengajuan_beasiswa/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	<table width="100%" class="table-form">
	  <tr><td width="20%">Kode Program Beasiswa</td><td><b><input type="text" readonly tabindex="1" name="BeasiswaID" required value="<?php echo $BeasiswaID; ?>" style="width: 130px" class="form-control"></b></td></tr>		
  	<tr><td width="20%">Nama Beasiswa</td><td><b><input type="text" name="Nama" readonly tabindex="2" required value="<?php echo $Nama; ?>" style="width: 250px" class="form-control"></b></td></tr>		
    <tr><td width="20%">Status Beasiswa</td>  <td>
   <select class="form-control required" tabindex="7" style="width: 190px"; id="StatusBeasiswa" name="StatusBeasiswa">
      <option value="xxx">--- Status Beasiswa ---</option>
      <option value="10" <?php if($StatusBeasiswa=="10") echo 'selected="selected"'; ?>>Pendaftaran</option>
      <option value="11" <?php if($StatusBeasiswa=="11") echo 'selected="selected"'; ?>>Penetapan</option>
      <option value="12" <?php if($StatusBeasiswa=="12") echo 'selected="selected"'; ?>>Belum Masuk</option>
   </select>
  </td></tr>   
   
  
 
   
   

  
  <tr><td colspan="2">
	<br><button tabindex="26" type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a tabindex="26"href="<?php echo base_URL(); ?>admin/pengajuan_beasiswa" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>
