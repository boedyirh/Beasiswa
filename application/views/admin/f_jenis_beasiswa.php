<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$RandomChar		= $datpil->RandomChar;
	$Kode		= $datpil->Kode;
	$Besaran	= $datpil->Besaran;
 	$Nama		= $datpil->Nama;	
	$Tgl_mulai	= $datpil->Tgl_mulai;
	$Tgl_mulai  = date('d-m-Y' , strtotime($Tgl_mulai));
	$Kuota		= $datpil->Kuota;
	$Jenis		= $datpil->Jenis;
 	$Warna		= $datpil->Warna;
	$Periode	= $datpil->Periode;
	$IPKMinimal	= $datpil->IPKMinimal;
	$SKSMinimal	= $datpil->SKSMinimal; 
	$TidakMampu	= $datpil->TidakMampu; 
	$SyaratLain	= $datpil->SyaratLain; 
	$Deskripsi	= $datpil->Deskripsi; 
	$ro 		="readonly";
	$Tgl_selesai	 = $datpil->Tgl_selesai;	
	$Tgl_selesai     = date('d-m-Y' , strtotime($Tgl_selesai));
	$SemesterMinimal = $datpil->SemesterMinimal;
	$AktifKemahasiswaan	= $datpil->AktifKemahasiswaan; 
	$BeasiswaLain		= $datpil->BeasiswaLain; 
  $Status		= $datpil->Status;

  
  		
} else {
	$act		= "act_add";
	$RandomChar		= "";
	$Kode		= "";
	$Nama		= "";
	$Jenis		= "";
	$Periode	= "";
 	$Besaran	= 0;
	$Tgl_mulai	= "";
	$Tgl_selesai= "";
	$Kuota		= "";
	$IPKMinimal	= "";
	$SKSMinimal	= "";
	$TidakMampu	= "";
  $Warna	= "1";
	$SyaratLain	= "";
	$Deskripsi	= "";
	$ro 		= "";
	$BeasiswaLain		= "";
	$SemesterMinimal	= "";
	$AktifKemahasiswaan	= "";
	$Status	= "";
  
  
}
?>
<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"><i class="glyphicon glyphicon-plus"> </i> Tambah/Edit Beasiswa</h3></div>
</div>

<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>admin/jenis_beasiswa/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="RandomChar" value="<?php echo $RandomChar; ?>">
	<table width="100%" class="table-form">
		<tr><td width="20%">Nama Beasiswa</td><td><b><input type="text" name="Nama" tabindex="2" <?php echo $ro; ?>  autocomplete="off" data-toggle="tooltip" data-placement="left" title="Misal : Beasiswa Bidik Misi Periode 2018" required value="<?php echo $Nama; ?>" style="width: 350px" class="form-control"></b></td></tr>		
		<tr><td width="20%">Kode Program Beasiswa</td><td><b><input type="text" maxlength="5" data-toggle="tooltip" data-placement="left" title="Kode 5 digit diisi misal 18BMS = Tahun 2018 Bidik Misi" <?php echo $ro; ?> autocomplete="off" tabindex="1" name="Kode" required value="<?php echo $Kode; ?>" style="width: 80px" class="form-control"></b></td></tr>		                                                                                              
		<tr><td width="20%">Jenis Beasiswa</td>  
		<td>
			<select class="form-control required" tabindex="3" style="width: 180px;  id="Jenis" name="Jenis">
                
                <option value="PPA" <?php if($Jenis=="PPA") echo 'selected="selected"'; ?>>PPA</option>
                <option value="BBM" <?php if($Jenis=="BBM") echo 'selected="selected"'; ?>>BBM</option>
                <option value="BMS" <?php if($Jenis=="BMS") echo 'selected="selected"'; ?>>Bidik Misi Reguler</option>
                <option value="BMK" <?php if($Jenis=="BMK") echo 'selected="selected"'; ?>>Bidik Misi Khusus</option>
                <option value="KOT" <?php if($Jenis=="KOT") echo 'selected="selected"'; ?>>Pemkab</option>
                <option value="YYS" <?php if($Jenis=="YYS") echo 'selected="selected"'; ?>>Yayasan</option>
                <option value="PNP" <?php if($Jenis=="PNP") echo 'selected="selected"'; ?>>Penampung</option>
            </select>
		</td>
		</tr>	
		<tr><td width="25%">Tanggal Mulai</td><td><b><input type="text" name="Tgl_mulai" tabindex="4" autocomplete="off"  value="<?php echo $Tgl_mulai; ?>" id="tgl_mulai" style="width: 130px" class="form-control"></b></td></tr>
		<tr><td width="25%">Tanggal Selesai</td><td><b><input type="text" name="Tgl_selesai" tabindex="5" autocomplete="off"  value="<?php echo $Tgl_selesai; ?>" id="tgl_selesai" style="width: 130px" class="form-control"></b></td></tr>	
		<tr><td width="20%">Periode</td> 
		<td>
			<select class="form-control required" tabindex="7" style="width: 240px"; id="Periode" name="Periode">
              <option value="2015" <?php if($Periode=="2015") echo 'selected="selected"'; ?>>2015</option>
                 <option value="2016" <?php if($Periode=="2016") echo 'selected="selected"'; ?>>2016</option> 
                 <option value="2017" <?php if($Periode=="2017") echo 'selected="selected"'; ?>>2017</option>
                <option value="2018" <?php if($Periode=="2018") echo 'selected="selected"'; ?>>2018</option>
                <option value="2019" <?php if($Periode=="2019") echo 'selected="selected"'; ?>>2019</option>
                <option value="2020" <?php if($Periode=="2020") echo 'selected="selected"'; ?>>2020</option>
            </select>
		</td>
		</tr>
 
		<tr><td><hr></td></tr>
		<tr><td width="20%">Persyaratan Beasiswa</td></tr>
		<tr><td width="20%">IPK Minimal</td><td><b><input type="text" name="IPKMinimal" autocomplete="off" data-toggle="tooltip" data-placement="left" title="Misal 3,00 (Tiga koma nol nol)" onkeypress="return isNumberKey(this,event)" maxlength="4" tabindex="9" value="<?php echo $IPKMinimal; ?>" style="width: 60px" class="form-control"></b></td></tr>
		<tr><td width="20%">Semester Minimal</td><td><b><input type="text" name="SemesterMinimal" autocomplete="off" data-toggle="tooltip" data-placement="left" title="Misal 4" onkeypress="return isNumber(event)" tabindex="10" maxlength="2" value="<?php echo $SemesterMinimal; ?>" style="width: 60px" class="form-control"></b></td></tr>
		<tr><td width="20%">SKS Minimal</td><td><b><input type="text" name="SKSMinimal" autocomplete="off" tabindex="11" onkeypress="return isNumber(event)" maxlength="3" value="<?php echo $SKSMinimal; ?>" style="width: 60px" class="form-control"></b></td></tr>
 		<tr> <td>Aktif Dalam Kegiatan Kemahasiswaan</td>
			<td>  
				<label class="radio-inline">
					<input type="radio" name="AktifKemahasiswaan" tabindex="12" Value="Y" <?php if($AktifKemahasiswaan=="Y") echo "checked" ?> >Disyaratkan
				</label>
				<label class="radio-inline">
					<input type="radio" name="AktifKemahasiswaan" tabindex="12" Value="N" <?php if($AktifKemahasiswaan=="N") echo "checked" ?> >Tidak disyaratkan
				</label>
			</td>
		</tr>
		<tr><td><hr></td></tr>
		<tr> <td>Secara Ekonomi Kurang mampu</td>
		<td>  
			<label class="radio-inline">
				<input type="radio" name="TidakMampu" tabindex="13" Value="Y" <?php if($TidakMampu=="Y") echo "checked" ?> >Disyaratkan
			</label>
			<label class="radio-inline">
				<input type="radio" name="TidakMampu" tabindex="13" Value="N" <?php if($TidakMampu=="N") echo "checked" ?> >Tidak disyaratkan
			</label>
		</td>
		</tr> 
		<tr><td><hr></td></tr>
		<tr> <td>Tidak sedang menerima beasiswa lain</td>
		<td>  
			<label class="radio-inline">
				<input type="radio" name="BeasiswaLain" tabindex="14" Value="Y" <?php if($BeasiswaLain=="Y") echo "checked" ?> >Disyaratkan
			</label>
			<label class="radio-inline">
				<input type="radio" name="BeasiswaLain" tabindex="14" Value="N" <?php if($BeasiswaLain=="N") echo "checked" ?> >Tidak disyaratkan
			</label>
		</td>
		</tr>
  
	<tr><td><hr></td></tr>
	<tr><td width="20%">Persyaratan Lain</td><td><b><textarea tabindex="15" name="SyaratLain"  style="width: 700px; height: 100px" class="form-control"><?php echo $SyaratLain; ?></textarea></b></td></tr>		
	<tr><td width="20%">Deskripsi Singkat Beasiswa</td><td><b><textarea name="Deskripsi" tabindex="16"  style="width: 700px; height: 100px" class="form-control"><?php echo $Deskripsi; ?></textarea></b></td></tr>   
    <tr>
  
  
  	<tr><td width="20%">Warna</td> 
		<td>
			<select class="form-control required" tabindex="7" style="width: 240px"; id="Warna" name="Warna">
                
                <option value="1" <?php if($Warna=="1") echo 'selected="selected"'; ?>>1</option>
                <option value="2" <?php if($Warna=="2") echo 'selected="selected"'; ?>>2</option>
                <option value="3" <?php if($Warna=="3") echo 'selected="selected"'; ?>>3</option>
                <option value="4" <?php if($Warna=="4") echo 'selected="selected"'; ?>>4</option>
                <option value="5" <?php if($Warna=="5") echo 'selected="selected"'; ?>>5</option>
            </select>
		</td>
		</tr>
    
  <tr><td width="20%">Status</td>  
		<td>
			<select class="form-control required" tabindex="3" style="width: 180px;  id="Status" name="Status">
                
                <option value="1" <?php if($Status=="1") echo 'selected="selected"'; ?>>Aktif</option>
                <option value="0" <?php if($Status=="0") echo 'selected="selected"'; ?>>Non-Aktif</option>
                
            </select>
		</td>
		</tr>	  
    
    
	<td colspan="2">
		<br><button tabindex="26" type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a tabindex="26"href="<?php echo base_URL(); ?>admin/jenis_beasiswa" class="btn btn-success">
		<i class="icon icon-arrow-left icon-white"></i>
		Kembali
		</a>
	</td>
	</tr>
	</table>
</form>
</div>
