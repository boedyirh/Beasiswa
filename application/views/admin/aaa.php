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
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/color.css" media="screen">
   
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
         <span class="navbar-brand"><strong style="font-family: verdana;"><span class="glyphicon glyphicon-education"></span> Kampus</strong></span>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">	
			<li><a href="<?php echo base_url(); ?>admin"><span class="glyphicon glyphicon-home"></span>  Beranda</a></li>
      
      
      <?php
      // data main menu  ====================================================================================================
      //Cek Hak Akses User
         $UserSession = $this->session->userdata('admin_id');
         $LevelUser= gval('t_admin','id','LevelId',$UserSession);
         
         //Ambil menu utama berdasarkan Level User
          $main_menu = $this->db->order_by('id', 'ASC')
                                           ->like('LevelID', $LevelUser)
                                          ->get_where('t_menu', array('is_main_menu' => 0,'NA'=>'N')); 
          
          //              
          foreach ($main_menu->result() as $main) { 
           ?>             
          <!-- Tampilkan Judul untuk Main Menu -->
           <li class="dropdown">            
				   <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="<?php echo $main->icon;?>"></span> <?php echo $main->judul_menu;?><span class="caret"></span></a>
				            <!-- Tampikan Judul untuk sub menu berdasarkan main menu  -->
                    <?php               
                    $sub_menu = $this->db->order_by('id', 'ASC')
                                         ->like('LevelID', $LevelUser)
                                         ->get_where('t_menu', array('is_main_menu' => $main->id,'NA'=>'N'));
                    if ($sub_menu->num_rows() > 0) {    //Jika ada submenu
                    ?>
                                   
                   <!-- Mulai Group SubMenu   -->
                   <ul class="dropdown-menu" aria-labelledby="themes">
                   <!-- Ambil Data SubMenu -->
                   <?php foreach ($sub_menu->result() as $sub) {                         
                  if($sub->modul =='Separator')     
                   { ?>
                    <li role="presentation" class="divider"></li>
                  <?php }
                    else {
                   ?>   
                   
                                      
           	       <li><a tabindex="-1" href="<?php echo base_url(); ?><?php echo $sub->link;?>"><?php echo $sub->judul_menu;?></a></li>                        
                 
                 
                 
                  <?php    }
                                                                } ?>
                   </ul>                              <?php
                 }}?>
            
            
  
      
      
      

  
		
			<?php
			if ($this->session->userdata('admin_level') == "a") {    // a= Super admin
			?>
		<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-cog"></span> </i> Setting <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/pengguna">Nama Instansi</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_admin">Manajemen User</a></li>
                 <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_menu">Manajemen Menu</a></li>
                   <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_akses">Manajemen Akses</a></li>
              </ul>
            </li>
			<?php 
			}
			?>
          </ul>
            <ul class="nav navbar-nav ">
            <?php 
             $PeriodeAktif= gval("t_periode", "Status", "Nama", "1");
            if ($this->session->userdata('admin_level') == "a") { 
             
            ?>
          	<li><a href="<?php echo base_url(); ?>admin/periode"><span class="glyphicon glyphicon-eye-open"></span> Periode Aktif : <?php echo $PeriodeAktif; ?></a></li>
            
            <?php 
            }
            
            else
            {
              ?>
            	<li><a href="#"><span class="glyphicon glyphicon-eye-open"></span> Periode Aktif : <?php echo $PeriodeAktif; ?></a></li>
            <?php 
            
            }
            
            ?>
            
            
            
            
            
            
             </ul>
       
       
       
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-user"></span></i> <?php echo $this->session->userdata('admin_nama'); ?> <span class="caret"></span></a>
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
		<h6>&copy;  2018. Waktu Eksekusi : {elapsed_time}, Penggunaan Memori : {memory_usage}</h6>
	  </div>
 
    </div>

  
</body></html>
