<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
	}                                       
	
	public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}

		$a['s_surat_masuk_bln'] = $this->db->query("SELECT 
								MONTH(a.tgl_diterima) bln, COUNT(a.id) jml
								FROM t_surat_masuk a
								WHERE YEAR(a.tgl_diterima) = '".$this->session->userdata('admin_ta')."'
								GROUP BY MONTH(a.tgl_diterima)")->result_array();
		$a['s_surat_masuk_kode'] = $this->db->query("SELECT 
								a.kode, b.nama, COUNT(a.id) jml
								FROM t_surat_masuk a
								LEFT JOIN ref_klasifikasi b ON a.kode = b.kode
								WHERE YEAR(a.tgl_diterima) = '".$this->session->userdata('admin_ta')."'
								GROUP BY a.kode,b.nama")->result_array();

		$a['s_surat_keluar_bln'] = $this->db->query("SELECT 
								MONTH(a.tgl_catat) bln, COUNT(a.id) jml
								FROM t_surat_keluar a
								WHERE YEAR(a.tgl_catat) = '".$this->session->userdata('admin_ta')."'
								GROUP BY MONTH(a.tgl_catat)")->result_array();
		$a['s_surat_keluar_kode'] = $this->db->query("SELECT 
								a.kode, b.nama, COUNT(a.id) jml
								FROM t_surat_keluar a
								LEFT JOIN ref_klasifikasi b ON a.kode = b.kode
								WHERE YEAR(a.tgl_catat) = '".$this->session->userdata('admin_ta')."'
								GROUP BY a.kode,b.nama")->result_array();

		$a['page']	= "d_amain";
		
		$this->load->view('admin/aaa', $a);
	}
  
  
  public function reporting_canvassingxlsx() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
    
		$total_row		= $this->db->query("SELECT nama FROM data_kecamatan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/reporting_canvassingxlsx/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		

		//ambil variabel Postingan
		//$tgl_input	 		= addslashes($this->input->post('tgl_input'));
   // $tgl_input     = date('Y-m-d' , strtotime($tgl_input));
  	$kecamatan	 		= addslashes($this->input->post('Kecamatan')); 
    $kecamatan='Kanor';
    $keldesa='Kanor';
    $tps='TPS-01';
    
    if ($mau_ke == "cari") {
       $per_page		= 100; 
     	$akhir	= $per_page; 
      
      
     	$this->load->library('ExcelSimple');  
    ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$filename = "DPT -".$Kecamatan."-".$keldesa."-".$tps.".xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');




$rows = $this->db->query("SELECT * from data_final_link where kecamatan='$Kecamatan' and keldesa='$keldesa' and tps='$tps'  order by kecamatan,keldesa,dusun,nama asc")->result();


$styles7 = array( 'border'=>'left,right,top,bottom');
 $styles1 = array( 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#ccf', 'halign'=>'center', 'border'=>'left,right,top,bottom');


$writer = new XLSXWriter();
$writer->setAuthor('Some Author'); 
$widths = array(4,20,8,8,8,8,8,8,8,8,19,15,19);
$col_options = array('widths'=>$widths);
$styles8 = array( ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin']);
$styles6 = array( ['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf'],['fill'=>'#ccf']);

  $header = array(
  ''=>'integer',
  ''=>'string',
  ''=>'string',
  '.'=>'string',
  '..'=>'string',
  '...'=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
  ''=>'string',
     );    
       
$writer->writeSheetHeader('Sheet1', $header,$col_options);

$sheetName='Sheet1';
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 0, $end_row = 2, $end_col = 0); 
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 1, $end_row = 2, $end_col = 1); 
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 2, $end_row = 1, $end_col = 3); 
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 4, $end_row = 1, $end_col = 5); 
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 6, $end_row = 1, $end_col = 7);
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 8, $end_row = 1, $end_col = 9);

$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 10, $end_row = 2, $end_col = 10);
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 11, $end_row = 2, $end_col = 11);
$writer->markMergedCell($sheetName, $start_row = 1, $start_col = 12, $end_row = 2, $end_col = 12);


    
$datax=array();
$datax[0]='No';
$datax[1]='Kecamatan';
$datax[2]='Ya';
$datax[3]='';
$datax[4]='Ragu';
$datax[5]='';
$datax[6]='Tidak';
$datax[7]='';    
$datax[8]='Tanpa Informasi'; 
$datax[9]=''; 
$datax[10]='Jumlah Canvassing'; 
$datax[11]='Jumlah DPT'; 
$datax[12]='Persen Canvassing'; 
$writer->writeSheetRow('Sheet1', $datax,$styles6);


$datax=array();
$datax[0]='';
$datax[1]='';
$datax[2]='Jml';
$datax[3]='Prsn';
$datax[4]='Jml';
$datax[5]='Prsn';
$datax[6]='Jml';
$datax[7]='Prsn';    
$datax[8]='Jml'; 
$datax[9]='Prsn'; 
$datax[10]=''; 
$datax[11]=''; 
$datax[12]=''; 
$writer->writeSheetRow('Sheet1', $datax,$styles6);






$rows = $this->db->query(" select * from data_kecamatan order by nama asc; ")->result();





$no=1;


foreach($rows as $row)
{
$kecamatan= $row->nama;
$datakec = $row->nama.'('.$row->JumlahDesa.' desa)' ;
$JumlahDPT = $row->JumlahDPT;
$data=array();
$data[0]=$no;
$data[1]=$datakec;


$Total	= $this->db->query(" select count(Id) as Jumlah,kecamatan from data_canvassing where kecamatan='$kecamatan' and AsalDukungan='Sendiri' and  Inputby is not null group by kecamatan order by Jumlah desc; ")->row()->Jumlah;
 if(empty($Total))
 {
  $Total=0  ;
  }

$Ya	= $this->db->query(" select count(Id) as Jumlah,kecamatan from data_canvassing where kecamatan='$kecamatan' and AsalDukungan='Sendiri' and  GradeDukungan='Memilih' and Inputby is not null group by kecamatan order by Jumlah desc; ")->row()->Jumlah;
 if(empty($Ya))
 {
  $Ya=0 ;
  } 
$PersenYa=round($Ya/$Total,2) ;

$data[2]=$Ya;
$data[3]=$PersenYa;

$Ragu	= $this->db->query(" select count(Id) as Jumlah,kecamatan from data_canvassing where kecamatan='$kecamatan' and AsalDukungan='Sendiri' and  GradeDukungan='Ragu' and Inputby is not null group by kecamatan order by Jumlah desc; ")->row()->Jumlah;
 if(empty($Ragu))
 {
  $Ragu=0 ;
  } 

$PersenRagu=round($Ragu/$Total,2) ;
$data[4]=$Ragu;
$data[5]=$PersenRagu;

$Tidak	= $this->db->query(" select count(Id) as Jumlah,kecamatan from data_canvassing where kecamatan='$kecamatan' and AsalDukungan='Sendiri' and  GradeDukungan='Tidak' and Inputby is not null group by kecamatan order by Jumlah desc; ")->row()->Jumlah;
 if(empty($Tidak))
 {
  $Tidak=0 ;
  } 

$PersenTidak=round($Tidak/$Total,2) ;
$data[6]=$Tidak;
$data[7]=$PersenTidak;

$NoInfo	= $this->db->query(" select count(Id) as Jumlah,kecamatan from data_canvassing where kecamatan='$kecamatan' and AsalDukungan='Sendiri' and  GradeDukungan='Belum didata' and Inputby is not null group by kecamatan order by Jumlah desc; ")->row()->Jumlah;
 if(empty($NoInfo))
 {
  $NoInfo=0 ;
  } 

$PersenNoinfo=round($NoInfo/$Total,2) ;

$data[8]=$NoInfo;
$data[9]=$PersenNoinfo;


$data[10]=$Total;
//$data[11]=number_format($JumlahDPT);

$JumlahDPT	= $this->db->query(" select JumlahDPT from data_kecamatan where nama='$kecamatan'; ")->row()->JumlahDPT;

$data[11]=$JumlahDPT;

$PersenCanvassing=round($Total/$JumlahDPT,2) ;
$data[12]=$PersenCanvassing;

$no++;
$writer->writeSheetRow('Sheet1', $data,$styles8);
}

  
  
$writer->writeToStdOut();
//$writer->writeToFile('example.xlsx');
//echo $writer->writeToString();
exit(0);

    	$a['page']		= "l_reporting_canvassingxlsx";
	
     } 
  	 
    else {
	
     $a['data']		= $this->db->query(" select count(Id) as Jumlah,kecamatan,keldesa,Sumber from data_canvassing where  AsalDukungan='Sendiri' and  Inputby is not null group by kecamatan order by kecamatan asc; ")->result();
     
      	     
  		$a['page']		= "l_reporting_canvassingxlsx";
		}
		
		$this->load->view('admin/aaa', $a);
	}
  
  
//==============================
 


	public function jenis_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM bsw_jenis")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/jenis_beasiswa/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$Kode					= addslashes($this->input->post('Kode'));
		$Nama					= addslashes($this->input->post('Nama'));
		$Jenis					= addslashes($this->input->post('Jenis'));
	 	$Tgl_mulai					= addslashes($this->input->post('Tgl_mulai'));
    $Tgl_mulai    = date('Y-m-d' , strtotime($Tgl_mulai));
		$Tgl_selesai					= addslashes($this->input->post('Tgl_selesai'));
    $Tgl_selesai    = date('Y-m-d' , strtotime($Tgl_selesai));
		$Besaran					= addslashes($this->input->post('Besaran'));
    $Besaran = str_replace( ',', '', $Besaran );
    
		$Periode					= addslashes($this->input->post('Periode'));
		$Kuota					= addslashes($this->input->post('Kuota'));
		$IPKMinimal					= addslashes($this->input->post('IPKMinimal'));
    $IPKMinimal = str_replace( ',', '.', $IPKMinimal );
   
    
		$SemesterMinimal					= addslashes($this->input->post('SemesterMinimal'));
		$SKSMinimal				= addslashes($this->input->post('SKSMinimal'));
		$AktifKemahasiswaan					= addslashes($this->input->post('AktifKemahasiswaan'));
		$EkonomiLemah					= addslashes($this->input->post('EkonomiLemah'));
		$BeasiswaLain					= addslashes($this->input->post('BeasiswaLain'));
		$SyaratLain					= addslashes($this->input->post('SyaratLain'));
		$File				= addslashes($this->input->post('File'));
		$Deskripsi				= addslashes($this->input->post('Deskripsi'));
		$Status					= addslashes($this->input->post('Status'));
		$StatusBeasiswa				= addslashes($this->input->post('StatusBeasiswa'));
	  
		$cari					= addslashes($this->input->post('q'));

				//upload config 
		$config['upload_path'] 		= './upload/jenis_beasiswa';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
    
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM bsw_jenis WHERE NA='N' and IsDeleted='N' and Nama LIKE '%$cari%' OR Kode LIKE '%$cari%' ORDER BY Kode asc")->result();
			$a['page']		= "l_jenis_beasiswa";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_jenis_beasiswa";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_jenis WHERE id = '$idu'")->row();	
			$a['page']		= "f_jenis_beasiswa";
		} else if ($mau_ke == "rubahstatus") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_jenis WHERE id = '$idu'")->row();	
			$a['page']		= "f_rubah_status_beasiswa";
		}
    else if ($mau_ke == "act_edt") {
      	if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

			$this->db->query("UPDATE `db_arsip`.`bsw_jenis` SET `Kode`='$Kode', `Nama`='$Nama', `Jenis`='$Jenis', `Tgl_mulai`='$Tgl_mulai', `Tgl_selesai`='$Tgl_selesai', `Besaran`='$Besaran', `Periode`='$Periode', `Kuota`='$Kuota', `IPKMinimal`='$IPKMinimal', `SemesterMinimal`='$SemesterMinimal', `SKSMinimal`='$SKSMinimal', `AktifKemahasiswaan`='$AktifKemahasiswaan', `EkonomiLemah`='$EkonomiLemah', `BeasiswaLain`='$BeasiswaLain', `SyaratLain`='$SyaratLain', `Deskripsi`='$Deskripsi',`File`= '".$up_data['file_name']."'  WHERE id = '$idp'");
    	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/jenis_beasiswa');
    }
    else
    {
    	$this->db->query("UPDATE `db_arsip`.`bsw_jenis` SET `Kode`='$Kode', `Nama`='$Nama', `Jenis`='$Jenis', `Tgl_mulai`='$Tgl_mulai', `Tgl_selesai`='$Tgl_selesai', `Besaran`='$Besaran', `Periode`='$Periode', `Kuota`='$Kuota', `IPKMinimal`='$IPKMinimal', `SemesterMinimal`='$SemesterMinimal', `SKSMinimal`='$SKSMinimal', `AktifKemahasiswaan`='$AktifKemahasiswaan', `EkonomiLemah`='$EkonomiLemah', `BeasiswaLain`='$BeasiswaLain', `SyaratLain`='$SyaratLain', `Deskripsi`='$Deskripsi' WHERE id = '$idp'");
    	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/jenis_beasiswa');
    
    }  
      
		} else if ($mau_ke == "act_add"){
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query(" INSERT INTO `db_arsip`.`bsw_jenis` (`Kode`, `Nama`, `Jenis`, `Tgl_mulai`, `Tgl_selesai`, `Besaran`, `Periode`, `Kuota`, `IPKMinimal`, `SemesterMinimal`, `SKSMinimal`, `AktifKemahasiswaan`, `EkonomiLemah`, `BeasiswaLain`, `SyaratLain`, `File`, `Deskripsi`, `Status`) VALUES ('$Kode', '$Nama', '$Jenis', '$Tgl_mulai', '$Tgl_selesai', '$Besaran', '$Periode', '$Kuota', '$IPKMinimal', '$SemesterMinimal', '$SKSMinimal', '$AktifKemahasiswaan', '$EkonomiLemah', '$BeasiswaLain', '$SyaratLain', '".$up_data['file_name']."','$Deskripsi','Aktif')     ");
 $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			redirect('admin/jenis_beasiswa');			
    		
				} else {
    	$this->db->query(" INSERT INTO `db_arsip`.`bsw_jenis` (`Kode`, `Nama`, `Jenis`, `Tgl_mulai`, `Tgl_selesai`, `Besaran`, `Periode`, `Kuota`, `IPKMinimal`, `SemesterMinimal`, `SKSMinimal`, `AktifKemahasiswaan`, `EkonomiLemah`, `BeasiswaLain`, `SyaratLain`, `File`, `Deskripsi`, `Status`) VALUES ('$Kode', '$Nama', '$Jenis', '$Tgl_mulai', '$Tgl_selesai', '$Besaran', '$Periode', '$Kuota', '$IPKMinimal', '$SemesterMinimal', '$SKSMinimal', '$AktifKemahasiswaan', '$EkonomiLemah', '$BeasiswaLain', '$SyaratLain', '','$Deskripsi','Aktif')     ");
			
      
      $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Hanya menambah data tanpa upload</div>");			
			redirect('admin/jenis_beasiswa');
    
    
    }
    
    

		} else if ($mau_ke == "del") {
			$this->db->query("Update bsw_jenis set IsDeleted='Y' WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('admin/jenis_beasiswa');
		} else if ($mau_ke == "act_rubahstatus") {
			$this->db->query("Update bsw_jenis set Status='$StatusBeasiswa' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Status Beasiswa $Kode Telah dirubah</div>");			
			redirect('admin/jenis_beasiswa');
		}
     else {
			$a['data']		= $this->db->query("SELECT * FROM bsw_jenis where NA='N' and IsDeleted='N' ORDER BY Kode asc LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jenis_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	public function pengajuan_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_masuk WHERE YEAR(tgl_diterima) = '$ta'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/pengajuan_beasiswa/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$MhswID				= addslashes($this->input->post('MhswID'));
   	$NamaMhsw				= addslashes($this->input->post('NamaMhsw'));
    
    $JenisBeasiswa			= addslashes($this->input->post('JenisBeasiswa'));
    $Periode   = gval("bsw_jenis","Kode","Periode",$JenisBeasiswa);
    //$Periode				= addslashes($this->input->post('Periode'));
		$IPK			= addslashes($this->input->post('IPK'));
		$Semester				= addslashes($this->input->post('Semester'));
		$SKSLulus					= addslashes($this->input->post('SKSLulus'));
		$Alamat				= addslashes($this->input->post('Alamat'));
  	$NoHP				= addslashes($this->input->post('NoHP'));
   	$Keterangan				= addslashes($this->input->post('Keterangan'));
   	$KodePT				= addslashes($this->input->post('KodePT'));
   	$ProdiID				= addslashes($this->input->post('ProdiID'));
   	$JenjangStudi				= addslashes($this->input->post('JenjangStudi'));
   	$TempatLahir				= addslashes($this->input->post('TempatLahir'));
   	$JenisKelamin				= addslashes($this->input->post('JenisKelamin'));
    $PekerjaanOrtu				= addslashes($this->input->post('PekerjaanOrtu'));
   	$TanggunganOrtu				= addslashes($this->input->post('Tanggungan'));
   	$PenghasilanOrtu				= addslashes($this->input->post('PenghasilanOrtu'));
    
    
		$TanggalLahir				= addslashes($this->input->post('TanggalLahir'));
  //  $TanggalLahir     = date('Y-m-d' , strtotime($TanggalLahir));
   
     
    
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/pemohon';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("update bsw_pemohon set IsDeleted='Y' WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/pengajuan_beasiswa');
		} else if ($mau_ke == "cari") {
        	$a['data']		= $this->db->query("SELECT t1.id,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.JenisBeasiswa,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE t1.Nama LIKE '%$cari%' and t1.Periode='2018' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.Periode,t1.ProdiID  DESC LIMIT $awal, $akhir ")->result();
        	$a['page']		= "l_pengajuan_beasiswa";
	  	} else if ($mau_ke == "add") {
    
    
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_surat_masuk WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_pengajuan_beasiswa";
	
  	} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE id = '$idu'")->row();	
			$a['page']		= "f_pengajuan_beasiswa";
      
   //Tambah data   
		} else if ($mau_ke == "act_add") {
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`JenisBeasiswa`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) VALUES ('$JenisKelamin','$JenisBeasiswa', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '".$up_data['file_name']."','$JenjangStudi','$TempatLahir','Aktif')     ");
 $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			redirect('admin/jenis_beasiswa');			
    		
				} else {
    	$this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`JenisBeasiswa`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`, `Status`) VALUES ('$JenisKelamin','$JenisBeasiswa', '$TanggalLahir', '$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '','$JenjangStudi','$TempatLahir','Aktif')     ");
			
      
      $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Hanya menambah data tanpa upload</div>");			
			redirect('admin/pengajuan_beasiswa');
    
    
    }
    
    

		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE bsw_pemohon SET IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE bsw_pemohon SET IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/pengajuan_beasiswa');
		} else {
			$a['data']		= $this->db->query("SELECT t1.InputBy,t1.id,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.JenisBeasiswa,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE t1.Periode='2018' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.Periode,t1.ProdiID  DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_pengajuan_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
  //---------------------------------------------------------------------------------------------------------------
  	
	public function import_excel_2003() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		
	
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	  $rand       = substr(md5(microtime()),rand(0,26),14);
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
	
		//upload config 
		$config['upload_path'] 		= './upload/import_excel';
		$config['allowed_types'] 	= 'xls';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
	 	
		if ($mau_ke == "import") {
	   
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
		     
        	$this->load->library('Spreadsheet_Excel_Reader'); 
     			$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
    	  	$this->spreadsheet_excel_reader->read($up_data['full_path']);
    			$sheets = $this->spreadsheet_excel_reader->sheets[0];
    			error_reporting(0);
    
    			$data_excel = array();
    			for ($i = 2; $i <= $sheets['numRows']; $i++) {
    				if ($sheets['cells'][$i][1] == '') break;
    
        	$data_excel[$i - 1]['MhswID'] = $sheets['cells'][$i][1];
    			$data_excel[$i - 1]['Nama'] = $sheets['cells'][$i][2];	
          $data_excel[$i - 1]['JenisKeluar']   = $sheets['cells'][$i][3];
    		  $data_excel[$i - 1]['TglKeluar'] = $sheets['cells'][$i][4];        
          $data_excel[$i - 1]['SKYudisium'] = $sheets['cells'][$i][5];
          $data_excel[$i - 1]['TglSKYudisium'] = $sheets['cells'][$i][6];        
          $data_excel[$i - 1]['IPK'] = $sheets['cells'][$i][7]; 
          $data_excel[$i - 1]['NoSeriIjazah'] = $sheets['cells'][$i][8];
          $data_excel[$i - 1]['JudulSkripsi'] = $sheets['cells'][$i][9];
          $data_excel[$i - 1]['BulanAwalBimbingan'] = $sheets['cells'][$i][10];
          $data_excel[$i - 1]['BulanAkhirBimbingan'] = $sheets['cells'][$i][11];
          $data_excel[$i - 1]['JalurSkripsi'] = $sheets['cells'][$i][12];  
          $data_excel[$i - 1]['Pembimbing1'] = $sheets['cells'][$i][13];    
          $data_excel[$i - 1]['Pembimbing2'] = $sheets['cells'][$i][14];
          $data_excel[$i - 1]['KodeProdi'] = $sheets['cells'][$i][15];
          $data_excel[$i - 1]['BatchCode'] = $rand;  
           
    			}
    
    			$this->db->insert_batch('data_mhsw_lulus', $data_excel);
				
				
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diupload </div>");
			}
			
			
			
			
			
			
			
			
			
			
			
			
			redirect('index.php/admin/import_excel_2003');
		} else if ($mau_ke == "export") {
//			$a['data']		= $this->db->query("SELECT * FROM t_import_excel WHERE isi_ringkas LIKE '%$cari%' OR indek_berkas LIKE '%$cari%' OR dari LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_import_excel_2003";
		}   else {
	//		$a['data']		= $this->db->query("SELECT * FROM t_import_excel WHERE YEAR(tgl_diterima) = '$ta' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_import_excel_2003";
		}
		
		$this->load->view('admin/aaa', $a);
	}
 //================================================================================================================
 	public function import_excel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		
	
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		 $rand       = substr(md5(microtime()),rand(0,26),17);
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
	
		//upload config 
		$config['upload_path'] 		= './upload/import_excel';
		$config['allowed_types'] 	= 'xlsx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
	 	
		if ($mau_ke == "import") {
	   
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
        
        //Load Library
		    require_once(APPPATH.'libraries/simplexlsx.class.php');
    		error_reporting(0);        
       
         if ( $xlsx = SimpleXLSX::parse( $up_data['full_path'] ) ) {
      	 list( $cols, ) = $xlsx->dimension();
         $data_excel = array();
  
    
		foreach ( $xlsx->rows() as $k => $r ) {
				if ($k == 0) continue; // skip first row
        //Isi Data dari masing masing field  
		   	$data_excel[$i]['MhswID'] = $r[0];
       	$data_excel[$i]['Nama'] = $r[1];
       	$data_excel[$i]['JenisKeluar'] = $r[2];
       	$data_excel[$i]['TglKeluar'] = $r[3];
       	$data_excel[$i]['SKYudisium'] = $r[4];
       	$data_excel[$i]['TglSKYudisium'] = $r[5];
        $data_excel[$i]['IPK'] = $r[6];
       	$data_excel[$i]['NoSeriIjazah'] = $r[7];
       	$data_excel[$i]['JudulSkripsi'] = $r[8];
       	$data_excel[$i]['BulanAwalBimbingan'] = $r[9];
       	$data_excel[$i]['BulanAkhirBimbingan'] = $r[10];
       	$data_excel[$i]['JalurSkripsi'] = $r[11];
       	$data_excel[$i]['Pembimbing1'] = $r[12];
       	$data_excel[$i]['Pembimbing2'] = $r[13];
      	$data_excel[$i]['KodeProdi'] = $r[14];  
    	  $data_excel[$i]['BatchCode'] = $rand;   //Kode Batch untuk tiap tiap upload untuk mempermudah identifikasi 
        //Insert ke Database
        $this->db->insert_batch('data_mhsw_lulus', $data_excel); 
      
			
		}
   
    
		echo '</table>';
	} else {
		echo SimpleXLSX::parse_error();
	}
      
      
      
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diupload </div>");
			}
			
				
			redirect('index.php/admin/import_excel');
		} else if ($mau_ke == "export") {
//			$a['data']		= $this->db->query("SELECT * FROM t_import_excel WHERE isi_ringkas LIKE '%$cari%' OR indek_berkas LIKE '%$cari%' OR dari LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_import_excel";
		}   else {
	//		$a['data']		= $this->db->query("SELECT * FROM t_import_excel WHERE YEAR(tgl_diterima) = '$ta' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_import_excel";
		}
		
		$this->load->view('admin/aaa', $a);
	} 
  //---------------------------------------------------------------------------------------------------------------

  public function bidik_misi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_inter_office WHERE YEAR(tgl_diterima) = '$ta'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/bidik_misi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$kode					= addslashes($this->input->post('kode'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
    $tgl_surat     = date('Y-m-d' , strtotime($tgl_surat));
   
     
    
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/inter_office';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_inter_office WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/bidik_misi');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_inter_office WHERE isi_ringkas LIKE '%$cari%' OR indek_berkas LIKE '%$cari%' OR dari LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_bidik_misi";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_inter_office WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_bidik_misi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_inter_office WHERE id = '$idu'")->row();	
			$a['page']		= "f_bidik_misi";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_inter_office VALUES (NULL, '$kode', '	$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_inter_office VALUES (NULL, '$kode', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/bidik_misi');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_inter_office SET kode = '$kode', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_inter_office SET kode = '$kode', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/bidik_misi');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_inter_office WHERE YEAR(tgl_diterima) = '$ta' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_bidik_misi";
		}
		
		$this->load->view('admin/aaa', $a);
	}
 //=======================================================
 
  public function beasiswa_lain() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_inter_office WHERE YEAR(tgl_diterima) = '$ta'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/beasiswa_lain/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$kode					= addslashes($this->input->post('kode'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
    $tgl_surat     = date('Y-m-d' , strtotime($tgl_surat));
   
     
    
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/inter_office';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_inter_office WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/beasiswa_lain');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_inter_office WHERE isi_ringkas LIKE '%$cari%' OR indek_berkas LIKE '%$cari%' OR dari LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_beasiswa_lain";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_inter_office WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_beasiswa_lain";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_inter_office WHERE id = '$idu'")->row();	
			$a['page']		= "f_beasiswa_lain";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_inter_office VALUES (NULL, '$kode', '	$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_inter_office VALUES (NULL, '$kode', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/beasiswa_lain');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_inter_office SET kode = '$kode', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_inter_office SET kode = '$kode', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/beasiswa_lain');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_inter_office WHERE YEAR(tgl_diterima) = '$ta' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_beasiswa_lain";
		}
		
		$this->load->view('admin/aaa', $a);
	}

	public function rangkuman_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_keluar WHERE YEAR(tgl_catat) = '$ta'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/rangkuman_beasiswa/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$kode					= addslashes($this->input->post('kode'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
    $tgl_surat     = date('Y-m-d' , strtotime($tgl_surat));
   
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_keluar';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_keluar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_keluar');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_keluar WHERE isi_ringkas LIKE '%$cari%' OR tujuan LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_rangkuman_beasiswa";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_surat_keluar WHERE YEAR(tgl_catat) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_rangkuman_beasiswa";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE id = '$idu'")->row();	
			$a['page']		= "f_rangkuman_beasiswa";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_keluar VALUES (NULL, '$kode', '$no_agenda', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_keluar VALUES (NULL, '$kode', '$no_agenda', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/rangkuman_beasiswa');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_keluar SET no_agenda = '$no_agenda', kode = '$kode', isi_ringkas = '$uraian', tujuan = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_keluar SET no_agenda = '$no_agenda', kode = '$kode', isi_ringkas = '$uraian', tujuan = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/rangkuman_beasiswa');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM bsw_jenis WHERE IsDeleted='N' and NA='N' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_rangkuman_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
  
//==============================================================================  
    	public function hasil_seleksi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_paket_kirim WHERE YEAR(tgl_catat) = '$ta'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/hasil_seleksi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$kode					= addslashes($this->input->post('kode'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
    $tgl_surat     = date('Y-m-d' , strtotime($tgl_surat));
   
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/paket_kirim';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_paket_kirim WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/hasil_seleksi');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_paket_kirim WHERE isi_ringkas LIKE '%$cari%' OR tujuan LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_hasil_seleksi";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_paket_kirim WHERE YEAR(tgl_catat) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_hasil_seleksi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_paket_kirim WHERE id = '$idu'")->row();	
			$a['page']		= "f_hasil_seleksi";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_paket_kirim VALUES (NULL, '$kode', '$no_agenda', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_paket_kirim VALUES (NULL, '$kode', '$no_agenda', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/hasil_seleksi');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_paket_kirim SET no_agenda = '$no_agenda', kode = '$kode', isi_ringkas = '$uraian', tujuan = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_paket_kirim SET no_agenda = '$no_agenda', kode = '$kode', isi_ringkas = '$uraian', tujuan = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/hasil_seleksi');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_paket_kirim WHERE YEAR(tgl_catat) = '$ta' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hasil_seleksi";
		}
		
		$this->load->view('admin/aaa', $a);
	}
 
//==============================================================  
  	public function tim_seleksi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_paket_datang WHERE YEAR(tgl_diterima) = '$ta'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/tim_seleksi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$kode					= addslashes($this->input->post('kode'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
    $tgl_surat     = date('Y-m-d' , strtotime($tgl_surat));
   
     
    
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/paket_datang';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_paket_datang WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/tim_seleksi');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_paket_datang WHERE isi_ringkas LIKE '%$cari%' OR indek_berkas LIKE '%$cari%' OR dari LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_tim_seleksi";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_paket_datang WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_tim_seleksi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_paket_datang WHERE id = '$idu'")->row();	
			$a['page']		= "f_tim_seleksi";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_paket_datang VALUES (NULL, '$kode', '	$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_paket_datang VALUES (NULL, '$kode', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/tim_seleksi');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_paket_datang SET kode = '$kode', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_paket_datang SET kode = '$kode', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/tim_seleksi');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_paket_datang WHERE YEAR(tgl_diterima) = '$ta' ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_tim_seleksi";
		}
		
		$this->load->view('admin/aaa', $a);
	}
  
 
	public function export_excel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/export_excel/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_surat_masuk", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/admin/surat_disposisi/'.$idu1);
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('index.php/admin/surat_disposisi/'.$id_surat);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/admin/surat_disposisi/'.$id_surat);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_export_excel";
		}
		
		$this->load->view('admin/aaa', $a);	
	}	  
   

	public function surat_disposisi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_surat_masuk", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/admin/surat_disposisi/'.$idu1);
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('index.php/admin/surat_disposisi/'.$id_surat);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/admin/surat_disposisi/'.$id_surat);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		
		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$nama					= addslashes($this->input->post('nama'));
		$alamat					= addslashes($this->input->post('alamat'));
		$kepsek					= addslashes($this->input->post('kepsek'));
		$nip_kepsek				= addslashes($this->input->post('nip_kepsek'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('logo')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepsek = '$kepsek', nip_kepsek = '$nip_kepsek', logo = '".$up_data['file_name']."' WHERE id = '$idp'");

			} else {
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepsek = '$kepsek', nip_kepsek = '$nip_kepsek' WHERE id = '$idp'");
			}		

			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	

	
	public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_admin")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/manage_admin/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$username				= addslashes($this->input->post('username'));
		$pass_raw1				= addslashes($this->input->post('password'));
		$pass_raw2				= addslashes($this->input->post('password2'));
		$password				= md5(addslashes($this->input->post('password')));
		$nama					= addslashes($this->input->post('nama'));
		$nip					= addslashes($this->input->post('nip'));
		$level					= addslashes($this->input->post('level'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_admin WHERE nama LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_manage_admin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_admin WHERE id = '$idu'")->row();	
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "del") {
			$a['datpil']	= $this->db->query("DELETE FROM t_admin WHERE id = '$idu'")->row();	
			
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "act_add") {	
			$cek_user_exist = $this->db->query("SELECT username FROM t_admin WHERE username = '$username'")->num_rows();

			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
			} else if (strlen($pass_raw1) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password minimal 4 huruf</div>");
			} else if ($pass_raw1 != $pass_raw2) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password konfirmasi tidak sama..</div>");
			} else if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username telah dipakai. Ganti yang lain..!</div>");
			} else {
				$this->db->query("INSERT INTO t_admin VALUES (NULL, '$username', '$password', '$nama', '$nip', '$level')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "act_edt") {
			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
			} else if (strlen($pass_raw1) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password minimal 4 huruf</div>");
			} else if ($pass_raw1 != $pass_raw2) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password konfirmasi tidak sama..</div>");
			} else if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username telah dipakai. Ganti yang lain..!</div>");
			} else {
				
				if ($pass_raw1 == "") {
					$this->db->query("UPDATE t_admin SET username = '$username', nama = '$nama', nip = '$nip', level = '$level' WHERE id = '$idp'");
				} else {
					$this->db->query("UPDATE t_admin SET username = '$username', password = '$password', nama = '$nama', nip = '$nip', level = '$level' WHERE id = '$idp'");
				}

				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('index.php/admin/manage_admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('admin/aaa', $a);
	}

	public function get_mhsw() {
		$kode 				= $this->input->post('kode',TRUE);
    if (strlen($kode)<3) {
            //do nothing;
          }
      else {
    	$data 				=  $this->db->query("SELECT * from mhsw WHERE  Nama LIKE '%$kode%' or MhswID like '%$kode%' ORDER BY Nama asc")->result();
	 	  $datamhsw	=  array();
        foreach ($data as $d) {
			$json_array				= array();
      $json_array['label']	= $d->MhswID.'-'.$d->Nama;
      $json_array['value']	= $d->Nama;
      $json_array['Nama']	= $d->Nama;
      $json_array['MhswID']	= $d->MhswID;
      $json_array['ProdiID']	= $d->ProdiID;
      $json_array['TempatLahir']	= $d->TempatLahir;
      $json_array['TanggalLahir']	= $d->TanggalLahir;
      $json_array['JenjangStudi']	= '5'; // Untuk Sarjan S-1 nilai adalah 5
      $json_array['KodePT']	= '072011'; // Untuk IKIP kode= 072011
      $json_array['JenisKelamin']	= $d->Kelamin;
        
     
      $datamhsw[] 			= $json_array;
  		}
		echo json_encode($datamhsw);
     }
    
    
	}    
 
	
	public function get_instansi_lain() {
		$kode 				= $this->input->post('dari',TRUE);
		
		$data 				=  $this->db->query("SELECT dari FROM t_surat_masuk WHERE dari LIKE '%$kode%' GROUP BY dari")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$klasifikasi[] 	= $d->dari;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function disposisi_cetak() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT kpd_yth FROM t_disposisi WHERE id_surat = '$idu'")->result();	
		$a['datpil3']	= $this->db->query("SELECT isi_disposisi, sifat, batas_waktu FROM t_disposisi WHERE id_surat = '$idu'")->result();	
		$this->load->view('admin/f_disposisi', $a);
	}
	
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ke				= $this->uri->segment(3);
		$id_user		= $this->session->userdata('admin_id');
		
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
			$cek_password_lama	= $this->db->query("SELECT password FROM t_admin WHERE id = $id_user")->row();
			//echo 
			
			if ($cek_password_lama->password != $p1) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Lama tidak sama</div>');
				redirect('index.php/admin/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('index.php/admin/passwod');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('index.php/admin/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	//login
	public function login() {
		$this->load->view('admin/login');
	}
	
	public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
		$ta 	= $this->security->xss_clean($this->input->post('ta'));
        $p 		= md5($this->security->xss_clean($this->input->post('p')));
         
		$q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		//echo $this->db->last_query();
		
        if($j_cek == 1) {
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->nama,
                    'admin_ta' => $ta,
                    'admin_level' => $d_cek->level,
					'admin_valid' => true
                    );
            $this->session->set_userdata($data);
            redirect('index.php/admin');
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('index.php/admin/login');
		}
	}
	
	public function logout(){
        $this->session->sess_destroy();
		redirect('index.php/admin/login');
    }
}
