<?php
$mode		= $this->uri->segment(3);

if ($mode == "rubahstatus" || $mode == "act_rubahstatus") {
	$act		= "act_rubahstatus";
	$idp		= $datpil->id;
	$Kode		= $datpil->Kode;
  $Nama		= $datpil->Nama;	
  $Jenis		= $datpil->Jenis;
  $StatusBeasiswa		= $datpil->Status; 
 
  
  		
} else {
	$act		= "act_add";
	$idp		= "";
	$Kode		= "";
	$Nama		= "";
  $Jenis		= "";
  $Periode		= "";
 	$Besaran		= 0;
  $Tgl_mulai		= "";
  $Tgl_selesai		= "";
  $Kuota		= "";
  $IPKMinimal		= "";
  $SemesterMinimal		= "";
  $SKSMinimal		= "";
  $AktifKemahasiswaan		= "";
  $EkonomiLemah		= "";
  $BeasiswaLain		= "";
  $SyaratLain		= "";
  $Deskripsi		= "";
 
  
  
}
?>
<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px">Rubah Status Beasiswa</h3></div>
</div>

<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>admin/jenis_beasiswa/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	<table width="100%" class="table-form">
	
  <tr><td width="20%">Kode Program Beasiswa</td><td><b><input type="text" readonly tabindex="1" name="Kode" required value="<?php echo $Kode; ?>" style="width: 130px" class="form-control"></b></td></tr>		
 		
	<tr><td width="20%">Nama Beasiswa</td><td><b><input type="text" name="Nama" readonly tabindex="2" required value="<?php echo $Nama; ?>" style="width: 250px" class="form-control"></b></td></tr>		
                                                                                                  
  
   <tr><td width="20%">Status Beasiswa</td>  <td>
   <select class="form-control required" tabindex="7" style="width: 190px"; id="StatusBeasiswa" name="StatusBeasiswa">
                                             <option value="xxx">--- Status Beasiswa ---</option>
                                             <option value="Aktif" <?php if($StatusBeasiswa=="Aktif") echo 'selected="selected"'; ?>>Aktif</option>
                                             <option value="Selesai" <?php if($StatusBeasiswa=="Selesai") echo 'selected="selected"'; ?>>Selesai</option>
                                             <option value="Non-Aktif" <?php if($StatusBeasiswa=="Non-Aktif") echo 'selected="selected"'; ?>>Non-Aktif</option>
                                             
                                           </select>
  </td></tr>   
   
  
 
   
   

  
  <tr><td colspan="2">
	<br><button tabindex="26" type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a tabindex="26"href="<?php echo base_URL(); ?>admin/jenis_beasiswa" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>
