
<div class="content-wrapper">
	
	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">DETAIL DATA TBL_KEPSKHAKIM</h3>
			</div>
		
		<table class='table table-bordered'>        

	
			<tr>
				<td>Nomor Sk</td>
				<td><?php echo $nomor_sk; ?></td>
			</tr>
	
			<tr>
				<td>Tanggal Sk</td>
				<td><?php echo $tanggal_sk; ?></td>
			</tr>
	
			<tr>
				<td>Perihal</td>
				<td><?php echo $perihal; ?></td>
			</tr>
	
			<tr>
				<td>Keterangan</td>
				<td><?php echo $keterangan; ?></td>
			</tr>
			
			<tr>
				<td>Nama File</td>
				<td><?php echo anchor(site_url('assets/file_skhakim/'.$nama_file),'<i class="fa fa-eye" aria-hidden="true"></i>','class="btn btn-danger btn-sm", target="_blank"');  ?></td>
			</tr>
	
			<tr>
				<td></td>
				<td><a href="<?php echo site_url('kepskhakim') ?>" class="btn btn-default">Kembali</a></td>
			</tr>
	
		</table>
		</div>
	</section>
</div>