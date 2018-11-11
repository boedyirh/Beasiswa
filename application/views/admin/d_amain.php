<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"><span class="glyphicon glyphicon-dashboard"></span>  Dashboard</h3></div>
</div>

<div class="panel panel-success">
	<div class="panel-heading">Statistik Tahun <?php echo $this->session->userdata('admin_ta'); ?></div>
	<div class="panel-body">
		<div class="col-md-6">
			<b>Statistik Surat Masuk Berdasarkan Bulan</b>
			<table class="table table-bordered">
				<thead>
					<tr  bgcolor=#cce6ff>
						<th>Bulan</th>
						<th class="text-center">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$jml = 0;
					if (!empty($s_surat_masuk_bln)) {
						foreach ($s_surat_masuk_bln as $smb) {
            
            $bulan=namabulan($smb['bln']);
            
            
            
							echo '<tr><td>'.$bulan.'</td><td class="text-center">'.$smb['jml'].'</td></tr>';
							$jml += $smb['jml'];
						}
					} else {
						echo '<tr><td colspan="2">tidak ada data</td></tr>';
					}
					?>
					<tr>
						<td>Jumlah Total</td>
						<td class="text-center"><?php echo $jml; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
    
		<div class="col-md-6">
			<b>Statistik Surat Keluar Berdasarkan Bulan</b>
			<table class="table table-bordered">
				<thead>
					<tr  bgcolor=#cce6ff>
						<th>Bulan</th>
						<th class="text-center">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$jml2 = 0;
					if (!empty($s_surat_keluar_bln)) {
						foreach ($s_surat_keluar_bln as $skb) {
						   $bulan=namabulan($smb['bln']);
            	echo '<tr><td>'.$bulan.'</td><td class="text-center">'.$skb['jml'].'</td></tr>';
							$jml2 += $skb['jml'];
						}
					} else {
						echo '<tr><td colspan="2">tidak ada data</td></tr>';
					}
					?>
					<tr>
						<td>Jumlah Total</td>
						<td class="text-center"><?php echo $jml2; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
    
    
		
		<div class="clearfix"></div>

		<div class="col-md-6">
			<b>Statistik Surat Masuk Berdasarkan Kode</b>
			<table class="table table-bordered">
				<thead>
				<tr  bgcolor=#cce6ff>
						<th>Kode</th>
						<th class="text-center">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (!empty($s_surat_masuk_kode)) {
						foreach ($s_surat_masuk_kode as $smk) {
							echo '<tr><td>'.$smk['kode'].'</td><td class="text-center">'.$smk['jml'].'</td></tr>';
						}
					} else {
						echo '<tr><td colspan="2">tidak ada data</td></tr>';
					}
					?>
				</tbody>
			</table>
		</div>

		<div class="col-md-6">
			<b>Statistik Surat Keluar Berdasarkan Kode</b>
			<table class="table table-bordered">
				<thead>
				<tr  bgcolor=#cce6ff>
						<th>Kode</th>
						<th class="text-center">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (!empty($s_surat_keluar_kode)) {
						foreach ($s_surat_keluar_kode as $skk) {
							echo '<tr><td>'.$skk['kode'].'</td><td class="text-center">'.$smk['jml'].'</td></tr>';
						}
					} else {
						echo '<tr><td colspan="2">tidak ada data</td></tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
