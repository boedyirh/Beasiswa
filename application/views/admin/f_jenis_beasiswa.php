<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$idp		= $datpil->id;
	$Kode		= $datpil->Kode;
  $Besaran		= $datpil->Besaran;
  	
	$Nama		= $datpil->Nama;	
	
  $Tgl_mulai		= $datpil->Tgl_mulai;
  $Tgl_mulai    = date('d-m-Y' , strtotime($Tgl_mulai));
  $Tgl_selesai		= $datpil->Tgl_selesai;	
   $Tgl_selesai    = date('d-m-Y' , strtotime($Tgl_selesai));
  $Kuota		= $datpil->Kuota;
  $Jenis		= $datpil->Jenis;
  $Periode	= $datpil->Periode;
  $IPKMinimal		= $datpil->IPKMinimal;
  $SemesterMinimal		= $datpil->SemesterMinimal;
  $SKSMinimal		= $datpil->SKSMinimal; 
  $AktifKemahasiswaan		= $datpil->AktifKemahasiswaan; 
  $EkonomiLemah		= $datpil->EkonomiLemah; 
  $BeasiswaLain		= $datpil->BeasiswaLain; 
  $SyaratLain		= $datpil->SyaratLain; 
  $Deskripsi		= $datpil->Deskripsi; 
 
  
  		
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
	<div class="panel-heading"><h3 style="margin-top: 5px">Jenis Beasiswa</h3></div>
</div>

<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>admin/jenis_beasiswa/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	<table width="100%" class="table-form">
	
  <tr><td width="20%">Kode Program Beasiswa</td><td><b><input type="text" autocomplete="off" tabindex="1" name="Kode" required value="<?php echo $Kode; ?>" style="width: 130px" class="form-control"></b></td></tr>		
 		
	<tr><td width="20%">Nama Beasiswa</td><td><b><input type="text" name="Nama" tabindex="2"  autocomplete="off" required value="<?php echo $Nama; ?>" style="width: 250px" class="form-control"></b></td></tr>		
                                                                                                  
  <tr><td width="20%">Jenis Beasiswa</td>  <td>
   <select class="form-control required" tabindex="3" style="width: 180px;  id="Jenis" name="Jenis">
                                            
                   
                                             <option value="xxx">--- Jenis Beasiswa ---</option>
                                             <option value="PPA" <?php if($Jenis=="PPA") echo 'selected="selected"'; ?>>PPA</option>
                                             <option value="BBM" <?php if($Jenis=="BBM") echo 'selected="selected"'; ?>>BBM</option>
                                             <option value="BMS" <?php if($Jenis=="BMS") echo 'selected="selected"'; ?>>Bidik Misi</option>
                                             <option value="KOT" <?php if($Jenis=="KOT") echo 'selected="selected"'; ?>>Pemkab</option>
                                             <option value="YYS" <?php if($Jenis=="YYS") echo 'selected="selected"'; ?>>Yayasan</option>
                                             <option value="LLN" <?php if($Jenis=="LLN") echo 'selected="selected"'; ?>>Lain-lain</option>
                                           </select>
  </td></tr>	
  <tr><td width="25%">Tanggal Mulai</td><td><b><input type="text" name="Tgl_mulai" tabindex="4" autocomplete="off" required value="<?php echo $Tgl_mulai; ?>" id="tgl_mulai" style="width: 130px" class="form-control"></b></td></tr>
  <tr><td width="25%">Tanggal Selesai</td><td><b><input type="text" name="Tgl_selesai" tabindex="5" autocomplete="off" required value="<?php echo $Tgl_selesai; ?>" id="tgl_selesai" style="width: 130px" class="form-control"></b></td></tr>	
  <tr><td width="20%">Besaran beasiswa/mhsw</td><td><b><input type="text" name="Besaran" autocomplete="off" tabindex="6" required value="<?php echo number_format($Besaran); ?>" style="width: 100px" onkeyup="this.value=addCommas(this.value)"  class="form-control"></b></td></tr>
  <tr><td width="20%">Periode</td>  <td>
   <select class="form-control required" tabindex="7" style="width: 240px"; id="Periode" name="Periode">
                                             <option value="xxx">--- Periode Beasiswa ---</option>
                                             <option value="2018" <?php if($Periode=="2018") echo 'selected="selected"'; ?>>2018</option>
                                             <option value="2017" <?php if($Periode=="2017") echo 'selected="selected"'; ?>>2017</option>
                                             <option value="2016" <?php if($Periode=="2016") echo 'selected="selected"'; ?>>2016</option>
                                             
                                           </select>
  </td></tr>
  <tr><td width="20%">Kuota</td><td><b><input type="text" name="Kuota" tabindex="8" autocomplete="off" required value="<?php echo $Kuota; ?>" style="width: 100px" class="form-control"></b></td></tr>
  <tr><td><hr/></td></tr>
  <tr><td width="20%">Persyaratan Beasiswa</td></tr>
   <tr><td width="20%">IPK Minimal</td><td><b><input type="text" name="IPKMinimal" autocomplete="off" tabindex="9"required value="<?php echo $IPKMinimal; ?>" style="width: 100px" class="form-control"></b></td></tr>
   <tr><td width="20%">Semester Minimal</td><td><b><input type="text" name="SemesterMinimal" autocomplete="off" tabindex="10"required value="<?php echo $SemesterMinimal; ?>" style="width: 100px" class="form-control"></b></td></tr>
  <tr><td width="20%">SKS Minimal</td><td><b><input type="text" name="SKSMinimal" autocomplete="off" tabindex="11" required value="<?php echo $SKSMinimal; ?>" style="width: 100px" class="form-control"></b></td></tr>
 
  <tr> <td>Aktif Dalam Kegiatan Kemahasiswaan</td>
  <td>  
     <label class="radio-inline">
      <input type="radio" name="AktifKemahasiswaan" tabindex="12" Value="Y" <?php if($AktifKemahasiswaan=="Y") echo "checked" ?> >Disyaratkan
    </label>
   <label class="radio-inline">
      <input type="radio" name="AktifKemahasiswaan" tabindex="12" Value="N" <?php if($AktifKemahasiswaan=="N") echo "checked" ?> >Tidak disyaratkan
    </label>
  </td></tr>
  <tr><td><hr></td></tr>
  <tr> <td>Secara Ekonomi Kurang mampu</td>
  <td>  
     <label class="radio-inline">
      <input type="radio" name="EkonomiLemah" tabindex="13" Value="Y" <?php if($EkonomiLemah=="Y") echo "checked" ?> >Disyaratkan
    </label>
   <label class="radio-inline">
      <input type="radio" name="EkonomiLemah" tabindex="13" Value="N" <?php if($EkonomiLemah=="N") echo "checked" ?> >Tidak disyaratkan
    </label>
  </td></tr> 
  <tr><td><hr></td></tr>
  <tr> <td>Tidak sedang menerima beasiswa lain</td>
  <td>  
     <label class="radio-inline">
      <input type="radio" name="BeasiswaLain" tabindex="14" Value="Y" <?php if($BeasiswaLain=="Y") echo "checked" ?> >Disyaratkan
    </label>
   <label class="radio-inline">
      <input type="radio" name="BeasiswaLain" tabindex="14" Value="N" <?php if($BeasiswaLain=="N") echo "checked" ?> >Tidak disyaratkan
    </label>
  </td></tr>
  
  
	<tr><td width="20%">Persyaratan Lain</td><td><b><textarea tabindex="15" name="SyaratLain" required style="width: 700px; height: 100px" class="form-control"><?php echo $SyaratLain; ?></textarea></b></td></tr>		

  <tr><td width="20%">Deskripsi Singkat Beasiswa</td><td><b><textarea name="Deskripsi" tabindex="16" required style="width: 700px; height: 100px" class="form-control"><?php echo $Deskripsi; ?></textarea></b></td></tr>
  	<tr><td width="25%">Formulir pendaftaran (Scan)</td><td><b><input type="file" name="file_surat" tabindex="18" class="form-control" style="width: 250px"></b></td></tr>
  
  
  <tr><td colspan="2">
	<br><button tabindex="26" type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a tabindex="26"href="<?php echo base_URL(); ?>admin/jenis_beasiswa" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>
