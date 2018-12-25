

<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	  $act		= "act_edt";
  	  $idp		= $datpil->PemohonID;
	  $ro       = "readonly";
  	  $NamaMhsw = $datpil->Nama;
	  $MhswID	= $datpil->MhswID;
	  $IPK		= $datpil->IPK;
	  $SKSLulus	= $datpil->SKSLulus;
	  $Semester	= $datpil->Semester;
	  $Alamat	= $datpil->Alamat;
	  $NoHP		= $datpil->NoHP;
	  $KodePT	= $datpil->KodePT;
	  $ProdiID	= $datpil->ProdiID;
	  $PekerjaanOrtu	= $datpil->PekerjaanOrtu;  
	  $PenghasilanOrtu	= $datpil->PenghasilanOrtu; 
	  $JenjangStudi	= $datpil->JenjangStudi;
	  $TempatLahir	= $datpil->TempatLahir;
	  $TanggalLahir	= $datpil->TanggalLahir;
	  $Tanggungan	= $datpil->TanggunganOrtu;
	  $Keterangan	= $datpil->Keterangan; 
	  $JenisKelamin	= $datpil->JenisKelamin; 
	  $BeasiswaID   = $datpil->BeasiswaID;     
	  
//	$tgl_surat	= $datpil->tgl_surat;
 // $tgl_surat     = date('d-m-Y' , strtotime($tgl_surat));
	 
	
} else {
		$act		= "act_add";
		$idp		= "";
		$ro			= "";  
		$NamaMhsw	= "";
		$MhswID		= "";
		$IPK		= "";
		$SKSLulus	= "";
		$Semester	= "";
		$Alamat		= "";
		$NoHP		= "";
		$Keterangan	= "";
		$KodePT		= "";
		$ProdiID	= "";
		$Tanggungan	= "";
		$JenjangStudi	= "";
		$TempatLahir	= "";
		$TanggalLahir	= "";
		$PekerjaanOrtu	= "";
		$PenghasilanOrtu= "";
		$JenisKelamin	= ""; 
		$BeasiswaID	= "xxx"; 
	    
}
?>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-user"></span> Pendaftaran Permohonan Beasiswa</h3></div>
	</div>

	<form action="<?php echo base_URL(); ?>admin/pengajuan_beasiswa/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	
	<div class="row-fluid well" style="overflow: hidden">
		
	<div class="col-lg-6">
		<table  class="table-form">
		 <?php
  	echo "<tr><td>Jenis Beasiswa</td><td>";
		ComboBoxPenjaringan("BeasiswaID", "bsw_jenis", "BeasiswaID", "Nama", $BeasiswaID, "BeasiswaID", "form-control","290px","----Jenis Beasiswa-----");
		echo "</tr>";
   ?>
  
  	<tr><td width="25%">Nama Mahasiswa</td><td><b><input type="text" name="NamaMhsw" id="NamaMhsw" <?php echo $ro;   ?> tabindex="2"  required value="<?php echo $NamaMhsw;   ?>" id="dari" style="width: 400px" class="form-control"></b></td></tr>		
	<tr><td width="25%">NIM/NPM</td><td><b><input type="text" name="MhswID" <?php echo $ro;   ?>  id="MhswID" onkeypress="return isNumber(event)" maxlength="8" tabindex="3" required value="<?php echo $MhswID; ?>" id="dari" style="width: 100px" class="form-control"></b></td></tr>		
			<tr><td><hr></td></tr>
    <tr><td width="25%">IPK</td><td><b><input type="text" name="IPK" autocomplete="off" onkeypress="return isNumberKey(this, event);" id="NextStop" tabindex="4"   value="<?php echo $IPK; ?>" id="dari"  maxlength="4" style="width: 60px" class="form-control"></b></td></tr>		
	<tr><td width="25%">SKS Lulus</td><td><b><input type="text" name="SKSLulus" autocomplete="off" onkeypress="return isNumber(event)" maxlength="3" id="SKSLulus" tabindex="5"   value="<?php echo $SKSLulus; ?>" id="dari" style="width: 50px"  class="form-control"></b></td></tr>		
	<tr><td width="25%">Semester</td><td><b><input type="text" name="Semester" autocomplete="off" onkeypress="return isNumber(event)" maxlength="2" id="Semester" value="<?php echo $Semester; ?>" tabindex="6" style="width: 50px" class="form-control"></b></td></tr>
			<tr><td><hr></td></tr>
    <tr><td width="25%">Alamat</td><td><b><input type="text" name="Alamat" id="Alamat" autocomplete="off" tabindex="7"   value="<?php echo $Alamat; ?>" id="dari" style="width: 400px" class="form-control"></b></td></tr>		
	<tr><td width="25%">No HP</td><td><b><input type="text" name="NoHP"  autocomplete="off" onkeypress="return isNumber(event)" maxlength="13" id="NoHP" tabindex="8"   value="<?php echo $NoHP; ?>" id="dari" style="width: 180px" class="form-control"></b></td></tr>		
	<tr><td width="25%">Keterangan</td><td><b><input type="text" name="Keterangan" autocomplete="off" id="Keterangan" value="<?php echo $Keterangan; ?>" tabindex="9" style="width: 400px" class="form-control"></b></td></tr>
			<tr><td><hr></td></tr>
    <tr><td><b><input type="hidden" name="KodePT" id="KodePT" tabindex="72"   value="<?php echo $KodePT; ?>" id="KodePT" style="width: 400px" class="form-control"></b></td></tr>		
 	<tr><td><b><input type="hidden" name="ProdiID" id="ProdiID" tabindex="72"   value="<?php echo $ProdiID; ?>" id="ProdiID" style="width: 400px" class="form-control"></b></td></tr>		
	<tr><td><b><input type="hidden" name="JenjangStudi" id="JenjangStudi" tabindex="72"   value="<?php echo $JenjangStudi; ?>" id="JenjangStudi" style="width: 400px" class="form-control"></b></td></tr>		
			<tr><td><hr></td></tr>
    <tr><td><b><input type="hidden" name="TempatLahir" id="TempatLahir" tabindex="72"   value="<?php echo $TempatLahir; ?>" id="TempatLahir" style="width: 400px" class="form-control"></b></td></tr>		
	<tr><td><b><input type="hidden" name="TanggalLahir" id="TanggalLahir" tabindex="72"   value="<?php echo $TanggalLahir; ?>" id="TanggalLahir" style="width: 400px" class="form-control"></b></td></tr>		
	<tr><td><b><input type="hidden" name="JenisKelamin" id="JenisKelamin" tabindex="72"   value="<?php echo $JenisKelamin; ?>" id="JenisKelamin" style="width: 400px" class="form-control"></b></td></tr>		
	 	  
   
	</table>
	</div>
	
	<div class="col-lg-6">	
	<table  class="table-form">
   	<tr><td><hr></td></tr>
      
     
    <tr><td width="20%">Pekerjaan Ortu</td>  <td>
    <select class="form-control required" tabindex="12" style="width: 240px"; id="PekerjaanOrtu" name="PekerjaanOrtu">
        <option value="xxx">--- Pekerjaan Orang Tua ---</option>
        <option value="1" <?php if($PekerjaanOrtu=="1") echo 'selected="selected"'; ?>>PNS/Pegawai Negara</option>
        <option value="2" <?php if($PekerjaanOrtu=="2") echo 'selected="selected"'; ?>>Pegawai Swasta</option>
		<option value="3" <?php if($PekerjaanOrtu=="3") echo 'selected="selected"'; ?>>Wiraswasta</option>
        <option value="4" <?php if($PekerjaanOrtu=="4") echo 'selected="selected"'; ?>>Anggota TNI/Polri</option>
        <option value="5" <?php if($PekerjaanOrtu=="5") echo 'selected="selected"'; ?>>Petani/Nelayan</option>
		<option value="6" <?php if($PekerjaanOrtu=="6") echo 'selected="selected"'; ?>>Lainnya</option>
    </select>
  </td></tr>  
     
	<tr><td width="25%">Tanggungan</td><td><b><input type="text" name="Tanggungan" autocomplete="off" onkeypress="return isNumber(event)" maxlength="2" id="Tanggungan" tabindex="13"   value="<?php echo $Tanggungan; ?>"  style="width: 50px" class="form-control"></b></td></tr>		
	<tr><td width="25%">Penghasilan</td><td><b><input type="text" name="PenghasilanOrtu" autocomplete="off" onkeyup="this.value=addCommas(this.value)" id="PenghasilanOrtu" maxlength="10" tabindex="14"   value="<?php echo $PenghasilanOrtu; ?>"  style="width: 110px" class="form-control"></b></td></tr>		
	<tr><td><hr></td></tr>
   	<tr><td width="25%">File Surat (Scan)</td><td><b><input type="file" name="file_surat" tabindex="18" class="form-control" style="width: 250px"></b></td></tr>
 	<tr>
	<td colspan="2">
		<br><button type="submit" class="btn btn-primary"tabindex="30" ><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a href="<?php echo base_URL(); ?>admin/pengajuan_beasiswa" class="btn btn-success" tabindex="31" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td>
	</tr>   
    
    
    	
		</table>	
	</div>

	</div>
	
	</form>
