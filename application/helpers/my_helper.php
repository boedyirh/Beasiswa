<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* ambil database */
function gli($tabel, $field_kunci, $pad) {
	$CI 	=& get_instance();
	$nama	= $CI->db->query("SELECT max($field_kunci) AS last FROM $tabel")->row();
	$data	= (intval($nama->last)) + 1;
	$last	= str_pad($data, $pad, '0', STR_PAD_LEFT);
	return $last;
}
function gval($tabel, $field_kunci, $diambil, $where) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT $diambil FROM $tabel WHERE $field_kunci = '$where'")->row();
	$data	= empty($nama) ? "-" : $nama->$diambil;
	return $data;
}

function CekHakAkses() {
	$CI 	=& get_instance();
  $UserID = $CI->session->userdata('admin_id');
  $LevelUserID = $CI->session->userdata('admin_level');
  $NamaModul =$CI->uri->segment(2);
 	$CekBolehAkses		= $CI->db->query("SELECT id FROM t_menu where LevelID like '%$LevelUserID%' and NamaModul='$NamaModul'      ")->num_rows();
  if ($CekBolehAkses>0) {
  $Boleh ='1';
  }else 
  {
  $Boleh ='0';
  }
  
  return $Boleh;
}	

function CekAdmin() {
	$CI 	=& get_instance();
  $LevelUserID = $CI->session->userdata('admin_level');
  if ($LevelUserID=='a') {
  $Boleh ='1';
  }else 
  {
$Boleh ='0';
  }
  
  return $Boleh;
}	


function LabelStatus($id)
{

if ($id=='0')  //Non-Aktif
   { $StatusLabel = "<span class='label label-default lb-sm'>Non-Aktif</span>"; } 
else if  ($id=='1')  //Aktif 
   { $StatusLabel = "<span class='label label-success lb-sm'>Aktif</span>"; }
else if  ($id=='2')  //Penjaringan
   { $StatusLabel = "<span class='label label-warning lb-sm'>Penjaringan</span>"; }
else if  ($id=='3')  //Seleksi
   { $StatusLabel = "<span class='label label-primary lb-sm'>Telah Seleksi</span>"; }
else if  ($id=='4')  //Selesai
   { $StatusLabel = "<span class='label label-info lb-sm'>Selesai</span>"; }
else if  ($id=='5')  //Terlihat
   { $StatusLabel = "<span class='label label-info lb-sm'>Terlihat</span>"; } 
else if  ($id=='10')  //Pendaftaran
   { $StatusLabel = "<span class='label label-primary lb-sm'>Pendaftaran</span>"; } 
else if  ($id=='11')  //Disetujui
   { $StatusLabel = "<span class='label label-success lb-sm'>Disetujui</span>"; } 
else if  ($id=='12')  //Belum Masuk
   { $StatusLabel = "<span class='label label-danger lb-sm'>Tidak Masuk Kuota</span>"; } 
   
else if  ($id=='a')  //Belum Masuk
   { $StatusLabel = "<span class='label label-danger lb-sm'>Admin System</span>"; }    
else if  ($id=='b')  //Belum Masuk
   { $StatusLabel = "<span class='label label-primary lb-sm'>Admin Beasiswa</span>"; }    
else if  ($id=='c')  //Belum Masuk
   { $StatusLabel = "<span class='label label-success lb-sm'>Admin Prodi</span>"; }    
   
   
   
else       //Non-Aktif
   { $StatusLabel = "<span class='label label-default lb-sm'>Tidak Terlihat</span>"; } 
    
  return $StatusLabel;

}

function CheckDaftarBeasiswa($MhswID,$BeasiswaID,$Periode)
{
     //Pengecekan apakah Mahasiswa sudah PernahDaftar Beasiswa di Gelombang yg Sama dan di Periode yang sama
     $CI =& get_instance();	
      $SdhDaftar = $CI->db->query(" select exists(select PemohonID from bsw_pemohon where BeasiswaID='$BeasiswaID' and MhswID='$MhswID' and Periode='$Periode' limit 1) as Hasil; ")->result();
      $AdaPendaftar=$SdhDaftar[0]->Hasil;
      Return $AdaPendaftar;
}
       
function CheckPenampung($MhswID,$Periode)    //Belum selesai
{
     //Pengecekan apakah Mahasiswa sudah Ada di Penampung Beasiswa di Gelombang yg Sama dan di Periode yang sama
     $CI =& get_instance();	
      $BeasiswaIDPenampung= gval("bsw_jenis", "Periode='$Periode' and Jenis", "BeasiswaID", "PNP");	
     
      $SdhDaftar = $CI->db->query(" select exists(select PemohonID from bsw_pemohon where BeasiswaID='$BeasiswaIDPenampung' and MhswID='$MhswID' and Periode='$Periode' limit 1) as Hasil; ")->result();
      $AdaPendaftar=$SdhDaftar[0]->Hasil;
      Return $AdaPendaftar;
}       
       
function CheckPernahDapatBeasiswa($MhswID)
{
     //Pengecekan apakah Mahasiswa sudah Pernah Mendapat Beasiswa
     $CI =& get_instance();	
      $SdhDaftar = $CI->db->query(" select exists(select PemohonID from bsw_pemohon where MhswID='$MhswID' and Status='11' limit 1) as Hasil; ")->result();
      $AdaPendaftar=$SdhDaftar[0]->Hasil;
      Return $AdaPendaftar;
}
            
       



function AmbilSesi($id,$namaform)
{
$CI =& get_instance();	
$UserLogin = $CI->session->userdata('admin_id');
$Data= gval("daftar_sesi", "NamaForm='$namaform' and UserLogin='$UserLogin' and NamaSesi", "ValueSesi", "$id");	
Return $Data;	
		
}

function SimpanSesi($id,$namaform,$nilai)
{
	$CI =& get_instance();
 	$cekadasession		= $CI->db->query("SELECT * FROM daftar_sesi where NamaForm='$namaform' and NamaSesi='$id' and UserLogin= '".$CI->session->userdata('admin_id')."' ")->num_rows();
			if ($cekadasession==0) {
				//Jika belum pernah login berarti dibuatkan record, jika sudah pernah berarti update record
				$CI->db->query("INSERT INTO daftar_sesi (NamaForm,NamaSesi,UserLogin,ValueSesi) VALUES ('$namaform','$id','".$CI->session->userdata('admin_id')."','$nilai')");
			} else {
				$CI->db->query("UPDATE daftar_sesi SET ValueSesi = '$nilai' where NamaForm='$namaform' and NamaSesi='$id' and UserLogin= '".$CI->session->userdata('admin_id')."'");
			}

 	
		
}


function LabelBeasiswa($id)
{
$Beasiswa	= gval("bsw_jenis", "BeasiswaID", "Nama", $id); 
$Warna	  = gval("bsw_jenis", "BeasiswaID", "Warna", $id); 

if($Warna==1)
{ $lbl='label-warna1';}
else if($Warna==2)
{ $lbl='label-warna3';} 
else if($Warna==3)
{ $lbl='label-danger';} 
else if($Warna==4)
{ $lbl='label-warna4';} 
else
{ $lbl='label-default';} 

$Beasiswa	= gval("bsw_jenis", "BeasiswaID", "Nama", $id); 
$StatusLabel = "<span class='label ".$lbl." lb-sm '>".$Beasiswa."</span>";
return $StatusLabel;

}




function konversi_level($id) {
	if ($id == "1") {
		echo "Admin Super";
	} else {
		echo "Admin Pos";
	}
}


function dateDiff ($d1, $d2) {

    // Return the number of days between the two dates:    
    return round(abs(strtotime($d1) - strtotime($d2))/86400);

} // end function 



function HitungAsset($Kategori) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT count(*) as Hitung FROM t_asset WHERE KategoriID='$Kategori' limit 1 ")->row();
	$JmlAsset	= empty($nama) ? "0" : $nama->Hitung;
 return $JmlAsset;	
}

 


function ComboBox($name, $tabel, $f_value, $f_view, $selected, $id, $class,$lebar,$keterangan) {
	echo "\n<select name='$name' id='$id' class='$class' style='width:$lebar' >\n<option value='xx'>$keterangan</option>\n";   
 	$CI =& get_instance();	
 	$query	= $CI->db->query("SELECT $f_value, $f_view FROM $tabel where NA='N' and IsDeleted='N' ORDER BY $f_view ASC ")->result_array();
  foreach($query as $a)
   {
 			if ($a[$f_value] == $selected) {
			echo "<option value='$a[$f_value]' selected>$a[$f_view]</option>\n ";
		} else {
			echo "<option value='$a[$f_value]'>$a[$f_view]</option> \n";
		}
  }
	echo "</select>\n";
}


function ComboBoxPenjaringan($name, $tabel, $f_value, $f_view, $selected, $id, $class,$lebar,$keterangan,$ros) {
  $PeriodeAktif = gval("t_periode","Status","Nama","1");
  if($ros=='1')
  { $ro='disabled';
    } else {$ro='';}
  
	echo "\n<select name='$name' id='$id' $ro class='$class' style='width:$lebar' >\n<option value='xx'>$keterangan</option>\n";   
 	$CI =& get_instance();	
 	$query	= $CI->db->query("SELECT $f_value, $f_view FROM $tabel where NA='N' and IsDeleted='N' and Status='1' and Periode='$PeriodeAktif' ORDER BY BeasiswaID desc, $f_view ASC ")->result_array();
  foreach($query as $a)
   {
 			if ($a[$f_value] == $selected) {
			echo "<option value='$a[$f_value]' selected>$a[$f_view]</option>\n";
		} else {
			echo "<option value='$a[$f_value]'>$a[$f_view]</option>\n";
		}
  }
	echo "</select>\n";
} 

function getjenisnilai($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_jenis_nilai WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getmapel($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_mapel WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getkelas($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_kelas WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getguru($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_guru WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getsession_tombol($namaform,$parameter,$adminID) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT datasession FROM session_form WHERE namaform='$namaform' and parameter='$parameter' and adminID='$adminID'")->row();
	$data	= empty($nama) ? "-" : $nama->datasession;
	return $data;
}

function getsiswa($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_siswa WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

/* fungsi non database */
function tgl_jam_sql ($tgl) {
	$pc_satu	= explode(" ", $tgl);
	if (count($pc_satu) < 2) {	
		$tgl1		= $pc_satu[0];
		$jam1		= "";
	} else {
		$jam1		= $pc_satu[1];
		$tgl1		= $pc_satu[0];
	}
	
	$pc_dua		= explode("-", $tgl1);
	$tgl		= $pc_dua[2];
	$bln		= $pc_dua[1];
	$thn		= $pc_dua[0];
	
	
	if ($bln == "01") { $bln_txt = "Jan"; }  
	else if ($bln == "02") { $bln_txt = "Feb"; }  
	else if ($bln == "03") { $bln_txt = "Mar"; }  
	else if ($bln == "04") { $bln_txt = "Apr"; }  
	else if ($bln == "05") { $bln_txt = "Mei"; }  
	else if ($bln == "06") { $bln_txt = "Jun"; }  
	else if ($bln == "07") { $bln_txt = "Jul"; }  
	else if ($bln == "08") { $bln_txt = "Ags"; }  
	else if ($bln == "09") { $bln_txt = "Sep"; }  
	else if ($bln == "10") { $bln_txt = "Okt"; }  
	else if ($bln == "11") { $bln_txt = "Nov"; }  
	else if ($bln == "12") { $bln_txt = "Des"; }  	
	else { $bln_txt = ""; }
	
	return $tgl." ".$bln_txt." ".$thn."  ".$jam1;
}




function namabulan($bln) {
	
	if ($bln == "1") { $bln_txt = "Januari"; }  
	else if ($bln == "2") { $bln_txt = "Februari"; }  
	else if ($bln == "3") { $bln_txt = "Maret"; }  
	else if ($bln == "4") { $bln_txt = "April"; }  
	else if ($bln == "5") { $bln_txt = "Mei"; }  
	else if ($bln == "6") { $bln_txt = "Juni"; }  
	else if ($bln == "7") { $bln_txt = "Juli"; }  
	else if ($bln == "8") { $bln_txt = "Agustus"; }  
	else if ($bln == "9") { $bln_txt = "September"; }  
	else if ($bln == "10") { $bln_txt = "Oktober"; }  
	else if ($bln == "11") { $bln_txt = "November"; }  
	else if ($bln == "12") { $bln_txt = "Desember"; }  	
	else { $bln_txt = ""; }
	
	return $bln_txt;
}


/* penyederhanaan fungsi */
function _page($total_row, $per_page, $uri_segment, $url) {
	$CI 	=& get_instance();
	$CI->load->library('pagination');
	$config['base_url'] 	= $url;
	$config['total_rows'] 	= $total_row;
	$config['uri_segment'] 	= $uri_segment;
	$config['per_page'] 	= $per_page; 
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close']= '</li>';
	$config['prev_link'] 	= '&lt;';
	$config['prev_tag_open']='<li>';
	$config['prev_tag_close']='</li>';
	$config['next_link'] 	= '&gt;';
	$config['next_tag_open']='<li>';
	$config['next_tag_close']='</li>';
	$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
	$config['cur_tag_close']='</a></li>';
	$config['first_tag_open']='<li>';
	$config['first_tag_close']='</li>';
	$config['last_tag_open']='<li>';
	$config['last_tag_close']='</li>';
	
	$CI->pagination->initialize($config); 
	return $CI->pagination->create_links();
}

function _print_pdf($file, $data) {
	require_once('h2p/html2fpdf.php');          // agar dapat menggunakan fungsi-fungsi html2pdf
	ob_start();                            		// memulai buffer
	error_reporting(1);                     	// turn off warning for deprecated functions
	$pdf= new HTML2FPDF();                  	// membuat objek HTML2PDF
	$pdf->DisplayPreferences('Fullscreen');
	
	$html = $data;               		// mengambil data dengan format html, dan disimpan di variabel
	ob_end_clean();                         	// mengakhiri buffer dan tidak menampilkan data dalam format html
	$pdf->addPage();                        	// menambah halaman di file pdf
	$pdf->WriteHTML($html);                 	// menuliskan data dengan format html ke file pdf
	return $pdf->Output($file,'D'); 
}