<?php 
	$br = new lsp();
	if ($_SESSION['level'] != "Master") {
    header("location:../index.php");
  	}
	$table    = "tm_barang_bhp";
	$data     = $br->selectWhere($table, "id_barang_bhp", $_GET['id']);
	$getKategoribarangBhp = $br->select("tm_kategori_bhp");
	$waktu    = date("Y-m-d");

	if (isset($_POST['getSimpan'])) {
		$id_barang_bhp  = $br->validateHtml($_POST['id_barang_bhp']);
		$id_kategori_bhp  = $br->validateHtml($_POST['id_kategori_bhp']);
		$nama_barang_bhp = $br->validateHtml($_POST['nama_barang_bhp']);

		if ($id_barang_bhp == " " || $id_kategori_bhp == " " || $nama_barang_bhp == " ") {
			$response = ['response'=>'negative','alert'=>'lengkapi field'];
		}else{
			$value = "id_barang_bhp='$id_barang_bhp', id_kategori_bhp='$id_kategori_bhp', nama_barang_bhp='$nama_barang_bhp', tanggal_update='$waktu'";
			$response = $br->update($table, $value, "id_barang_bhp", $_GET['id'], "?page=viewMasterBarangBhp");
		}
	}
 ?>

<div class="main-content" style="margin-top: 20px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
            	<div class="col-md-12">
            		<form method="post" enctype="multipart/form-data">
            			<div class="card">
            				<div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
	                            <div class="bg-overlay bg-overlay--blue"></div>
	                            <h3>
	                            <i class="zmdi zmdi-account-calendar"></i>Data Barang</h3>
                        	</div>
                        	<div class="card-body">
                        		<div class="col-12">
                        			<div class="row">
                        				<div class="col-md-12">
                        					<div class="form-group">
												<label for="">ID barang</label>
												<input type="text" class="form-control" name="id_barang_bhp" value="<?php echo $data['id_barang_bhp']; ?>" readonly>
											</div>
											<div class="form-group">
												<label for="">Nama barang</label>
												<input type="text" class="form-control" name="nama_barang_bhp" value="<?php echo @$data['nama_barang_bhp'] ?>">
											</div>
											<div class="form-group">
												<label for="">Kategori Barang</label>
												<select name="id_kategori_bhp" class="form-control">
													<option value=" ">Pilih Kategori Barang</option>
													<?php foreach($getKategoribarangBhp as $kbb) { ?>
														<?php if ($kbb['id_kategori_bhp'] == $data['id_kategori_bhp']){ ?>
															<option value="<?= $kbb['id_kategori_bhp'] ?>" selected><?= $kbb['nama_kategori_bhp'] ?>
															</option>
														<?php } else { ?>
															<option value="<?= $kbb['id_kategori_bhp'] ?>"><?= $kbb['nama_kategori_bhp'] ?></option>
														<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
                        			</div>
                        		</div>
                        	</div>
                        	<div class="card-footer">
                        		<button name="getSimpan" class="btn btn-primary"><i class="fa fa-download"></i> Update</button>
                        		<a href="?page=viewMasterBarangBhp" class="btn btn-warning" style="float: right;"><i class="fa fa-arrow-left"></i> Kembali</a>
                        	</div>
            			</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>