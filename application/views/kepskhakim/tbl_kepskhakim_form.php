<div class="content-wrapper">
	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo strtoupper($button) ?> DATA TBL_KEPSKHAKIM</h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">
			
				<table class='table table-bordered'>
	
					<tr>
						<td width='200'>Nomor Sk <?php echo form_error('nomor_sk') ?></td><td><input type="text" class="form-control" name="nomor_sk" id="nomor_sk" placeholder="Nomor Sk" value="<?php echo $nomor_sk; ?>" /></td>
					</tr>
	
					<tr>
						<td width='200'>Tanggal Sk <?php echo form_error('tanggal_sk') ?></td>
						<td><input type="date" class="form-control" name="tanggal_sk" id="tanggal_sk" placeholder="Tanggal Sk" value="<?php echo $tanggal_sk; ?>" /></td>
					</tr>
	    
					<tr>
						<td width='200'>Perihal <?php echo form_error('perihal') ?></td>
						<td> <textarea class="form-control" rows="3" name="perihal" id="perihal" placeholder="Perihal"><?php echo $perihal; ?></textarea></td>
					</tr>
	    
					<tr>
						<td width='200'>Keterangan <?php echo form_error('keterangan') ?></td>
						<td> <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea></td>
					</tr>

					<tr>
						<!-- <td width='200'>Nama File <?php echo form_error('nama_file') ?></td>
						<td> <textarea class="form-control" rows="3" name="nama_file" id="nama_file" placeholder="Nama File"><?php echo $nama_file; ?></textarea></td> -->
						<td width='200'>
						<div class="form-group">
						<label for="nama_file">Nama File</label>
						</td>
						<td>
						<div class="input-group">
						<div class="custom-file">
						<input type="file" class="custom-file-input" id="nama_file" name="nama_file">
						</div>
						
						</div>
						</div>
						</td>
					</tr>
	
					<tr>
						<td></td>
						<td>
							<input type="hidden" name="id_skketua" value="<?php echo $id_skketua; ?>" /> 
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
							<a href="<?php echo site_url('kepskhakim') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
	
				</table>
			</form>
		</div>
	</section>
</div>