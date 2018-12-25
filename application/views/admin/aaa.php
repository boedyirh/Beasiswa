<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
	<title>.:: Beasiswa ::.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
	<style type="text/css">
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Cabin Regular'), local('Cabin-Regular'), url(<?php echo base_url(); ?>assets/font/satu.woff) format('woff');
	}
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 700;
	  src: local('Cabin Bold'), local('Cabin-Bold'), url(<?php echo base_url(); ?>assets/font/dua.woff) format('woff');
	}
	@font-face {
	  font-family: 'Lobster';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Lobster'), url(<?php echo base_url(); ?>assets/font/tiga.woff) format('woff');
	}	
	
	</style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" media="screen">
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/css/AdminLTE.min.css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" media="screen">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/ionicons/css/ionicons.min.css" media="screen">
    
    
    
    
    
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/bootstrap/assets/js/html5shiv.js"></script>
      <script src="../bower_components/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery/jquery-ui.css" />
     <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootswatch.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery/jquery-ui.js"></script>
	<script type="text/javascript">
	// <![CDATA[
  
   function addCommas(nStr) {
      nStr += '';
      var comma = /,/g;
      nStr = nStr.replace(comma,'');
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
    }
         
    function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
        
            if ( (charCode > 31 && charCode < 48) || charCode > 57) {
                return false;
            }
            return true;
        }
        
        
        
  function isNumberKey(txt, evt) {

    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 44||charCode == 46) {   
        //Check if the text already contains the . or , character
        if (txt.value.indexOf('.') === -1) {
            return true;
        } else {
            return false;
        }
    } else {
        if (charCode > 31
             && (charCode < 48 || charCode > 57))
            return false;
    }
    return true;
}      
        
        
         


        
        
        
      
   
	$(document).ready(function () {
		$(function () {
			$( "#kode_surat" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_klasifikasi'); ?>",
						data: { kode: $("#kode_surat").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
    
    
 
  

        $(function () {
      $( "#NamaMhsw" ).autocomplete({
        source: function(request, response) {
          $.ajax({ 
            url: "<?php echo site_url('admin/get_mhsw'); ?>",
            data: { kode: $("#NamaMhsw").val()},
            dataType: "json",
            type: "POST",
            success: function(data){ 
            response($.map(data, function(item,ui)
             {
                        return {
                            label: item.label,
                            value: item.value,
                            NamaMhsw:item.Nama,
                            ProdiID:item.ProdiID,
                            MhswID:item.MhswID,
                            TempatLahir:item.TempatLahir,
                            JenjangStudi:item.JenjangStudi,
                            JenisKelamin:item.JenisKelamin,
                            KodePT:item.KodePT,
                            TanggalLahir:item.TanggalLahir
                       };
                } 
          
            ));
            
            
          
            }    
          });
        }, 
        select: function( event, ui ) {
                    
                  
                   $('#NamaMhsw').val(ui.item.NamaMhsw); 
                   $("#MhswID").val(ui.item.MhswID);
                   $("#ProdiID").val(ui.item.ProdiID);
                   $("#TempatLahir").val(ui.item.TempatLahir);
                   $("#JenisKelamin").val(ui.item.JenisKelamin);
                   $("#JenjangStudi").val(ui.item.JenjangStudi);
                   $("#KodePT").val(ui.item.KodePT);
                   $("#TanggalLahir").val(ui.item.TanggalLahir);
                   document.getElementById("NamaMhsw").readOnly = true;
                   document.getElementById("MhswID").readOnly = true;
                   document.getElementById("NextStop").focus(); 
                    return false;
                },
      });
    }); 

    
       
		

		
    
		$(function() {
			$( "#tgl_surat" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});
    
  		
		$(function() {
			$( "#tgl_mulai" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});
    
    		
		$(function() {
			$( "#tgl_selesai" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});  
    
   
    
    
    
	});
  
	// ]]>
	</script>
	</head>
	
  <body style="">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
         <span class="navbar-brand"><strong style="font-family: verdana;"><span class="fa fa-graduation-cap"></span> Beasiswa</strong></span>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">	
			<li><a href="<?php echo base_url(); ?>admin"><span class="glyphicon glyphicon-home"></span>  Beranda</a></li>
            <li class="dropdown">            
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-tasks"></span>  Referensi <span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="themes">
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/jenis_beasiswa">Jenis Beasiswa</a></li>
        <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/periode">Periode</a></li>
        <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/grademahasiswa">Grade Mahasiswa</a></li>
        <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/prodi">Program Studi</a></li>
		
				</ul>
            </li>
		<?php
		if ($this->session->userdata('admin_level') != "Super Adminxxxxxx") {
		?>	
		<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-tint"></span> Proses <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/pengajuan_beasiswa">Permohonan Beasiswa</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/beasiswa_disetujui">Beasiswa Disetujui</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/rangkuman_beasiswa">Rangkuman Pendaftar Beasiswa</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/kumpulan_sk">Kumpulan SK</a></li>
              </ul>
            </li>
            	<?php } ?>
              
    <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-cloud-download"></span> Download Data <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                  <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/export_excel">Export Data Excel</a></li>
    
              </ul>
            </li>          
              
              
              
              
              

		
			<?php
			if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
		<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-cog"></span> </i> Pengaturan <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/pengguna">Instansi Pengguna</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_admin">Manajemen Admin</a></li>
              </ul>
            </li>
			<?php 
			}
			?>
          </ul>
            <ul class="nav navbar-nav ">
            <?php 
             $PeriodeAktif= gval("t_periode", "Status", "Nama", "1");
            ?>
          	<li><a href="<?php echo base_url(); ?>admin/periode"><span class="glyphicon glyphicon-eye-open"></span> Periode Aktif : <?php echo $PeriodeAktif; ?></a></li>
             </ul>
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-user"></span></i> Administrator <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/passwod">Rubah Password</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/logout">Logout</a></li>
                <li><a tabindex="-1" href="http://www.ikippgribojonegoro.ac.id/arsip.html" target="_blank">Help</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </div>

	<?php 
	$q_instansi	= $this->db->query("SELECT * FROM tr_instansi LIMIT 1")->row();
	echo $this->session->userdata('admin_level');
	?>
    <div class="container">

      <div class="page-header" id="banner">
        <div class="row">
          <div class="" style="padding: 15px 15px 0 15px;">
			<div class="well well-sm">
				<img src="<?php echo base_url(); ?>upload/<?php echo $q_instansi->logo; ?>" class="thumbnail span3" style="display: inline; float: left; margin-right: 20px; width: 100px; height: 100px">
                <h2 style="margin: 15px 0 10px 0; color: #000;"><?php echo $q_instansi->nama; ?></h2>
                <div style="color: #000; font-size: 16px; font-family: Tahoma" class="clearfix"><b>Alamat : <?php echo $q_instansi->alamat; ?></b></div>
             </div>
          </div>
        </div>
      </div>

		<?php $this->load->view('admin/'.$page); ?>
	  
	  <div class="span12 well well-sm">
		<h4 style="font-weight: bold">Sistem Informasi Beasiswa</a></a></h4>
		<h6>&copy;  2013. Waktu Eksekusi : {elapsed_time}, Penggunaan Memori : {memory_usage}</h6>
	  </div>
 
    </div>

  
</body></html>
