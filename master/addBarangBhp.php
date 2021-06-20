<?php
$br = new lsp();
if ($_SESSION['level'] != "Master") {
    header("location:../index.php");
}
$table = "tm_barang_bhp";
$getKategoriBarangBhp      = $br->select("tm_kategori_bhp");

$autokodeBarangBhp      = $br->autokodeLimaDigit("tm_barang_bhp", "id_barang_bhp", "KB");
$waktu                  = date("Y-m-d");
if (isset($_POST['getSimpan'])) {
    $id_barang_bhp  = $br->validateHtml($_POST['id_barang_bhp']);
    $nama_barang_bhp  = $br->validateHtml($_POST['nama_barang_bhp']);
    $id_kategori_bhp = $br->validateHtml($_POST['id_kategori_bhp']);

    if ($id_barang_bhp == " " || $id_kategori_bhp == " " || $nama_barang_bhp == " ") {
        $response = ['response' => 'negative', 'alert' => 'lengkapi field'];
    } else {
        $value = "'$id_barang_bhp','$id_kategori_bhp','$nama_barang_bhp', '$waktu'";
        $response = $br->insert($table, $value, "?page=addBarangBhp");
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
                            <div class="au-card-title" style="background-image:url('assets/images/bg-title-01.jpg');">
                                <div class="bg-overlay bg-overlay--blue"></div>
                                <h3>
                                    <i class="zmdi zmdi-account-calendar"></i>Tambah Data Barang
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">ID barang</label>
                                            <input type="text" style="font-weight: bold; color: red;" class="form-control" name="id_barang_bhp" value="<?php echo $autokodeBarangBhp; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama barang</label>
                                            <input type="text" placeholder="Nama Barang" class="form-control" name="nama_barang_bhp" value="<?php echo @$_POST['nama_barang_bhp'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Jenis Barang</label>
                                            <select name="id_kategori_bhp" class="form-control">
                                                <option value=" ">Pilih Jenis Barang</option>
                                                <?php foreach ($getKategoriBarangBhp as $kbb) { ?>
                                                    <option value="<?= $kbb['id_kategori_bhp'] ?>"><?= $kbb['nama_kategori_bhp'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button name="getSimpan" class="btn btn-primary"><i class="fa fa-download"></i> Simpan</button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                                <a href="?page=viewMasterBarangBhp" class="btn btn-warning" style="float: right;"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>