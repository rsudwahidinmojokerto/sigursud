<?php 
	$br = new lsp();
	if ($_SESSION['level'] != "Master") {
    header("location:../index.php");
  	}
	$table    = "tm_user";
	$data     = $br->selectWhere($table, "id_user", $_GET['id']);
	// $getJenisbarang = $br->select("table_jenisbarang");
	// $getDistr = $br->select("table_distributor");
	$waktu    = date("Y-m-d");
	if (isset($_POST['getSimpan'])) {
		$id_user  = $br->validateHtml($_POST['id_user']);
		$nama_user  = $br->validateHtml($_POST['nama_barang']);
		$username = $br->validateHtml($_POST['username']);
		$password  = $br->validateHtml($_POST['distributor']);
		$confirm        = $br->validateHtml($_POST['confirm']);
		$id_level       = $br->validateHtml($_POST['id_level']);
		$ket          = $_POST['ket'];

		if ($Id_user == " " || $nama_user == " " || $username == " " || $password == " " || $confirm == " " || $id_level == " ") {
			$response = ['response'=>'negative','alert'=>'lengkapi field'];
		}else{
			// if ($harga < 0 || $stok < 0) {
			//  	$response = ['response'=>'negative','alert'=>'harga atau stok tidak boleh mines'];
			// }else{
				if ($_FILES['foto']['name'] == "") {
					$value = "id_user='$Id_user', nama_user='$nama_user', username='$username', password='$password', tanggal_masuk='$waktu',harga_barang='$harga',stok_barang='$stok',keterangan='$ket'";
					$response = $br->update($table, $value, "id_user", $_GET['id'], "?page=viewPegawai");
				}else{
					$response = $br->validateImage();
					if ($response['types'] == "true") {
						$value = "id_user='$Id_user',nama_user='$nama_user',username='$username',password='$password',tanggal_masuk='$waktu',harga_barang='$harga',stok_barang='$stok',keterangan='$ket', gambar='$response[image]'";
						$response = $br->update($table, $value, "id_user", $_GET['id'], "?page=viewPegawai");
					}else{
						$response = ['response'=>'negative','alert'=>'gambar error'];
					}
				}
			// }
		}
	}
 ?>
 
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
					<div class="form-group">
                                    <label>Kode User</label>
                                    <input style="color: red; font-weight: bold;" class="au-input au-input--full" type="text" name="id_user" disabled value="<?= $autokode; ?>">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input class="au-input au-input--full" required type="text" name="nama_user" placeholder="Nama" value="<?= echo ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="au-input au-input--full" required type="text" name="username" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="au-input au-input--full" required type="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input class="au-input au-input--full" required type="password" name="confirm" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="foto_karyawan" class="control-label mb-1">Foto</label>
                                                    <input required type="file" name="foto" id="gambar" class="form-control-file">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="preview_foto_karyawan" class="control-label mb-1">Preview Foto</label>
                                                    <div style="padding-bottom: 5px;">
                                                    <img alt="" width="90" class="img-responsive" id="pict">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="level" class="control-label mb-1">Level</label>
                                            <select name="id_level" class="form-control mb-1">
                                                <option value=" ">Pilih level</option>
                                                <?php foreach ($dataLevel as $dl) { ?>
                                                    <option value="<?= $dl['id_level_user'] ?>"><?= $dl['nama_level_user'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button name="btnInput" class="btn btn-success" type="submit"><i class="fa fa-download"></i> Simpan</button>
                                <!-- <button name="btnRegister" class="au-btn btn-danger m-b-20" type="reset">Cancel</button> -->
            			<!-- <div class="card">
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
            			</div> -->
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>