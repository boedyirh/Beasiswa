<?php

 $UserID =  $this->uri->segment(3);
 $UserName = gval("t_admin","RandomChar","username",$UserID) ;
?>



<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-lock"></span> Ubah Password</h3></div>
</div>


	<?php echo $this->session->flashdata("k_passwod");?>
<div class="well">
<form action="<?php echo base_URL()?>index.php/admin/resetpassword/simpan" method="post" accept-charset="utf-8" enctype="multipart/form-data">	

	<table class="table-form" width="100%">
	<tr><td width="20%">Username</td><td><b><input type="text" name="username" class="form-control" readonly value="<?php echo $UserName; ?>" style="width: 200px"></b></td></tr>		
	<input type="hidden" name="UserID" class="form-control"  value="<?php echo $UserID; ?>" style="width: 200px">
   		
	<tr><td>Password baru</td><td><input type="password" name="p2" class="form-control" style="width: 200px" autofocus required></td></tr>		
	<tr><td>Ulangi Password baru</td><td><input type="password" class="form-control" name="p3" style="width: 200px" required></td></tr>		
	
	<tr><td colspan="2">
	<br>
	<button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL()?>admin/manage_admin" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
	</fieldset>
</form>
</div>