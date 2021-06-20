<?php
$br = new lsp();
if ($_SESSION['level'] != "Master") {
    header("location:../index.php");
}
$table = "tm_barang_bhp";
$getKategoriBarangBhp      = $br->select("tm_kategori_bhp");
// $getDistributor         = $br->select("tm_distributor");

$autokodeBarangBhp      = $br->autokodeLimaDigit("tm_barang_bhp", "id_barang_bhp", "KB");
$waktu                  = date("Y-m-d");
if (isset($_POST['getSimpan'])) {
    $id_barang_bhp  = $br->validateHtml($_POST['id_barang_bhp']);
    $nama_barang_bhp  = $br->validateHtml($_POST['nama_barang_bhp']);
    $id_kategori_bhp = $br->validateHtml($_POST['id_kategori_bhp']);
    // $distributor  = $br->validateHtml($_POST['distributor']);
    // $harga        = $br->validateHtml($_POST['harga']);
    // $stok         = $br->validateHtml($_POST['stok']);
    // $foto         = $_FILES['foto'];
    // $ket          = $_POST['ket'];

    // if ($kode_barang == " " || $nama_barang == " " || $jenis_barang == " " || $distributor == " " || $harga == " " || $stok == " " || $foto == " " || $ket == " ") {
    //     $response = ['response' => 'negative', 'alert' => 'lengkapi field'];
    // } else {
    //     if ($harga < 0 || $stok < 0 || $harga == 0 || $stok == 0) {
    //         $response = ['response' => 'negative', 'alert' => 'Harga atau stok tidak boleh 0 atau <'];
    //     } else {
    //         $response = $br->validateImage();
    //         if ($response['types'] == "true") {
    //             $value = "'$kode_barang','$nama_barang','$jenis_barang','$distributor','$waktu','$harga','$stok','$response[image]','$ket'";

    //             $response = $br->insert($table, $value, "?page=viewBarang");
    //         }
    //     }
    // }
    if ($id_barang_bhp == " " || $id_kategori_bhp == " " || $nama_barang_bhp == " ") {
        $response = ['response' => 'negative', 'alert' => 'lengkapi field'];
    } else {
        $value = "'$id_barang_bhp','$id_kategori_bhp','$nama_barang_bhp', '$waktu'";
        $response = $br->insert($table, $value, "?page=addBarang");
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
                                        <!-- <div class="form-group">
                                    <label for="">Kode Barang</label>
                                    <select name="jenis_barang" class="form-control">
                                        <option value=" ">Pilih Jenis Barang</option>
                                        <?php foreach ($getJenisbarang as $mr) { ?>
                                        <option value="<?= $mr['kd_jenisbarang'] ?>"><?= $mr['jenis_barang'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">nama Barang</label>
                                    <select name="jenis_barang" class="form-control">
                                        <option value=" ">Pilih Jenis Barang</option>
                                        <?php foreach ($getJenisbarang as $mr) { ?>
                                        <option value="<?= $mr['kd_jenisbarang'] ?>"><?= $mr['jenis_barang'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> -->
                                        <div class="form-group">
                                            <label for="">Jenis Barang</label>
                                            <select name="id_kategori_bhp" class="form-control">
                                                <option value=" ">Pilih Jenis Barang</option>
                                                <?php foreach ($getKategoriBarangBhp as $kbb) { ?>
                                                    <option value="<?= $kbb['id_kategori_bhp'] ?>"><?= $kbb['nama_kategori_bhp'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <!-- <div class="form-group">
                                    <label for="">Distributor</label>
                                    <select name="distributor" class="form-control">
                                        <option value=" ">Pilih distributor</option>
                                        <?php foreach ($getDistributor as $dr) { ?>
                                        <option value="<?= $dr['id_distributor'] ?>"><?= $dr['nama_distributor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> -->
                                        <!-- <div class="form-group">
                                    <label for="">harga lama</label>
                                    <select name="distributor" class="form-control">
                                        <option value=" ">Pilih distributor</option>
                                        <?php foreach ($getDistributor as $dr) { ?>
                                        <option value="<?= $dr['id_distributor'] ?>"><?= $dr['nama_distributor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">stock lama</label>
                                    <select name="distributor" class="form-control">
                                        <option value=" ">Pilih distributor</option>
                                        <?php foreach ($getDistributor as $dr) { ?>
                                        <option value="<?= $dr['id_distributor'] ?>"><?= $dr['nama_distributor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> -->
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Harga awal</label>
                                            <input type="number" class="form-control" name="harga">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Stok awal</label>
                                            <input type="number" class="form-control" name="stok">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Foto</label>
                                            <input type="file" class="form-control" name="foto">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan</label>
                                            <input type="text" class="form-control" name="ket">
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="card-footer">
                                <button name="getSimpan" class="btn btn-primary"><i class="fa fa-download"></i> Simpan</button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                                <a href="?page=viewMasterBarang" class="btn btn-warning" style="float: right;"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>