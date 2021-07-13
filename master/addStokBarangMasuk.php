<?php
$tr             = new lsp();
$transId        = $tr->autokodeTanggal("riwayat", "id_objek", "TR");
$daftar_masuk   = $tr->autokodeTanggal("riwayat", "id_objek", "DM");
$dataBarang     = $tr->selectBhp("tm_barang_bhp", 'tm_kategori_bhp');
$autokodeTanggalRiwayat = $tr->autokodeTanggal('riwayat', 'id_riwayat', 'TMP');
$tanggal        = date("Y-m-d H:i:s");
$sub = 0;

if (isset($_GET['getItem'])) {
    $id = $_GET['id'];
    $dataBarangBhp = $tr->selectWhere("tm_barang_bhp", "id_barang_bhp", $id);
    $dataDistributor = $tr->select("tm_distributor");
    $cekDataBhp = $tr->selectCountWhere('tr_barang_bhp_riwayat_harga_stok', 'id_barang_bhp', $id);
}

if (isset($_POST['btnAdd'])) {
    // if (!isset($_SESSION['transaksi'])) {
    //     $_SESSION['transaksi'] = true;
    // }
    $id_transaksi    = $_POST['id_transaksi'];
    $id_bhp_masuk    = $_POST['id_daftar_masuk'];
    $id_barang_bhp   = $_POST['id_barang_bhp'];
    $id_distributor  = $_POST['id_distributor'];
    $harga_lama      = $_POST['harga_lama'];
    $harga_baru      = $_POST['harga_baru'];
    $stok_lama       = $_POST['stok_lama'];
    $stok_baru       = $_POST['stok_baru'];

    if ($id_transaksi == "" || $id_bhp_masuk == "" || $id_barang_bhp == "" || $id_distributor == "" || $harga_lama == "" || $harga_baru == "" || $stok_lama == "" || $stok_baru == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi field'];
    } else {
        if ($harga_baru < 1) {
            $response = ['response' => 'negative', 'alert' => 'Masukkan harga baru yang valid'];
        } else if ($stok_baru < 1) {
            $response = ['response' => 'negative', 'alert' => 'Stok masuk minimal 1 pcs'];
        } else {
            $value = "'$id_bhp_masuk', '$id_transaksi', '$id_barang_bhp', '$id_distributor', '$harga_baru', '$stok_baru', '$tanggal'";
            $insert = $tr->insert("tr_barang_bhp_masuk_detail", $value, "?page=addStokBarangMasuk");

            $valueRiwayat    = "'$autokodeTanggalRiwayat', '" . $_SESSION['id_user'] . "', '$id_bhp_masuk', 'Tambah daftar BHP $id_barang_bhp, harga $harga_baru, stok $stok_baru', '" . date("Y-m-d H:i:s") . "'";
            $insertTemp = $tr->insertRiwayat('riwayat', $valueRiwayat);

            $response = ['response' => 'positive', 'alert' => 'Data berhasil di daftarkan', 'redirect' => '?page=addStokBarangMasuk'];
            // $sisa = $tr->selectWhere("tm_barang_bhp", "id_barang_bhp", $id_barang_bhp);
            // if ($sisa['stok_barang'] < $jumlah) {
            //     $response = ['response' => 'negative', 'alert' => 'Stok tersisa ' . $sisa['stok_barang']];
            // } else {
            // $sql = "SELECT * FROM table_pretransaksi WHERE id_transaksi = '$id_transaksi' AND id_barang_bhp = '$id_barang_bhp'";
            // $exe = mysqli_query($con, $sql);
            // $num = mysqli_num_rows($exe);
            // $dta = mysqli_fetch_assoc($exe);
            // if ($num > 0) {
            //     $jumlah = $dta['jumlah'] + $jumlah;
            //     $value = "jumlah='$jumlah'";
            //     $insert = $tr->update("table_pretransaksi", $value, "id_transaksi = '$id_transaksi' AND id_barang_bhp", $id_barang_bhp, "?page=kasirTransaksi");
            //     header("location:PageKasir.php?page=kasirTransaksi");
            // } else {
            //     $value = "'$id_daftar_masuk','$id_transaksi','$id_barang_bhp','$jumlah','$total'";
            //     $insert = $tr->insert("table_pretransaksi", $value, "?page=kasirTransaksi");
            //     header("location:PageKasir.php?page=kasirTransaksi");
            // }
            // }
        }
    }
}

if (isset($_GET['delete'])) {
    $id_bhp_masuk   = $_GET['id'];
    $id_barang_bhp  = $_GET['kb'];
    $where          = "id_bhp_masuk";
    $response       = $tr->delete("tr_barang_bhp_masuk_detail", $where, $id_bhp_masuk, "?page=addStokBarangMasuk");

    $valueRiwayat    = "'$autokodeTanggalRiwayat', '" . $_SESSION['id_user'] . "', '$id_bhp_masuk', 'Hapus daftar BHP $id_barang_bhp', '$tanggal'";
    $insertTemp = $tr->insertRiwayat('riwayat', $valueRiwayat);
}

if (isset($_GET['masuk'])) {
    $id_transaksi = $_GET['idtrx'];
    $harga_total = $tr->querySelect("SELECT SUM(harga*jumlah) as total_harga FROM tr_barang_bhp_masuk_detail WHERE id_transaksi = '$id_transaksi'");
    $value = "'$id_transaksi', $harga_total, 'masuk', $tanggal";
    $response = $tr->insert('tr_barang_bhp', $value, '?page=viewBhpMasuk');
}

?>
<section class="au-breadcrumb m-t-75">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="au-breadcrumb-content">
                        <div class="au-breadcrumb-left">
                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                <li class="list-inline-item active">
                                    <a href="#">Home</a>
                                </li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Data BHP Masuk</li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Tambah BHP Masuk</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="main-content" style="margin-top: -70px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    <h3>Data Barang</h3>
                                </div>
                                <div class="col-sm-3">
                                    <a class="btn btn-primary btn-block" href="#modal_barang_bhp" data-toggle="modal"><i class="fa fa-list-ul"></i> Pilih Barang</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">ID Transaksi</label>
                                            <input style="font-weight: bold; color: red;" type="text" class="form-control" name="id_transaksi" value="<?= $transId; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">ID Daftar</label>
                                            <input style="font-weight: bold; color: red;" type="text" class="form-control" name="id_daftar_masuk" id="daftar_masuk" value="<?= $daftar_masuk; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="">ID Barang</label>
                                            <input type="text" class="form-control" name="id_barang_bhp" style="font-weight: bold;" value="<?php echo @$dataBarangBhp['id_barang_bhp'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang" style="font-weight: bold;" value="<?php echo @$dataBarangBhp['nama_barang_bhp']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Harga Lama</label>
                                            <input type="text" class="form-control currency" name="harga_lama" id="harga_lama" <?php if (isset($_GET['getItem'])) {
                                                                                                                                    if (@$cekDataBhp['count'] < 1) { ?> value="0" readonly <?php } else { ?> value="" readonly <?php }
                                                                                                                                                                                                                        } else { ?> value="" readonly <?php } ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Harga Baru</label>
                                            <input type="text" class="form-control currency" name="harga_baru" id="harga_baru" <?php if (!isset($_GET['getItem'])) { ?> readonly <?php } ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><b>Harga rata-rata</b></label>
                                            <input type="text" name="harga_rata" id="harga_rata" class="form-control currency" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Stok lama (pcs)</label>
                                            <input type="text" name="stok_lama" id="stok_lama" class="form-control stok" <?php if (isset($_GET['getItem'])) {
                                                                                                                                if (@$cekDataBhp['count'] < 1) { ?> value="0" readonly <?php } else { ?> value="" readonly <?php }
                                                                                                                                                                                                                    } else { ?> value="" readonly <?php } ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Stok baru (pcs)</label>
                                            <input type="text" name="stok_baru" id="stok_baru" class="form-control stok" <?php if (!isset($_GET['getItem'])) { ?> readonly <?php } ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><b>Stok total (pcs)</b></label>
                                            <input type="text" name="jumlah_stok" id="jumlah_stok" class="form-control stok" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="control-label mb-1">Distributor</label>
                                            <select name="id_distributor" class="form-control mb-1" <?php if (!isset($_GET['getItem'])) { ?> disabled <?php } ?>>
                                                <option value=""><?php if (isset($_GET['getItem'])) { ?> Pilih distributor <?php } ?></option>
                                                <?php foreach ($dataDistributor as $dd) { ?>
                                                    <option value="<?= $dd['id_distributor'] ?>"><?= $dd['nama_distributor'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <?php if (isset($_GET['getItem'])) { ?> <button class="btn btn-primary btn-block" name="btnAdd"><i class="fa fa-check"></i> Tambah ke daftar</button> <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $datas     = $tr->querySelect("SELECT * FROM tr_barang_bhp_masuk_detail LEFT JOIN tm_barang_bhp ON tr_barang_bhp_masuk_detail.id_barang_bhp = tm_barang_bhp.id_barang_bhp LEFT JOIN tm_distributor ON tr_barang_bhp_masuk_detail.id_distributor = tm_distributor.id_distributor WHERE id_transaksi = '$transId'");
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    <h3>Daftar Barang Masuk</h3>
                                </div>
                                <div class="col-sm-3">
                                    <?php if (count($datas) > 0) : ?>
                                        <a href="#" class="btn btn-success btn-block" id="transaksi_masuk_selesai"><i class="fa fa-check"></i> Selesaikan Transaksi</a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- <?php if (isset($_POST['btnAdd'])) : ?>
                                <a class="btn btn-success" id="pembayaran" href="?page=addStokBarangMasuk">Lanjutkan ke pembayaran <i class="fa fa-cart-arrow-down"></i></a>
                            <?php endif ?> -->
                            <!-- <br><br> -->
                            <?php
                            // $kr        = new lsp();
                            // $transId   = $kr->autokode("table_transaksi", "id_transaksi", "TR");
                            // $datas     = $tr->querySelect("SELECT * FROM tr_barang_bhp_masuk_detail LEFT JOIN tm_barang_bhp ON tr_barang_bhp_masuk_detail.id_barang_bhp = tm_barang_bhp.id_barang_bhp LEFT JOIN tm_distributor ON tr_barang_bhp_masuk_detail.id_distributor = tm_distributor.id_distributor WHERE id_transaksi = '$transId'");
                            // $sql       = "SELECT SUM(sub_total) as sub FROM tr_barang_bhp_masuk_detail WHERE id_transaksi = '$transId'";
                            // $exec      = mysqli_query($con, $sql);
                            // $assoc     = mysqli_fetch_assoc($exec);

                            ?>
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>ID Daftar</th>
                                    <th>Nama Barang</th>
                                    <th>Distributor</th>
                                    <th>Jumlah Stok</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                    <td>Aksi</td>
                                </tr>
                                <?php
                                if (count($datas) > 0) {
                                    $no = 1;
                                    foreach ($datas as $dd) { ?>
                                        <tr>
                                            <td><?= $dd['id_bhp_masuk']; ?></td>
                                            <td><?= $dd['nama_barang_bhp']; ?></td>
                                            <td><?= $dd['nama_distributor']; ?></td>
                                            <td><?= number_format($dd['jumlah']); ?></td>
                                            <td><?= number_format($dd['harga']); ?></td>
                                            <td><?= number_format($dd['harga'] * $dd['jumlah']); ?></td>
                                            <td class="text-center">
                                                <a href="#" id="btdelete<?php echo $no; ?>" class="btn btn-danger">Batal</a>
                                            </td>
                                        </tr>
                                        <script src="assets/vendor/jquery-3.2.1.min.js"></script>
                                        <script>
                                            $("#btdelete<?php echo $no; ?>").click(function() {
                                                swal({
                                                    title: "Hapus",
                                                    text: "Yakin Hapus?",
                                                    type: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonText: "Yes",
                                                    cancelButtonText: "Cancel",
                                                    closeOnConfirm: false,
                                                    closeOnCancel: true
                                                }, function(isConfirm) {
                                                    if (isConfirm) {
                                                        window.location.href = "?page=addStokBarangMasuk&delete&id=<?= $dd['id_bhp_masuk']; ?>&kb=<?= $dd['id_barang_bhp']; ?>";
                                                    }
                                                })
                                            })
                                        </script>
                                    <?php $no++;
                                        $sub += $dd['harga'] * $dd['jumlah'];
                                    } ?>
                                    <!-- if (!$assoc['sub'] == "") : -->
                                    <?php if (count($datas) > 0) : ?>
                                        <tr>
                                            <td colspan="5">Total Harga</td>
                                            <!-- echo $assoc['sub'] -->
                                            <td><?= number_format($sub); ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php } else { ?>
                                    <td colspan="7" class="text-center">Tidak ada daftar</td>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_barang_bhp" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Pilih Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width: 100%" id="example">
                        <thead>
                            <tr>
                                <td>ID Barang</td>
                                <td>Kategori Barang</td>
                                <td>Nama Barang</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataBarang as $db) { ?>
                                <tr>
                                    <td><a href="pageMaster.php?page=addStokBarangMasuk&getItem&id=<?php echo $db['id_barang_bhp'] ?>"><?php echo $db['id_barang_bhp'] ?></a></td>
                                    <td><?php echo $db['nama_kategori_bhp'] ?></td>
                                    <td><?php echo $db['nama_barang_bhp'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/vendor/jquery-3.2.1.min.js"></script>
<script>
    $.noConflict();
    $(document).ready(function() {
        $("#harga_baru, #stok_baru").keyup(function() {
            var harga_lama = $("#harga_lama").val();
            var harga_baru = $("#harga_baru").val();
            var stok_lama = $("#stok_lama").val();
            var stok_baru = $("#stok_baru").val();

            var harga_rata = ((parseInt(harga_lama) * parseInt(stok_lama)) + (parseInt(harga_baru) * parseInt(stok_baru))) / (parseInt(stok_lama) + parseInt(stok_baru));
            $("#harga_rata").val(parseInt(harga_rata));

            var jumlah_stok = parseInt(stok_lama) + parseInt(stok_baru);
            $("#jumlah_stok").val(jumlah_stok);
        });

        $("#transaksi_masuk_selesai").click(function(e) {
            e.preventDefault();
            swal({
                title: "Transaksi akan disimpan",
                text: "Lanjutkan untuk mencetak?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Tidak, hanya simpan",
                // cancelButtonColor: '#d33',
                confirmButtonText: "Ya",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = "?page=printBhpMasuk";
                } else {
                    // window.location.href = "?page=viewBhpMasuk&masuk&idtrx=<?= $transId; ?>";
                    swal({
                        title: "Transaksi berhasil",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonText: "Lanjut",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                    }, function(isConfirm) {
                        if (isConfirm) {
                            var a = '<?php
                                        // if (isset($_GET['masuk'])) {
                                        // $total_harga = $tr->querySelect("SELECT SUM(harga*jumlah) as total_harga FROM tr_barang_bhp_masuk_detail WHERE id_transaksi = '$transId'");
                                        // $nilai_harga = $total_harga[0]['total_harga'];
                                        // $value = "'$transId', $nilai_harga, 'masuk', '$tanggal'";
                                        // $response = $tr->insert('tr_barang_bhp', $value, '?page=viewBhpMasuk');

                                        // $valueRiwayat    = "'$autokodeTanggalRiwayat', '" . $_SESSION['id_user'] . "', '$transId', 'Tambah transaksi masuk $transId', '$tanggal'";
                                        // $insertTemp = $tr->insertRiwayat('riwayat', $valueRiwayat);
                                        // }
                                        ?>';
                        }
                    })
                }
            })
        })

        // $('#nama_barang').change(function() {
        // var barang = $(this).val();
        // $.ajax({
        // type: "POST",
        // url: 'ajaxTransaksi.php',
        // data: {
        // 'selectData': barang
        // },
        // success: function(data) {
        // $("#harga_baru").val(data);
        // $("#jumjum").val();
        // var jum = $("#jumjum").val();
        // var kali = data * jum;
        // $("#totals").val(kali);
        // }
        // })
        // });

        // $(".currency").autoNumeric('init', {
        // aSign: 'Rp. ',
        // aSep: '.',
        // aDec: ',',
        // aForm: true,
        // vMax: '999999999',
        // vMin: '0'
        // });

        // $(".stok").autoNumeric('init', {
        // aSep: '.',
        // aDec: ',',
        // aForm: true,
        // vMax: '999999999',
        // vMin: '0'
        // });
    })
</script>