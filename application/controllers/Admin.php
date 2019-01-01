<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
	}                                       
//=============================================================================================================== 	
public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
    $PeriodeAktif = gval("t_periode","Status","Nama","1");
   
    SimpanSesi('PeriodeID','beasiswa_dashboard',$PeriodeAktif);
	  		$a['data']		= $this->db->query("SELECT * FROM bsw_jenis WHERE IsDeleted='N' and Status='1' and NA='N' and Periode='$PeriodeAktif' ORDER BY BeasiswaID DESC  ")->result();
		 		$a['page']	= "d_amain2";
    
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function periode() {
	if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
		redirect("admin/login");
	}
      $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 	
	
	//ambil variabel URL
	$mau_ke				= $this->uri->segment(3);
	$idu1					= $this->uri->segment(4);
	$idu2					= $this->uri->segment(4);
 	$rand       = substr(md5(microtime()),rand(0,26),20);
	//ambil variabel Postingan
	$idp					= addslashes($this->input->post('RandomChar'));
	$catatan			= addslashes($this->input->post('catatan'));
	$cari					= addslashes($this->input->post('q'));
  $Terlihat			= addslashes($this->input->post('Terlihat'));
  $Status				= addslashes($this->input->post('Status'));
  $Nama				  = addslashes($this->input->post('Nama'));
        
	
	/* pagination */	
	$total_row		= $this->db->query("SELECT * FROM t_periode WHERE PeriodeID = '$idu1'")->num_rows();
	$per_page		  = 10;
	$awal	        = $this->uri->segment(4); 
	$awal        	= (empty($awal) || $awal == 1) ? 0 : $awal;
	
	//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
	$akhir	      = $per_page;
	$a['pagi']	  = _page($total_row, $per_page, 4, base_url()."admin/periode/".$idu1."/p");
	 
	if ($mau_ke == "del") {
  
  
  
   //Pengecekan apakah Periode sudah ada beasiswa, Jika sudah ada beasiswa , Periode tidak bisa dihapus
      $NamaPeriode=gval("t_periode", "RandomChar", "Nama", $idu2);
      $AdaPendaftar = $this->db->query(" select exists(select Periode from bsw_jenis where Periode='$NamaPeriode' limit 1) as Hasil; ")->result();
      $AdaPendaftar=$AdaPendaftar[0]->Hasil;
    
      if ($AdaPendaftar=='1')
       {
      //   	$this->db->query("Update bsw_jenis set IsDeleted='Y' WHERE id = '$idu'");
		 	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Periode ini sudah dipakai Beasiswa, tidak bisa dihapus</div>");		
      
       
       }
       else{
     	$this->db->query("Update t_periode set IsDeleted='Y' WHERE RandomChar = '$idu2'");
		 	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Periode telah dihapus</div>");		
       
       }
    
			
			redirect('admin/periode');
	 
    $this->db->query("UPDATE t_periode SET  IsDeleted='Y' WHERE RandomChar = '$idu2'");
    $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Periode telah dihapus</div>");
		redirect('admin/periode/'.$idu1);
  	} else if ($mau_ke == "add") {
			$a['page']		= "f_periode";                
 	} else if ($mau_ke == "edt") {
		$a['datpil']	= $this->db->query("SELECT * FROM t_periode WHERE RandomChar = '$idu2'")->row();	
		$a['page']		= "f_periode";
	} else if ($mau_ke == "act_add") {	
		$this->db->query("INSERT INTO t_periode VALUES (NULL, '$Nama', '$Status', '$Terlihat')");
		
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Periode $Nama telah ditambahkan/div>");
		redirect('admin/periode/'.$id_surat);
	} else if ($mau_ke == "act_edt") {
  
  
    if($Status=='1')
    {
      $this->db->query("UPDATE t_periode SET  Status='0' ");
     	$this->db->query("UPDATE t_periode SET  Status='$Status' WHERE RandomChar = '$idp'");
    
    }
   else
   {
   	$this->db->query("UPDATE t_periode SET  Status='$Status' WHERE RandomChar = '$idp'");
   } 
   
   //Check Apakah ada periode yg aktif
    $AdaPeriodeAktif = $this->db->query(" select exists(select PeriodeID from t_periode where Status='1' limit 1) as Hasil; ")->result();
    $AdaPeriodeAktif=$AdaPeriodeAktif[0]->Hasil;
    if($AdaPeriodeAktif=='1')
        {
          $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah diupdate</div>");	
        } 
    else
        {
          $this->db->query("UPDATE t_periode SET  Status='1' WHERE RandomChar = '$idp'");
          $this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Peringatan: Tidak ada periode yang aktif, aksi dibatalkan</div>");
        }
	
				
		redirect('admin/periode/'.$id_surat);
	} else {
		$a['data']		= $this->db->query("SELECT * FROM t_periode where IsDeleted='N' ")->result();
		$a['page']		= "l_periode";
	}
	
	$this->load->view('admin/aaa', $a);	
}
//=============================================================================================================== 
public function prodi() {
	if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
		redirect("admin/login");
	}
  
  $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 
	
	//ambil variabel URL
	$mau_ke				= $this->uri->segment(3);
	$idu1					= $this->uri->segment(3);
	$idu2					= $this->uri->segment(4);
	$cari					= addslashes($this->input->post('q'));
 	$rand       = substr(md5(microtime()),rand(0,26),20);
	//ambil variabel Postingan
	$idp					= addslashes($this->input->post('idp'));
  $ProdiID			= addslashes($this->input->post('ProdiID'));
	$Nama				  = addslashes($this->input->post('Nama'));
	$Fakultas			= addslashes($this->input->post('Fakultas'));
  $KaProdi			= addslashes($this->input->post('KaProdi'));
  $Status				= addslashes($this->input->post('Status'));

	
	/* pagination */	
	$total_row		= $this->db->query("SELECT * FROM t_prodi WHERE prodiID = '$idu1'")->num_rows();
	$per_page		= 10;
	
	$awal	= $this->uri->segment(4); 
	$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
	
	//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
	$akhir	= $per_page;
	
	$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/prodi/".$idu1."/p");
	
 
	
	if ($mau_ke == "del") {
		$this->db->query("DELETE FROM t_prodix WHERE id = '$idu2'");
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
		redirect('admin/prodi/'.$idu1);
	} else if ($mau_ke == "add") {
		$a['page']		= "f_prodi";
	} else if ($mau_ke == "edt") {
		$a['datpil']	= $this->db->query("SELECT * FROM t_prodi WHERE id = '$idu2'")->row();	
		$a['page']		= "f_prodi";
	} else if ($mau_ke == "act_add") {	
		$this->db->query("INSERT INTO t_prodi VALUES (NULL,'$ProdiID', '$Fakultas', '$Nama', '$KaProdi', '$Status')");
		
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Prodi telah ditambahkan</div>");
		redirect('admin/prodi/'.$id_surat);
	} else if ($mau_ke == "act_edt") {
		$this->db->query("UPDATE t_prodi SET  KaProdi = '$KaProdi', Status = '$Status' WHERE id = '$idp'");
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah diupdate</div>");			
		redirect('admin/prodi/'.$id_surat);
	} else {
		$a['data']		= $this->db->query("SELECT * FROM t_prodi order by Fakultas,Nama LIMIT $awal, $akhir ")->result();
		$a['page']		= "l_prodi";
	}
	
	$this->load->view('admin/aaa', $a);	
}
//=============================================================================================================== 
public function grademahasiswa() {
	if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
		redirect("admin/login");
	}
      $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 	
	
	//ambil variabel URL
	$mau_ke				= $this->uri->segment(3);
	$idu1					= $this->uri->segment(3);
	$idu2					= $this->uri->segment(4);
	$cari					= addslashes($this->input->post('q'));
 	$rand       = substr(md5(microtime()),rand(0,26),20);
	//ambil variabel Postingan
	$idp					= addslashes($this->input->post('idp'));
	$Status			  = addslashes($this->input->post('Status'));
	$Nama					= addslashes($this->input->post('Nama'));
	$Keterangan		= addslashes($this->input->post('Keterangan'));
	/* pagination */	
	$total_row		= $this->db->query("SELECT * FROM t_grademahasiswa WHERE grademahasiswaID = '$idu1'")->num_rows();
	$per_page		= 10;
	
	$awal	= $this->uri->segment(4); 
	$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
	
	//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
	$akhir	= $per_page;
	$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/grademahasiswa/".$idu1."/p");
	
//	$a['judul_surat']	= gval("t_grademahasiswa", "id", "isi_ringkas", $idu1);
	
	if ($mau_ke == "del") {
		$this->db->query("DELETE FROM t_grademahasiswax WHERE GradeMahasiswaID = '$idu2'");
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
		redirect('admin/grademahasiswa/'.$idu1);
	} else if ($mau_ke == "add") {
		$a['page']		= "f_grademahasiswa";
	} else if ($mau_ke == "edt") {
		$a['datpil']	= $this->db->query("SELECT * FROM t_grademahasiswa WHERE GradeMahasiswaID = '$idu2'")->row();	
		$a['page']		= "f_grademahasiswa";
	} else if ($mau_ke == "act_add") {	
		$this->db->query("INSERT INTO t_grademahasiswa VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
		
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
		redirect('admin/grademahasiswa/'.$id_surat);
	} else if ($mau_ke == "act_edt") {
		$this->db->query("UPDATE t_grademahasiswa SET Nama = '$Nama', Keterangan = '$Keterangan', Status = '$Status' WHERE GradeMahasiswaID = '$idp'");
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
		redirect('admin/grademahasiswa/'.$id_surat);
	} else {
		$a['data']		= $this->db->query("SELECT * FROM t_grademahasiswa LIMIT $awal, $akhir ")->result();
		$a['page']		= "l_grademahasiswa";
	}
	
	$this->load->view('admin/aaa', $a);	
}
//=============================================================================================================== 
public function jenis_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
      $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 
  
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM bsw_jenis where IsDeleted='N' ")->num_rows();
		$per_page		  = 10;
		
		$awal	        = $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		$rand       = substr(md5(microtime()),rand(0,26),20);
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	      = $per_page;
		
		$a['pagi']	  = _page($total_row, $per_page, 4, base_url()."admin/jenis_beasiswa/p");
		
		//ambil variabel URL
		$mau_ke				= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('RandomChar'));
		$Kode					= addslashes($this->input->post('Kode'));
		$Nama					= addslashes($this->input->post('Nama'));
    $Warna					= addslashes($this->input->post('Warna'));
		$Jenis				= addslashes($this->input->post('Jenis'));
	 	$Tgl_mulai		= addslashes($this->input->post('Tgl_mulai'));
    $Tgl_mulai    = date('Y-m-d' , strtotime($Tgl_mulai));
		$Tgl_selesai	= addslashes($this->input->post('Tgl_selesai'));
    $Tgl_selesai  = date('Y-m-d' , strtotime($Tgl_selesai));
		$Besaran			= addslashes($this->input->post('Besaran'));
    $Besaran      = str_replace( ',', '', $Besaran );
   	$Periode			= addslashes($this->input->post('Periode'));
		$Kuota				= addslashes($this->input->post('Kuota'));
		$IPKMinimal		= addslashes($this->input->post('IPKMinimal'));
    $IPKMinimal   = str_replace( ',', '.', $IPKMinimal );
		$SKSMinimal		= addslashes($this->input->post('SKSMinimal'));
		$TidakMampu		= addslashes($this->input->post('TidakMampu'));
		$BeasiswaLain	= addslashes($this->input->post('BeasiswaLain'));
		$SyaratLain		= addslashes($this->input->post('SyaratLain'));
		$File				  = addslashes($this->input->post('File'));
		$Deskripsi		= addslashes($this->input->post('Deskripsi'));
		$Status				= addslashes($this->input->post('Status'));
	 	$cari					= addslashes($this->input->post('q'));
 	  $StatusBeasiswa		    = addslashes($this->input->post('StatusBeasiswa'));
		$AktifKemahasiswaan		= addslashes($this->input->post('AktifKemahasiswaan'));
    $SemesterMinimal	    = addslashes($this->input->post('SemesterMinimal'));    
    
   
 			//upload config 
		$config['upload_path'] 		= './upload/jenis_beasiswa';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			  = '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
//------------------------------    
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM bsw_jenis WHERE NA='N' and IsDeleted='N' and Nama LIKE '%$cari%' OR Kode LIKE '%$cari%' ORDER BY Kode asc")->result();
			$a['page']		= "l_jenis_beasiswa";
//------------------------------       
		} else if ($mau_ke == "add") {
			$a['page']		= "f_jenis_beasiswa";
//------------------------------       
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_jenis WHERE RandomChar = '$idu'")->row();	
			$a['page']		= "f_jenis_beasiswa";
//------------------------------       
		} else if ($mau_ke == "rubahstatus") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_jenis WHERE RandomChar = '$idu'")->row();	
			$a['page']		= "f_rubah_status_beasiswa";
		}
//------------------------------     
    else if ($mau_ke == "act_edt") {
      	if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

			$this->db->query("UPDATE `bsw_jenis` SET `Warna`='$Warna',`Kode`='$Kode', `Nama`='$Nama', `Jenis`='$Jenis', `Tgl_mulai`='$Tgl_mulai', `Tgl_selesai`='$Tgl_selesai',`Status`='$Status',  `Besaran`='$Besaran', `Periode`='$Periode', `Kuota`='$Kuota', `IPKMinimal`='$IPKMinimal', `SemesterMinimal`='$SemesterMinimal', `SKSMinimal`='$SKSMinimal', `AktifKemahasiswaan`='$AktifKemahasiswaan', `TidakMampu`='$TidakMampu', `BeasiswaLain`='$BeasiswaLain', `SyaratLain`='$SyaratLain', `Deskripsi`='$Deskripsi',`File`= '".$up_data['file_name']."'  WHERE RandomChar = '$idp'");
    	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah diupdate< /div>");			
			redirect('admin/jenis_beasiswa');
    }
    else
    {
    	$this->db->query("UPDATE `bsw_jenis` SET `Warna`='$Warna',`Kode`='$Kode', `Nama`='$Nama', `Jenis`='$Jenis', `Tgl_mulai`='$Tgl_mulai', `Tgl_selesai`='$Tgl_selesai',`Status`='$Status', `Besaran`='$Besaran', `Periode`='$Periode', `Kuota`='$Kuota', `IPKMinimal`='$IPKMinimal', `SemesterMinimal`='$SemesterMinimal', `SKSMinimal`='$SKSMinimal', `AktifKemahasiswaan`='$AktifKemahasiswaan', `TidakMampu`='$TidakMampu', `BeasiswaLain`='$BeasiswaLain', `SyaratLain`='$SyaratLain', `Deskripsi`='$Deskripsi' WHERE RandomChar = '$idp'");
    	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/jenis_beasiswa');
    
    }  
//------------------------------       
		} else if ($mau_ke == "act_add"){
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query(" INSERT INTO `bsw_jenis` (`RandomChar`,`Kode`, `Nama`, `Jenis`, `Tgl_mulai`, `Tgl_selesai`, `Besaran`, `Periode`, `Kuota`, `IPKMinimal`, `SemesterMinimal`, `SKSMinimal`, `AktifKemahasiswaan`, `TidakMampu`, `BeasiswaLain`, `SyaratLain`, `File`, `Deskripsi`, `Status`, `Warna`) VALUES ('$rand','$Kode', '$Nama', '$Jenis', '$Tgl_mulai', '$Tgl_selesai', '$Besaran', '$Periode', '$Kuota', '$IPKMinimal', '$SemesterMinimal', '$SKSMinimal', '$AktifKemahasiswaan', '$TidakMampu', '$BeasiswaLain', '$SyaratLain', '".$up_data['file_name']."','$Deskripsi','1','$Warna')     ");
 $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			redirect('admin/jenis_beasiswa');			
    		
				} else {
    	$this->db->query(" INSERT INTO `bsw_jenis` (`RandomChar`,`Kode`, `Nama`, `Jenis`, `Tgl_mulai`, `Tgl_selesai`, `Besaran`, `Periode`, `Kuota`, `IPKMinimal`, `SemesterMinimal`, `SKSMinimal`, `AktifKemahasiswaan`, `TidakMampu`, `BeasiswaLain`, `SyaratLain`, `File`, `Deskripsi`, `Status`, `Warna`) VALUES ('$rand','$Kode', '$Nama', '$Jenis', '$Tgl_mulai', '$Tgl_selesai', '$Besaran', '$Periode', '$Kuota', '$IPKMinimal', '$SemesterMinimal', '$SKSMinimal', '$AktifKemahasiswaan', '$TidakMampu', '$BeasiswaLain', '$SyaratLain', '','$Deskripsi','1','$Warna')     ");
			
      
      $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Hanya menambah data tanpa upload</div>");			
			redirect('admin/jenis_beasiswa');
      }
  //------------------------------ 
		} else if ($mau_ke == "del") {
    
    //Pengecekan apakah beasiswa sudah ada penjaringan mahasiswa, Jika sudah ada penjaringan jenis beasiswa tidak bisa dihapus
      $kodebeasiswa=gval("bsw_jenis", "RandomChar", "BeasiswaID", $idu);
      $AdaPendaftar = $this->db->query(" select exists(select BeasiswaID from bsw_pemohon where BeasiswaID='$kodebeasiswa' limit 1) as Hasil; ")->result();
      $AdaPendaftar=$AdaPendaftar[0]->Hasil;
    
      if ($AdaPendaftar=='1')
       {
      //   	$this->db->query("Update bsw_jenis set IsDeleted='Y' WHERE id = '$idu'");
		 	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Program Beasiswa ini sudah ada pendaftar, tidak bisa dihapus</div>");		
      
       
       }
       else{
     	$this->db->query("Update bsw_jenis set IsDeleted='Y' WHERE RandomChar = '$idu'");
		 	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Program Beasiswa telah dihapus</div>");		
       
       }
    
			
			redirect('admin/jenis_beasiswa');
//------------------------------       
		} else if ($mau_ke == "act_rubahstatus") {
			$this->db->query("Update bsw_jenis set Status='$StatusBeasiswa' WHERE RandomChar = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Status Beasiswa $Kode Telah dirubah</div>");			
			redirect('admin/jenis_beasiswa');
		}
//------------------------------     
     else {
			$a['data']		= $this->db->query("SELECT * FROM bsw_jenis where NA='N' and IsDeleted='N' ORDER BY Kode asc LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jenis_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function beasiswa_disetujui() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		    $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM bsw_pemohon where IsDeleted='N' ")->num_rows();
		$per_page		= 50;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/beasiswa_disetujui/p");
		
		//ambil variabel URL
		$mau_ke				= $this->uri->segment(3);
    $RandomChar   =  $this->uri->segment(4);
	  $idu= gval("bsw_pemohon","RandomChar","PemohonID",$RandomChar);
		$cari					= addslashes($this->input->post('JenisBeasiswa'));
   	$rand       = substr(md5(microtime()),rand(0,26),20);
		//ambil variabel post
		$RandomChar2					= addslashes($this->input->post('idp'));
     $idp= gval("bsw_pemohon","RandomChar","PemohonID",$RandomChar2);
		$MhswID				= addslashes($this->input->post('MhswID'));
   	$NamaMhsw			= addslashes($this->input->post('NamaMhsw'));
    $PeriodeAktif = gval("t_periode","Status","Nama","1");
    $BeasiswaID   = addslashes($this->input->post('JenisBeasiswa'));
    $Periode      = gval("bsw_jenis","Kode","Periode",$BeasiswaID);
    //$Periode		= addslashes($this->input->post('Periode'));
		$IPK			    = addslashes($this->input->post('IPK'));
		$Semester			= addslashes($this->input->post('Semester'));
		$SKSLulus			= addslashes($this->input->post('SKSLulus'));
		$Alamat				= addslashes($this->input->post('Alamat'));
  	$NoHP				  = addslashes($this->input->post('NoHP'));
   	$Keterangan		= addslashes($this->input->post('Keterangan'));
   	$KodePT				= addslashes($this->input->post('KodePT'));
   	$ProdiID			= addslashes($this->input->post('ProdiID'));
   	$JenjangStudi	= addslashes($this->input->post('JenjangStudi'));
   	$TempatLahir	= addslashes($this->input->post('TempatLahir'));
   	$JenisKelamin	= addslashes($this->input->post('JenisKelamin'));
    $PekerjaanOrtu= addslashes($this->input->post('PekerjaanOrtu'));
    $uraian				= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
	 	$TanggunganOrtu	 = addslashes($this->input->post('Tanggungan'));
   	$PenghasilanOrtu = addslashes($this->input->post('PenghasilanOrtu'));
    $StatusBeasiswa	 = addslashes($this->input->post('StatusBeasiswa'));
    $TanggalLahir		 = addslashes($this->input->post('TanggalLahir'));
  //  $TanggalLahir     = date('Y-m-d' , strtotime($TanggalLahir));
  
  $UserID = $this->session->userdata('admin_id');
  $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
  
  if($AksesProdi=='xx')  {  $whereProdi =' ';  }
  else
  {  $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
  
  if($BeasiswaID=='xx') { $whereBeasiswa =" "; }
    else
    { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";}
  
    $where = $whereBeasiswa.$whereProdi;
    
    
    
    
    
		//upload config 
		$config['upload_path'] 		= './upload/pemohon';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			  = '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
//=============================		
		if ($mau_ke == "kunci") {
    	$this->db->query("update bsw_pemohon set Terkunci='Y' WHERE PemohonID = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Telah dikunci </div>");
	    $BeasiswaID = AmbilSesi('BeasiswaID','beasiswa_disetujui');
      $UserID = $this->session->userdata('admin_id');
      $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
       if($AksesProdi=='xx')  {  $whereProdi =' ';  }
       else
       {  $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
  
       if($BeasiswaID=='xx') { $whereBeasiswa =" "; }
       else
       { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";}
       $where = $whereBeasiswa.$whereProdi;
         
     	$a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID   DESC  ")->result();
     	$a['page']		= "l_beasiswa_disetujui";
     
//=============================
}else		if ($mau_ke == "bukakunci") {

       $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Percobaan Akses Terlarang </div>");
       	redirect("admin/beasiswa_disetujui");  } 
       
       
    	$this->db->query("update bsw_pemohon set Terkunci='N' WHERE PemohonID = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Kunci telah dibuka </div>");
	     $BeasiswaID = AmbilSesi('BeasiswaID','beasiswa_disetujui');
       $UserID = $this->session->userdata('admin_id');
       $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
       if($AksesProdi=='xx')  {  $whereProdi =' ';  }
       else
       {  $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
  
       if($BeasiswaID=='xx') { $whereBeasiswa =" "; }
       else
       { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";}
       $where = $whereBeasiswa.$whereProdi;
         
     	$a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID   DESC  ")->result();
     	$a['page']		= "l_beasiswa_disetujui";
 
//=============================
} else if ($mau_ke == "cari") {
      SimpanSesi('BeasiswaID','beasiswa_disetujui',$BeasiswaID);
     	$a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID  DESC  ")->result();
     	$a['page']		= "l_beasiswa_disetujui";
//=============================
} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_surat_masuk WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);
  		$a['nomer_terakhir'] = $last;
  		$a['page']		= "f_beasiswa_disetujui";
//=============================      
} else if ($mau_ke == "kembali") {
	     $BeasiswaID = AmbilSesi('BeasiswaID','beasiswa_disetujui');
       $UserID = $this->session->userdata('admin_id');
       $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
       if($AksesProdi=='xx')  {  $whereProdi =' ';  }
       else
       {  $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
  
       if($BeasiswaID=='xx') { $whereBeasiswa =" "; }
       else
       { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";}
       $where = $whereBeasiswa.$whereProdi;
         
     	$a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID   DESC  ")->result();
     	$a['page']		= "l_beasiswa_disetujui";
//=============================  
} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			$a['page']		= "f_beasiswa_disetujui";
//=============================  
} else if ($mau_ke == "act_add") {
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			  $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '".$up_data['file_name']."','$JenjangStudi','$TempatLahir','Pengajuan')     ");
        $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			  redirect('admin/beasiswa_disetujui');			
    		} else {
    	  $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`, `Status`) VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir', '$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '','$JenjangStudi','$TempatLahir','Pengajuan')     ");
			  $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Hanya menambah data tanpa upload</div>");			
			  redirect('admin/beasiswa_disetujui');
        }
//=============================        
} else if ($mau_ke == "act_edt") {
       	     $BeasiswaID = AmbilSesi('BeasiswaID','beasiswa_disetujui');
       $UserID = $this->session->userdata('admin_id');
       $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
  
  if($AksesProdi=='xx')  {  $whereProdi =' ';  }
  else
  {  $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
  
  if($BeasiswaID=='xx') { $whereBeasiswa =" "; }
    else
    { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";}
    $where = $whereBeasiswa.$whereProdi;
 
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
  			$this->db->query("UPDATE bsw_pemohon SET BeasiswaID='$BeasiswaID',IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu', file = '".$up_data['file_name']."' WHERE PemohonID = '$idp'");
			} else {
				$this->db->query("UPDATE bsw_pemohon SET BeasiswaID='$BeasiswaID',IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu' WHERE PemohonID = '$idp'");
			}	
      
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
		    
      redirect('admin/beasiswa_disetujui');
//=============================      
   		} else if ($mau_ke == "ubahstatus") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			$a['page']		= "f_beasiswa_disetujui";
//=============================		  
    	} else if ($mau_ke == "act_rubahstatus") {
			$this->db->query("Update bsw_pemohon set Status='$StatusBeasiswa' WHERE PemohonID = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Status Beasiswa $Kode Telah dirubah</div>");			
			redirect('admin/beasiswa_disetujui/kembali');
//=============================      
		} else {
   
      SimpanSesi('BeasiswaID','beasiswa_disetujui','xx');
			$a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $whereProdi t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID  DESC  ")->result();
			$a['page']		= "l_beasiswa_disetujui";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//==============================================================================================================
public function detil_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		 
		 
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM bsw_pemohon where IsDeleted='N' ")->num_rows();
		$per_page		= 50;
		$rand       = substr(md5(microtime()),rand(0,26),20);
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/beasiswa_disetujui/p");
		
		//ambil variabel URL
		$mau_ke				= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
    $ID_BS					= $this->uri->segment(3);
		$cari					= addslashes($this->input->post('JenisBeasiswa'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$MhswID				= addslashes($this->input->post('MhswID'));
   	$NamaMhsw			= addslashes($this->input->post('NamaMhsw'));
    $PeriodeAktif = gval("t_periode","Status","Nama","1");
    $BeasiswaID   = addslashes($this->input->post('JenisBeasiswa'));
    $Periode      = gval("bsw_jenis","Kode","Periode",$BeasiswaID);
    //$Periode		= addslashes($this->input->post('Periode'));
		$IPK			    = addslashes($this->input->post('IPK'));
		$Semester			= addslashes($this->input->post('Semester'));
		$SKSLulus			= addslashes($this->input->post('SKSLulus'));
		$Alamat				= addslashes($this->input->post('Alamat'));
  	$NoHP				  = addslashes($this->input->post('NoHP'));
   	$Keterangan		= addslashes($this->input->post('Keterangan'));
   	$KodePT				= addslashes($this->input->post('KodePT'));
   	$ProdiID			= addslashes($this->input->post('ProdiID'));
   	$JenjangStudi	= addslashes($this->input->post('JenjangStudi'));
   	$TempatLahir	= addslashes($this->input->post('TempatLahir'));
   	$JenisKelamin	= addslashes($this->input->post('JenisKelamin'));
    $PekerjaanOrtu= addslashes($this->input->post('PekerjaanOrtu'));
    $uraian				= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
	 	$TanggunganOrtu	 = addslashes($this->input->post('Tanggungan'));
   	$PenghasilanOrtu = addslashes($this->input->post('PenghasilanOrtu'));
    $StatusBeasiswa	 = addslashes($this->input->post('StatusBeasiswa'));
    $TanggalLahir		 = addslashes($this->input->post('TanggalLahir'));
  //  $TanggalLahir     = date('Y-m-d' , strtotime($TanggalLahir));
  
  $UserID = $this->session->userdata('admin_id');
  $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
  
  if($AksesProdi=='xx')
  {
  $whereProdi =' ';
  }
  else
  {
  $whereProdi=" t1.ProdiID='$AksesProdi' and ";
  }
  
  
  
   if($BeasiswaID=='xx'){
      $whereBeasiswa =" ";
    }
    else
    {
     $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";
      
    }
  
    $where = $whereBeasiswa.$whereProdi;
    
    
		//upload config 
		$config['upload_path'] 		= './upload/pemohon';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			  = '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
    
    
    
    
    
			$this->db->query("update bsw_pemohon set IsDeleted='Y' WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/beasiswa_disetujui');
} else if ($mau_ke == "cari") {
    SimpanSesi('BeasiswaID','beasiswa_disetujui',$BeasiswaID);
    	$a['data']		= $this->db->query("SELECT t1.Terkunci,t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID  DESC LIMIT $awal, $akhir ")->result();
     	$a['page']		= "l_beasiswa_disetujui";
} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_surat_masuk WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);
  		$a['nomer_terakhir'] = $last;
  		$a['page']		= "f_beasiswa_disetujui";
} else if ($mau_ke == "kembali") {
	     $BeasiswaID = AmbilSesi('BeasiswaID','beasiswa_disetujui'); 
       
     	$a['data']		= $this->db->query("SELECT t1.Terkunci,t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE   t1.BeasiswaID='$BeasiswaID' and t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID  DESC LIMIT $awal, $akhir ")->result();
     	$a['page']		= "l_beasiswa_disetujui";
  
} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			$a['page']		= "f_beasiswa_disetujui";
   //Tambah data   
} else if ($mau_ke == "act_add") {
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			  $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '".$up_data['file_name']."','$JenjangStudi','$TempatLahir','Pengajuan')     ");
        $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			  redirect('admin/beasiswa_disetujui');			
    		} else {
    	  $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`, `Status`) VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir', '$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '','$JenjangStudi','$TempatLahir','Pengajuan')     ");
			  $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Hanya menambah data tanpa upload</div>");			
			  redirect('admin/beasiswa_disetujui');
        }
} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
  			$this->db->query("UPDATE bsw_pemohon SET IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu', file = '".$up_data['file_name']."' WHERE PemohonID = '$idp'");
			} else {
				$this->db->query("UPDATE bsw_pemohon SET IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu' WHERE PemohonID = '$idp'");
			}	
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/beasiswa_disetujui');
      
   		} else if ($mau_ke == "rubahstatus") {
			$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			$a['page']		= "f_beasiswa_disetujui";
		  
    	} else if ($mau_ke == "act_rubahstatus") {
			$this->db->query("Update bsw_pemohon set Status='$StatusBeasiswa' WHERE PemohonID = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Status Beasiswa $Kode Telah dirubah</div>");			
			redirect('admin/beasiswa_disetujui/kembali');
		} else {
      SimpanSesi('BeasiswaID','beasiswa_disetujui',$ID_BS);
			$a['data']		= $this->db->query("SELECT t1.Terkunci,t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $whereProdi t1.Periode='$PeriodeAktif' and t1.BeasiswaID='$ID_BS' and t1.Status='11' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID  DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_beasiswa_disetujui";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//==============================================================================================================
public function pengajuan_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
	 $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 	
	
  
  	/* pagination */	
	$total_row	= $this->db->query("SELECT * FROM bsw_pemohon where IsDeleted='N' ")->num_rows();
	$per_page		= 48;
	$awal	      = $this->uri->segment(4); 
	$awal	      = (empty($awal) || $awal == 1) ? 0 : $awal;
		$rand       = substr(md5(microtime()),rand(0,26),20);	
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
	$akhir	    = $per_page;
		
	$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/pengajuan_beasiswa/p");
		
		//ambil variabel URL
	$RandomChar				= $this->uri->segment(4);
  
  $idu= gval("bsw_pemohon","RandomChar","PemohonID",$RandomChar);
  $mau_ke			= $this->uri->segment(3);
	$cari				= addslashes($this->input->post('q'));
	//ambil variabel post
  $BeasiswaID			= addslashes($this->input->post('BeasiswaID'));
   
	$idp				= addslashes($this->input->post('idp'));
	$MhswID			= addslashes($this->input->post('MhswID'));
  $NamaMhsw		= addslashes($this->input->post('NamaMhsw'));
  $Periode    = gval("bsw_jenis","BeasiswaID","Periode",$BeasiswaID);
  $PeriodeAktif    = gval("t_periode","Status","Nama","1");
//$Periode		= addslashes($this->input->post('Periode'));
	$IPK			  = addslashes($this->input->post('IPK'));
	$Semester		= addslashes($this->input->post('Semester'));
	$SKSLulus		= addslashes($this->input->post('SKSLulus'));
	$Alamat			= addslashes($this->input->post('Alamat'));
  $NoHP				= addslashes($this->input->post('NoHP'));
  $Keterangan	= addslashes($this->input->post('Keterangan'));
  $KodePT			= addslashes($this->input->post('KodePT'));
  $ProdiID		= addslashes($this->input->post('ProdiID'));
  $TempatLahir= addslashes($this->input->post('TempatLahir'));
  $JenjangStudi	      = addslashes($this->input->post('JenjangStudi'));
  $JenisKelamin				= addslashes($this->input->post('JenisKelamin'));
  $PekerjaanOrtu			= addslashes($this->input->post('PekerjaanOrtu'));
  $TanggunganOrtu			= addslashes($this->input->post('Tanggungan'));
  $PenghasilanOrtu		= addslashes($this->input->post('PenghasilanOrtu'));
  $StatusBeasiswa			= addslashes($this->input->post('StatusBeasiswa'));
  $TanggalLahir				= addslashes($this->input->post('TanggalLahir'));
  //  $TanggalLahir   = date('Y-m-d' , strtotime($TanggalLahir));
  $uraian			= addslashes($this->input->post('uraian'));
	$ket				= addslashes($this->input->post('ket'));
	$cari				= addslashes($this->input->post('q'));
		//upload config 
	$config['upload_path'] 		= './upload/pemohon';
	$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
	$config['max_size']			  = '2000';
	$config['max_width']  		= '3000';
	$config['max_height'] 		= '3000';
  
  $UserID = $this->session->userdata('admin_id');
  $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
   if($AksesProdi=='xx')
  {
  $whereProdi =' ';
  }
  else
  {
  $whereProdi=" t1.ProdiID='$AksesProdi' and ";
  }
  
   if($BeasiswaID=='xx'){
      $whereBeasiswa =" ";
    }
    else
    {
     $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";
     }
     $where = $whereBeasiswa.$whereProdi;
  
  

	$this->load->library('upload', $config);
//==========================		
		if ($mau_ke == "del") {
    		$this->db->query("update bsw_pemohon set IsDeleted='Y' WHERE PemohonID = '$idu'");
			  $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			  redirect('admin/pengajuan_beasiswa');
//==========================        
		} else if ($mau_ke == "cari") {
       SimpanSesi('BeasiswaID','pengajuan_beasiswa',$BeasiswaID);

     	  $a['data']		= $this->db->query("SELECT t1.Terkunci,t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' and t1.Nama LIKE '%$cari%' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID DESC LIMIT $awal, $akhir ")->result();
        $a['page']		= "l_pengajuan_beasiswa";
//=====================================

}else		if ($mau_ke == "bukakunci") {

          $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Percobaan Akses Terlarang </div>");
       	redirect("admin/pengajuan_beasiswa");  } 
       
       
     	$this->db->query("update bsw_pemohon set Terkunci='N' WHERE PemohonID = '$idu'");
		 	$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Kunci telah dibuka </div>");
	     $BeasiswaID = AmbilSesi('BeasiswaID','pengajuan_beasiswa');
       $UserID = $this->session->userdata('admin_id');
       $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
       if($AksesProdi=='xx')  {  $whereProdi =' ';  }
       else
       {  $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
  
       if($BeasiswaID=='xx') { $whereBeasiswa =" "; }
       else
       { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";}
       $where = $whereBeasiswa.$whereProdi;
         
     	$a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID   DESC  ")->result();
     	$a['page']		= "l_pengajuan_beasiswa";        
//==========================        
	 	} else if ($mau_ke == "add") {
    		 
			  $a['page']		= "f_pengajuan_beasiswa";
//==========================        
		} else if ($mau_ke == "kembali") {
       $BeasiswaID = AmbilSesi('BeasiswaID','pengajuan_beasiswa');
       $UserID = $this->session->userdata('admin_id');
       $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
       if($AksesProdi=='xx') {  $whereProdi =' '; }
       else { $whereProdi=" t1.ProdiID='$AksesProdi' and "; }
       if($BeasiswaID=='xx'){ $whereBeasiswa =" "; }
       else { $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and "; }
       $where = $whereBeasiswa.$whereProdi;
     	 $a['data']		= $this->db->query("SELECT t1.Terkunci,t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' and t1.Nama LIKE '%$cari%' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID DESC LIMIT $awal, $akhir ")->result();
       $a['page']		= "l_pengajuan_beasiswa";
//==========================
		} else if ($mau_ke == "act_add") {
    
    
    
    
    
        $BeasiswaIDPenampung= gval("bsw_jenis", "Periode='$Periode' and Jenis", "BeasiswaID", "PNP");	
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
        $PernahDaftar = CheckDaftarBeasiswa($MhswID,$BeasiswaID,$Periode) ;
        if($PernahDaftar=='1' )
        {
        
        //Jika sudah ada di usulan Beasiswa, maka pendaftaran dipindah ke penampung.....Bagaimana kalau di penampung sudah ada??
                         $PenampungAda = CheckPenampung($MhswID,$Periode) ;
                        if($PenampungAda=='1' )
                        {
                        $this->session->set_flashdata("k", "<div class=\"alert alert-warning\" id=\"alert\">Data Mahasiswa ini sudah ada di Penampung, Tidak perlu menambah baru, cukup alihkan yg dari penampung</div>");
                        }
                        else
                         {$this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) 
                        VALUES ('$JenisKelamin','$BeasiswaIDPenampung', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '".$up_data['file_name']."','$JenjangStudi','$TempatLahir','10')     ");
                	         $this->session->set_flashdata("k", "<div class=\"alert alert-warning\" id=\"alert\">Beasiswa untuk Mahasiswa tsb dipindah ke Penampung, karena telah mendaftar di Beasiswa yg sama pada periode yg sama</div>");			
                			    }
        }
        else
        {
         $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) 
        VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '".$up_data['file_name']."','$JenjangStudi','$TempatLahir','10')     ");
	        $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			
        }
         
        redirect('admin/jenis_beasiswa');			
		    } else {
        
            $PernahDaftar = CheckDaftarBeasiswa($MhswID,$BeasiswaID,$Periode) ;
        if($PernahDaftar=='1' )
        {
             $PenampungAda = CheckPenampung($MhswID,$Periode) ;
                        if($PenampungAda=='1' )
                        {
                          $this->session->set_flashdata("k", "<div class=\"alert alert-warning\" id=\"alert\">Data Mahasiswa ini sudah ada di Penampung, Tidak perlu menambah baru, cukup alihkan yg dari penampung</div>");
                        }
                        else
                        {
                           $this->db->query(" INSERT INTO `bsw_pemohon` (`RandomChar`,`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) 
                            VALUES ('$rand','$JenisKelamin','$BeasiswaIDPenampung', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '','$JenjangStudi','$TempatLahir','10')     ");
	                          $this->session->set_flashdata("k", "<div class=\"alert alert-warning\" id=\"alert\">Beasiswa untuk Mahasiswa tsb dipindah ke Penampung, karena telah mendaftar di Beasiswa yg sama pada periode yg sama</div>");			
			                   }
         }
        else
        {
         $this->db->query(" INSERT INTO `bsw_pemohon` (`RandomChar`,`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) 
        VALUES ('$rand','$JenisKelamin','$BeasiswaID', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '','$JenjangStudi','$TempatLahir','10')     ");
	        $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			
        }
           
 	  redirect('admin/pengajuan_beasiswa');
        }
        
//==========================        
  	} else if ($mau_ke == "edt") {
			  $a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			  $a['page']		= "f_pengajuan_beasiswa";        
//==========================        
   	} else if ($mau_ke == "act_edt") {
		  	if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();	
         
				$this->db->query("UPDATE bsw_pemohon SET BeasiswaID='$BeasiswaID', IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu', file = '".$up_data['file_name']."' WHERE PemohonID = '$idp'");
		  	} else {
				$this->db->query("UPDATE bsw_pemohon SET BeasiswaID='$BeasiswaID', IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu' WHERE PemohonID = '$idp'");
			  }	
   			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
	     
     	  $a['data']		= $this->db->query("SELECT t1.Terkunci, t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' and t1.Nama LIKE '%$cari%' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID DESC LIMIT $awal, $akhir ")->result();
        $a['page']		= "l_pengajuan_beasiswa";
    
//==========================             
		} else if ($mau_ke == "ubahstatus") {
		  	$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			  $a['page']		= "f_ubah_pengajuan_beasiswa";
//==========================        
	 	} else if ($mau_ke == "act_ubahstatus") {
			  $this->db->query("Update bsw_pemohon set Status='$StatusBeasiswa' WHERE PemohonID = '$idp'");
			  $this->session->set_flashdata("k", "<div class=\"alert alert-warning\" id=\"alert\">Status Beasiswa $Kode Telah dirubah</div>");			
			  redirect('admin/pengajuan_beasiswa');
//==========================        
		} else {
     SimpanSesi('BeasiswaID','pengajuan_beasiswa','xx');
			 $a['data']		= $this->db->query("SELECT t1.Terkunci,t1.RandomChar,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE  $whereProdi t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.BeasiswaID, t1.Status,t1.MhswID  DESC LIMIT $awal, $akhir ")->result();
			 $a['page']		= "l_pengajuan_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//==============================================================================================================
public function detil_pengajuan() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
	    	
		/* pagination */	
	$total_row	= $this->db->query("SELECT * FROM bsw_pemohon where IsDeleted='N' ")->num_rows();
	$per_page		= 48;
	$awal	      = $this->uri->segment(4); 
	$awal	      = (empty($awal) || $awal == 1) ? 0 : $awal;
 	$rand       = substr(md5(microtime()),rand(0,26),20);		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
	$akhir	    = $per_page;
		
	$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/pengajuan_beasiswa/p");
		
		//ambil variabel URL
	$idu				= $this->uri->segment(4);
  $mau_ke			= $this->uri->segment(3);
  $ID_BS			= $this->uri->segment(3);
	$cari				= addslashes($this->input->post('q'));
	//ambil variabel post
  $BeasiswaID			= addslashes($this->input->post('BeasiswaID'));
	$idp				= addslashes($this->input->post('idp'));
	$MhswID			= addslashes($this->input->post('MhswID'));
  $NamaMhsw		= addslashes($this->input->post('NamaMhsw'));
  $Periode    = gval("bsw_jenis","BeasiswaID","Periode",$BeasiswaID);
  $PeriodeAktif    = gval("t_periode","Status","Nama","1");
//$Periode		= addslashes($this->input->post('Periode'));
	$IPK			  = addslashes($this->input->post('IPK'));
	$Semester		= addslashes($this->input->post('Semester'));
	$SKSLulus		= addslashes($this->input->post('SKSLulus'));
	$Alamat			= addslashes($this->input->post('Alamat'));
  $NoHP				= addslashes($this->input->post('NoHP'));
  $Keterangan	= addslashes($this->input->post('Keterangan'));
  $KodePT			= addslashes($this->input->post('KodePT'));
  $ProdiID		= addslashes($this->input->post('ProdiID'));
  $TempatLahir= addslashes($this->input->post('TempatLahir'));
  $JenjangStudi	      = addslashes($this->input->post('JenjangStudi'));
  $JenisKelamin				= addslashes($this->input->post('JenisKelamin'));
  $PekerjaanOrtu			= addslashes($this->input->post('PekerjaanOrtu'));
  $TanggunganOrtu			= addslashes($this->input->post('Tanggungan'));
  $PenghasilanOrtu		= addslashes($this->input->post('PenghasilanOrtu'));
  $StatusBeasiswa			= addslashes($this->input->post('StatusBeasiswa'));
  $TanggalLahir				= addslashes($this->input->post('TanggalLahir'));
  //  $TanggalLahir   = date('Y-m-d' , strtotime($TanggalLahir));
  $uraian			= addslashes($this->input->post('uraian'));
	$ket				= addslashes($this->input->post('ket'));
	$cari				= addslashes($this->input->post('q'));
		//upload config 
	$config['upload_path'] 		= './upload/pemohon';
	$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
	$config['max_size']			  = '2000';
	$config['max_width']  		= '3000';
	$config['max_height'] 		= '3000';
  
  $UserID = $this->session->userdata('admin_id');
  $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
  
  if($AksesProdi=='xx')
  {
  $whereProdi =' ';
  }
  else
  {
  $whereProdi=" t1.ProdiID='$AksesProdi' and ";
  }
  
  
  
   if($BeasiswaID=='xx'){
      $whereBeasiswa =" ";
    }
    else
    {
     $whereBeasiswa =" t1.BeasiswaID='$BeasiswaID' and ";
      
    }
  
    $where = $whereBeasiswa.$whereProdi;
  
  

	$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
    		$this->db->query("update bsw_pemohon set IsDeleted='Y' WHERE id = '$idu'");
			  $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			  redirect('admin/pengajuan_beasiswa');
		} else if ($mau_ke == "cari") {
       SimpanSesi('BeasiswaID','pengajuan_beasiswa',$BeasiswaID);

     	  $a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $where  t1.Periode='$PeriodeAktif' and t1.NA='N' and t1.IsDeleted='N' and t1.Nama LIKE '%$cari%' ORDER BY t1.Periode,t1.ProdiID  DESC LIMIT $awal, $akhir ")->result();
        $a['page']		= "l_pengajuan_beasiswa";
	 	} else if ($mau_ke == "add") {
    		$q_nomer_terakhir = $this->db->query("SELECT (MAX(no_agenda)) AS last FROM t_surat_masuk WHERE YEAR(tgl_diterima) = '".$this->session->userdata('admin_ta')."'")->row_array();
			  $last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);
		    $a['nomer_terakhir'] = $last;
			  $a['page']		= "f_pengajuan_beasiswa";
  	} else if ($mau_ke == "edt") {
			  $a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			  $a['page']		= "f_pengajuan_beasiswa";
   //Tambah data   
		} else if ($mau_ke == "act_add") {
     		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			  $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`,`Status`) 
        VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir','$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '".$up_data['file_name']."','$JenjangStudi','$TempatLahir','Pengajuan')     ");
	      $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambahkan berikut upload file</div>");			
			  redirect('admin/jenis_beasiswa');			
		    } else {
        $this->db->query(" INSERT INTO `bsw_pemohon` (`JenisKelamin`,`BeasiswaID`,`TanggalLahir`, `Nama`, `MhswID`, `IPK`, `SKSLulus`, `Semester`, `Periode`, `Alamat`, `NoHP`, `Keterangan`, `PekerjaanOrtu`, `TanggunganOrtu`, `PenghasilanOrtu`, `ProdiID`, `KodePT`, `File`, `JenjangStudi`, `TempatLahir`, `Status`) 
        VALUES ('$JenisKelamin','$BeasiswaID', '$TanggalLahir', '$NamaMhsw', '$MhswID', '$IPK', '$SKSLulus', '$Semester', '$Periode', '$Alamat', '$NoHP', '$Keterangan', '$PekerjaanOrtu', '$TanggunganOrtu', '$PenghasilanOrtu', '$ProdiID', '$KodePT', '','$JenjangStudi','$TempatLahir','Pengajuan')     ");
	      $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Hanya menambah data tanpa upload</div>");			
			  redirect('admin/pengajuan_beasiswa');
        }
   	} else if ($mau_ke == "act_edt") {
		  	if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();	
				$this->db->query("UPDATE bsw_pemohon SET Periode = '$Periode',BeasiswaID = '$BeasiswaID',IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu', file = '".$up_data['file_name']."' WHERE PemohonID = '$idp'");
		  	} else {
				$this->db->query("UPDATE bsw_pemohon SET Periode = '$Periode',BeasiswaID = '$BeasiswaID',IPK = '$IPK', SKSLulus = '$SKSLulus', Semester = '$Semester', Alamat = '$Alamat', NoHP = '$NoHP', Keterangan = '$Keterangan', PekerjaanOrtu = '$PekerjaanOrtu', TanggunganOrtu = '$TanggunganOrtu', PenghasilanOrtu = '$PenghasilanOrtu' WHERE PemohonID = '$idp'");
			  }	
   			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
		   	redirect('admin/pengajuan_beasiswa');     
		} else if ($mau_ke == "rubahstatus") {
		  	$a['datpil']	= $this->db->query("SELECT * FROM bsw_pemohon WHERE PemohonID = '$idu'")->row();	
			  $a['page']		= "f_rubah_pengajuan_beasiswa";
	 	} else if ($mau_ke == "act_rubahstatus") {
			  $this->db->query("Update bsw_pemohon set Status='$StatusBeasiswa' WHERE PemohonID = '$idp'");
			  $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Status Beasiswa $Kode Telah dirubah</div>");			
			  redirect('admin/pengajuan_beasiswa');
		} else {
     SimpanSesi('BeasiswaID','pengajuan_beasiswa',$ID_BS);
			 $a['data']		= $this->db->query("SELECT t1.RandomChar,t1.Terkunci,t1.InputBy,t1.PemohonID,t1.MhswID,t1.Nama,t2.Nama as NamaProdi,t1.BeasiswaID,t1.Periode,t1.File,t1.Status FROM bsw_pemohon t1 inner join t_prodi t2 on t1.ProdiID=t2.ProdiID  WHERE $whereProdi t1.Periode='$PeriodeAktif' and t1.BeasiswaID='$ID_BS' and t1.NA='N' and t1.IsDeleted='N' ORDER BY t1.ProdiID,t1.PemohonID  DESC LIMIT $awal, $akhir ")->result();
			 $a['page']		= "l_pengajuan_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function import_excel_2003() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		
	
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	  $rand       = substr(md5(microtime()),rand(0,26),20);
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
//===============================================================================================================
public function import_excel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		    $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 
		
	
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		 $rand       = substr(md5(microtime()),rand(0,26),20);
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
//=============================================================================================================== 
public function bidik_misi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_inter_office WHERE YEAR(tgl_diterima) = '$ta'")->num_rows();
		$per_page		= 10;
			$rand       = substr(md5(microtime()),rand(0,26),20);
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
//=============================================================================================================== 
public function beasiswa_lain() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_inter_office WHERE YEAR(tgl_diterima) = '$ta'")->num_rows();
		$per_page		= 10;
			$rand       = substr(md5(microtime()),rand(0,26),20);
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
//===============================================================================================================
public function sk_lewat() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		    $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 	
  
  
  
  
  
  
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_kumpulan_sk  ")->num_rows();
		$per_page		= 10;
			$rand       = substr(md5(microtime()),rand(0,26),20);
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/sk_lewat/p");
		
		//ambil variabel URL
		$mau_ke				= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$NoSK		      = addslashes($this->input->post('NoSK'));
    $Keterangan		      = addslashes($this->input->post('Keterangan'));
		$BeasiswaID		= addslashes($this->input->post('BeasiswaID'));
    $Nama         = gval("bsw_jenis","BeasiswaID","Nama",$BeasiswaID);
    $PeriodeID    = gval("bsw_jenis","BeasiswaID","Periode",$BeasiswaID);
		$Tgl_SK		= addslashes($this->input->post('Tgl_SK'));
    $Tgl_SK    = date('Y-m-d' , strtotime($Tgl_SK));
    
    $Status = '1';
    $Periode			= addslashes($this->input->post('Periode'));
	 
		//upload config 
		$config['upload_path'] 		= './upload/SK';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "kunci") {
			$this->db->query("UPDATE t_kumpulan_sk set Terkunci='Y'  WHERE SKID = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">SK telah dikunci </div>");
			redirect('admin/sk_lewat');
      
    }else if ($mau_ke == "bukakunci") {
       $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Percobaan Akses Terlarang </div>");
       	redirect("admin/sk_lewat");  } 	
  
			$this->db->query("UPDATE t_kumpulan_sk set Terkunci='N'  WHERE SKID = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Kunci Telah Dibuka </div>");
			redirect('admin/sk_lewat');  
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_kumpulan_sk WHERE isi_ringkas LIKE '%$cari%' OR tujuan LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_sk_lewat";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(SKID)) AS last FROM t_kumpulan_sk WHERE YEAR(Tgl_SK) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_sk_lewat";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_kumpulan_sk WHERE SKID = '$idu'")->row();	
			$a['page']		= "f_sk_lewat";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_kumpulan_sk VALUES (NULL, '$BeasiswaID', '$PeriodeID', '$Nama','$NoSK',  '".$up_data['file_name']."', '$Tgl_SK','$Status','$Keterangan','N')");
			} else {
				$this->db->query("INSERT INTO t_kumpulan_sk VALUES (NULL, '$BeasiswaID', '$PeriodeID','$Nama','$NoSK',  '', '$Tgl_SK','$Status','$Keterangan','N')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/sk_lewat');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_kumpulan_sk SET Keterangan = '$Keterangan',NoSK = '$NoSK', BeasiswaID = '$BeasiswaID', File = '".$up_data['file_name']."',Tgl_SK = '$Tgl_SK'  WHERE SKID = '$idp'");
			} else {
				$this->db->query("UPDATE t_kumpulan_sk SET Keterangan = '$Keterangan',NoSK = '$NoSK', BeasiswaID = '$BeasiswaID', Tgl_SK = '$Tgl_SK' WHERE SKID = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/sk_lewat');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_kumpulan_sk LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_sk_lewat";
		}
		
		$this->load->view('admin/aaa', $a);
	}  
  
//===============================================================================================================   
public function kumpulan_sk() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		    $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 	
  
  
  
  
  
  
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_kumpulan_sk  ")->num_rows();
		$per_page		= 10;
			$rand       = substr(md5(microtime()),rand(0,26),20);
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/kumpulan_sk/p");
		
		//ambil variabel URL
		$mau_ke				= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$NoSK		      = addslashes($this->input->post('NoSK'));
    $Keterangan		      = addslashes($this->input->post('Keterangan'));
		$BeasiswaID		= addslashes($this->input->post('BeasiswaID'));
    $Nama         = gval("bsw_jenis","BeasiswaID","Nama",$BeasiswaID);
    $PeriodeID    = gval("bsw_jenis","BeasiswaID","Periode",$BeasiswaID);
		$Tgl_SK		= addslashes($this->input->post('Tgl_SK'));
    $Tgl_SK    = date('Y-m-d' , strtotime($Tgl_SK));
    
    $Status = '1';
    $Periode			= addslashes($this->input->post('Periode'));
	 
		//upload config 
		$config['upload_path'] 		= './upload/SK';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "kunci") {
			$this->db->query("UPDATE t_kumpulan_sk set Terkunci='Y'  WHERE SKID = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">SK telah dikunci </div>");
			redirect('admin/kumpulan_sk');
      
    }else if ($mau_ke == "bukakunci") {
       $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Percobaan Akses Terlarang </div>");
       	redirect("admin/kumpulan_sk");  } 	
  
			$this->db->query("UPDATE t_kumpulan_sk set Terkunci='N'  WHERE SKID = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Kunci Telah Dibuka </div>");
			redirect('admin/kumpulan_sk');  
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_kumpulan_sk WHERE isi_ringkas LIKE '%$cari%' OR tujuan LIKE '%$cari%' OR no_surat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_kumpulan_sk";
		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(SKID)) AS last FROM t_kumpulan_sk WHERE YEAR(Tgl_SK) = '".$this->session->userdata('admin_ta')."'")->row_array();
			$last	= str_pad(intval($q_nomer_terakhir['last']+1), 4, '0', STR_PAD_LEFT);

			$a['nomer_terakhir'] = $last;

			$a['page']		= "f_kumpulan_sk";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_kumpulan_sk WHERE SKID = '$idu'")->row();	
			$a['page']		= "f_kumpulan_sk";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_kumpulan_sk VALUES (NULL, '$BeasiswaID', '$PeriodeID', '$Nama','$NoSK',  '".$up_data['file_name']."', '$Tgl_SK','$Status','$Keterangan','N')");
			} else {
				$this->db->query("INSERT INTO t_kumpulan_sk VALUES (NULL, '$BeasiswaID', '$PeriodeID','$Nama','$NoSK',  '', '$Tgl_SK','$Status','$Keterangan','N')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/kumpulan_sk');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_kumpulan_sk SET Keterangan = '$Keterangan',NoSK = '$NoSK', BeasiswaID = '$BeasiswaID', File = '".$up_data['file_name']."',Tgl_SK = '$Tgl_SK'  WHERE SKID = '$idp'");
			} else {
				$this->db->query("UPDATE t_kumpulan_sk SET Keterangan = '$Keterangan',NoSK = '$NoSK', BeasiswaID = '$BeasiswaID', Tgl_SK = '$Tgl_SK' WHERE SKID = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/kumpulan_sk');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_kumpulan_sk LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_kumpulan_sk";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function rangkuman_beasiswa() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
			$rand       = substr(md5(microtime()),rand(0,26),20);
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM bsw_jenis ")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	    = $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/rangkuman_beasiswa/p");
		
		//ambil variabel URL
		$mau_ke			  = $this->uri->segment(3);
		$idu				  = $this->uri->segment(4);
		$cari				  = addslashes($this->input->post('q'));
    $PeriodeAktif = gval("t_periode","Status","Nama","1");
		//ambil variabel Postingan
		$idp				= addslashes($this->input->post('idp'));
	 
		 
		
		
		if ($mau_ke == "delxcrty") {
			$this->db->query("DELETE FROM t_surat_keluar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_keluar');
	 
		} else {
			$a['data']		= $this->db->query("SELECT * FROM bsw_jenis WHERE IsDeleted='N' and NA='N' and Periode='$PeriodeAktif' ORDER BY BeasiswaID DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_rangkuman_beasiswa";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function hasil_seleksi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
			$rand       = substr(md5(microtime()),rand(0,26),20);
		
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
//=============================================================================================================== 
public function tim_seleksi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
			$rand       = substr(md5(microtime()),rand(0,26),20);
		
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
//=============================================================================================================== 
public function export_excel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		    $Boleh =CekHakAkses();
  if ($Boleh=='0'){ 	redirect("admin/login");  } 
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
			$rand       = substr(md5(microtime()),rand(0,26),20); 	
		//ambil variabel Postingan
		$BeasiswaID					= addslashes($this->input->post('JenisBeasiswa'));
	//	$cari					= addslashes($this->input->post('q'));
		
		
		
if ($mau_ke == "download") {
		
/* pagination */	
	
$this->load->library('ExcelSimple');  
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$filename = "example.xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
//Ini header Excel
$header = array(
	'NPM'=>'string',//0
	'KDPTI'=>'string',//1
	'JENIS_BEASISWA'=>'string',//2
	'COUNTER'=>'string',//3
	'NAMA_MHS'=>'string',//4
	'JK'=>'string',//5
	'KODE_PRODI'=>'string',//6
	'ID_JENJANG'=>'string',//7
	'SMT'=>'string',//8
	'IPK'=>'string',//9
	'KODE_PEKERJAAN'=>'string',//10
	'JML_TANGGUNGAN'=>'string',//11
	'PENGHASILAN'=>'integer',//12
	'PRESTASI'=>'string',//13
	'MULAI_BULAN'=>'YYYY-MM-DD',//14
	'SELESAI_BULAN'=>'YYYY-MM-DD',//15
	'TAHUN'=>'string',//16
	'KETERANGAN'=>'string',//17
	'ALAMAT'=>'string',//18
	'TELEPON'=>'string'//19
  );
 
$no=1;
//Styles untuk isi ada 20 field
$styles8 = array( ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],);






$writer = new XLSXWriter();
$writer->setAuthor('Beasiswa IKIP PGRI Bojonegoro'); 
//TulisHeader
$writer->writeSheetHeader('Sheet1', $header);
//Tulis Isi
$PeriodeAktif = gval("t_periode","Status","Nama","1");
$rows = $this->db->query(" select * from bsw_pemohon where BeasiswaID='$BeasiswaID' and Periode='$PeriodeAktif' and IsDeleted='N' order by ProdiID asc; ")->result();
//$rows = $this->db->query(" select * from bsw_pemohon where BeasiswaID='12' and Periode='2018' and IsDeleted='N' order by ProdiID asc ")->result();
foreach($rows as $row)
{	
	$data=array();
	//Data data mana saja yg mau dimasukkan ke excel, diurutkan sesuai kolom di excel
	$data[0]=$row->MhswID;
	$data[1]=$row->KodePT;
	$data[2]=$row->BeasiswaID;
	$data[3]=$no;
	$data[4]=$row->Nama;
	$data[5]=$row->JenisKelamin;
  $data[6]=$row->ProdiID;
	$data[7]='5';
	$data[8]=$row->Semester;
	$data[9]=$row->IPK;
	$data[10]=$row->PekerjaanOrtu;
	$data[11]=$row->TanggunganOrtu;
 	$data[12]=$row->PenghasilanOrtu; //Integer
	$data[13]=$row->Prestasi;
	$data[14]='2018-11-01';  //Tanggal
	$data[15]='2018-12-12';  //Tanggal
	$data[16]=$row->Periode;
	$data[17]=$row->Keterangan;
	$data[18]=$row->Alamat;
	$data[19]=$row->NoHP;
	
	
	$no++;
	//$writer->writeSheetRow('Sheet1', $row);
	$writer->writeSheetRow('Sheet1', $data,$styles8);
}

 
$writer->writeToStdOut();
exit(0);
 		
		} else {
	 		$a['data']		= '';
	 		$a['page']		= "l_export_excel";
		}
 		$this->load->view('admin/aaa', $a);	
	}	  
//===============================================================================================================
public function export_arsip() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
			$rand       = substr(md5(microtime()),rand(0,26),20); 	
		//ambil variabel Postingan
		$BeasiswaID					= addslashes($this->input->post('JenisBeasiswa'));
	//	$cari					= addslashes($this->input->post('q'));
		
		
		
if ($mau_ke == "download") {
		
/* pagination */	
	
$this->load->library('ExcelSimple');  
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$filename = "example.xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
//Ini header Excel
$header = array(
	'NPM'=>'string',//0
	'KDPTI'=>'string',//1
	'JENIS_BEASISWA'=>'string',//2
	'COUNTER'=>'string',//3
	'NAMA_MHS'=>'string',//4
	'JK'=>'string',//5
	'KODE_PRODI'=>'string',//6
	'ID_JENJANG'=>'string',//7
	'SMT'=>'string',//8
	'IPK'=>'string',//9
	'KODE_PEKERJAAN'=>'string',//10
	'JML_TANGGUNGAN'=>'string',//11
	'PENGHASILAN'=>'integer',//12
	'PRESTASI'=>'string',//13
	'MULAI_BULAN'=>'YYYY-MM-DD',//14
	'SELESAI_BULAN'=>'YYYY-MM-DD',//15
	'TAHUN'=>'string',//16
	'KETERANGAN'=>'string',//17
	'ALAMAT'=>'string',//18
	'TELEPON'=>'string'//19
  );
 
$no=1;
//Styles untuk isi ada 20 field
$styles8 = array( ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'center','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],
                  ['halign'=>'left','border'=>'left,right,top,bottom','border-style'=>'thin'],);






$writer = new XLSXWriter();
$writer->setAuthor('Beasiswa IKIP PGRI Bojonegoro'); 
//TulisHeader
$writer->writeSheetHeader('Sheet1', $header);
//Tulis Isi
$PeriodeAktif = gval("t_periode","Status","Nama","1");
$rows = $this->db->query(" select * from bsw_pemohon where BeasiswaID='$BeasiswaID' and Periode='$PeriodeAktif' and IsDeleted='N' order by ProdiID asc; ")->result();
//$rows = $this->db->query(" select * from bsw_pemohon where BeasiswaID='12' and Periode='2018' and IsDeleted='N' order by ProdiID asc ")->result();
foreach($rows as $row)
{	
	$data=array();
	//Data data mana saja yg mau dimasukkan ke excel, diurutkan sesuai kolom di excel
	$data[0]=$row->MhswID;
	$data[1]=$row->KodePT;
	$data[2]=$row->BeasiswaID;
	$data[3]=$no;
	$data[4]=$row->Nama;
	$data[5]=$row->JenisKelamin;
  $data[6]=$row->ProdiID;
	$data[7]='5';
	$data[8]=$row->Semester;
	$data[9]=$row->IPK;
	$data[10]=$row->PekerjaanOrtu;
	$data[11]=$row->TanggunganOrtu;
 	$data[12]=$row->PenghasilanOrtu; //Integer
	$data[13]=$row->Prestasi;
	$data[14]='2018-11-01';  //Tanggal
	$data[15]='2018-12-12';  //Tanggal
	$data[16]=$row->Periode;
	$data[17]=$row->Keterangan;
	$data[18]=$row->Alamat;
	$data[19]=$row->NoHP;
	
	
	$no++;
	//$writer->writeSheetRow('Sheet1', $row);
	$writer->writeSheetRow('Sheet1', $data,$styles8);
}

 
$writer->writeToStdOut();
exit(0);
 		
		} else {
	 		$a['data']		= '';
	 		$a['page']		= "l_export_arsip";
		}
 		$this->load->view('admin/aaa', $a);	
	}	  
//=============================================================================================================== 	
  
//=============================================================================================================== 	
public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}		
    
      $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Percobaan Akses Terlarang </div>");
       	redirect("admin");  } 

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$rand       = substr(md5(microtime()),rand(0,26),20);
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
			redirect('admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
//=============================================================================================================== 	
public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
    
      $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Anda tidak memiliki Hak Akses di modul tersebut </div>");
       	redirect("admin");  } 

	
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
	  $RandomChar				= $this->uri->segment(4);
  	$idu					 		=   gval("t_admin","RandomChar","id",$RandomChar);
		$rand       = substr(md5(microtime()),rand(0,26),20);
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
    $LevelID					= addslashes($this->input->post('LevelID'));
    $ProdiID					= addslashes($this->input->post('ProdiID'));
		$Status ='1';
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/manage_admin');
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
			
			redirect('admin/manage_admin');
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
				$this->db->query("INSERT INTO t_admin VALUES (NULL, '$username', '$password', '$nama', '$nip', '$LevelID','$Status','$ProdiID')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('admin/manage_admin');
		} else if ($mau_ke == "act_edt") {
				$this->db->query("UPDATE t_admin SET username = '$username', nama = '$nama', nip = '$nip', LevelID = '$LevelID', ProdiID = '$ProdiID' WHERE id = '$idp'");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			
			
			redirect('admin/manage_admin');   
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function get_mhsw() {
  $kode 				= $this->input->post('kode',TRUE);
  $UserID = $this->session->userdata('admin_id');
  $AksesProdi = gval("t_admin","id","ProdiID",$UserID);
 	$rand       = substr(md5(microtime()),rand(0,26),20);
  if($AksesProdi=='xx')
  {
  $whereProdi =' ';
  }
  else
  {
  $whereProdi=" ProdiID='$AksesProdi' and ";
  }
  
    if (strlen($kode)<3) {
            //do nothing;
          }
      else {
    	$data 				=  $this->db->query("SELECT * from mhsw WHERE  $whereProdi (Nama LIKE '%$kode%' or MhswID like '%$kode%')  ORDER BY Nama asc")->result();
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
      $json_array['JenjangStudi']	= '5'; // Untuk Sarjana S-1 nilai adalah 5
      $json_array['KodePT']	= '072011'; // Untuk IKIP kode= 072011
      $json_array['JenisKelamin']	= $d->Kelamin;
        
     
      $datamhsw[] 			= $json_array;
  		}
		echo json_encode($datamhsw);
     }
    
    
	}    
//===============================================================================================================  
public function get_instansi_lain() {
		$kode 				= $this->input->post('dari',TRUE);
		
		$data 				=  $this->db->query("SELECT dari FROM t_surat_masuk WHERE dari LIKE '%$kode%' GROUP BY dari")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$klasifikasi[] 	= $d->dari;
		}
		
		echo json_encode($klasifikasi);
	}
//=============================================================================================================== 	
public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ke				= $this->uri->segment(3);
		$id_user		= $this->session->userdata('admin_id');
		$rand       = substr(md5(microtime()),rand(0,26),20);
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
			$cek_password_lama	= $this->db->query("SELECT password FROM t_admin WHERE id = $id_user")->row();
			//echo 
			
			if ($cek_password_lama->password != $p1) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Lama tidak sama</div>');
				redirect('admin/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('admin/passwod');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('admin/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 
public function resetpassword() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
      $Boleh =CekAdmin();
       if ($Boleh=='0'){ 
       	$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Anda tidak memiliki Hak Akses di modul tersebut </div>");
       	redirect("admin");  } 


		
		$ke				= $this->uri->segment(3);
   	$RandomChar			= $this->uri->segment(4);
    $id_user			=   gval("t_admin","RandomChar","id",$RandomChar);
   	$UserID		= addslashes($this->input->post('UserID'));
		
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
	
		 if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('admin/resetpassword');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE RandomChar = '$UserID' ");
				$this->session->set_flashdata('k', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('admin/manage_admin');
			}
		} else {
    
     	$a['datpil']	= $this->db->query("SELECT * FROM t_admin WHERE id = '$id_user'")->row();
			$a['page']	= "f_resetpassword";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//=============================================================================================================== 	
public function login() {
		$this->load->view('admin/login');
	}
//=============================================================================================================== 	
public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
		$ta 	= $this->security->xss_clean($this->input->post('ta'));
    $p 		= md5($this->security->xss_clean($this->input->post('p')));
  
    $sql ="SELECT * from t_admin WHERE username= ? AND password = ? ";
    $j_cek =  $this->db->query($sql,array($u,$p))->num_rows();
    $d_cek =  $this->db->query($sql,array($u,$p))->row();
 
 
		
        if($j_cek == 1) {
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->nama,
                    'admin_ta' => $ta,
                    'admin_level' => $d_cek->LevelID,
					'admin_valid' => true
                    );
            $this->session->set_userdata($data);
            redirect('admin');
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('admin/login');
		}
	}
//=============================================================================================================== 	
public function beasiswa_dashboard() {
	if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
		redirect("admin/login");
	}
     	
	
	//ambil variabel URL
	$mau_ke				= $this->uri->segment(3);
	 
	$PeriodeTampil	= addslashes($this->input->post('NamaPeriode'));
  $PeriodeAktif   = gval("t_periode","Status","Nama","1");       
 
	 
	if ($mau_ke == "tampilkan") {
   SimpanSesi('PeriodeID','beasiswa_dashboard',$PeriodeTampil);
   
   	$a['data']		= $this->db->query("SELECT * FROM bsw_jenis WHERE IsDeleted='N' and Status='1' and NA='N' and Periode='$PeriodeTampil' ORDER BY BeasiswaID DESC  ")->result();
		$a['page']		= "d_amain2";

  	} else {
     
    SimpanSesi('PeriodeID','beasiswa_dashboard',$PeriodeAktif);
		$a['data']		= $this->db->query("SELECT * FROM bsw_jenisx WHERE IsDeleted='N' and Status='1' and NA='N' and Periode='$PeriodeAktif' ORDER BY BeasiswaID DESC  ")->result();
		$a['page']		= "d_amain2";
	}
	
	$this->load->view('admin/aaa', $a);	
}












//================================================================================================================
public function logout(){
        $this->session->sess_destroy();
		redirect('admin/login');
    }
}
