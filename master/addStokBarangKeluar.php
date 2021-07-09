<?php
$tr     = new lsp();
$transId = $tr->autokodeTanggal("tr_transaksi_stok_masuk", "id_transaksi_stok_masuk", "TR");
$daftar_masuk   = $tr->autokodeTanggal("tr_pretransaksi_stok_masuk", "id_pretransaksi_stok_masuk", "DM");
$dataBarang   = $tr->selectBhp("tm_barang_bhp", 'tm_kategori_bhp');
if (isset($_GET['getItem'])) {
    $id = $_GET['id'];
    $dataBarangBhp = $tr->selectWhere("tm_barang_bhp", "id_barang_bhp", $id);
    $cekDataBhp = $tr->selectCountWhere('tr_barang_bhp_riwayat_harga_stok', 'id_barang_bhp', $id);
}
// $sum       = $tr->selectSum("table_pretransaksi", "sub_total");
// $sql2      = "SELECT COUNT(id_daftar_masuk) as count FROM table_pretransaksi WHERE id_transaksi = '$transId'";
// $exec2     = mysqli_query($con, $sql2);
// $assoc2    = mysqli_fetch_assoc($exec2);

if (isset($_POST['btnAdd'])) {
    // if (!isset($_SESSION['transaksi'])) {
    //     $_SESSION['transaksi'] = true;
    // }
    $id_transaksi    = $_POST['id_transaksi'];
    $id_daftar_masuk = $_POST['id_daftar_masuk'];
    $id_barang_bhp   = $_POST['id_barang_bhp'];
    $harga_lama      = $_POST['harga_lama'];
    $harga_baru      = $_POST['harga_baru'];
    $stok_lama       = $_POST['stok_lama'];
    $stok_baru       = $_POST['stok_baru'];
    // $jumlah          = $_POST['jumlah'];
    // $total           = $_POST['total'];

    if ($id_transaksi == "" || $id_daftar_masuk == "" || $id_barang_bhp == "" || $harga_lama == "" || $harga_baru == "" || $stok_lama == "" || $stok_baru == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi field'];
    } else {
        if ($harga_baru < 1) {
            $response = ['response' => 'negative', 'alert' => 'Masukkan harga baru yang valid'];
        } else if ($stok_baru < 1) {
            $response = ['response' => 'negative', 'alert' => 'Stok masuk minimal 1 pcs'];
        } else {

            // $sisa = $tr->selectWhere("tm_barang_bhp", "id_barang_bhp", $id_barang_bhp);
            // if ($sisa['stok_barang'] < $jumlah) {
            //     $response = ['response' => 'negative', 'alert' => 'Stok tersisa ' . $sisa['stok_barang']];
            // } else {
            //     $sql = "SELECT * FROM table_pretransaksi WHERE id_transaksi = '$id_transaksi' AND id_barang_bhp = '$id_barang_bhp'";
            //     $exe = mysqli_query($con, $sql);
            //     $num = mysqli_num_rows($exe);
            //     $dta = mysqli_fetch_assoc($exe);
            //     if ($num > 0) {
            //         $jumlah = $dta['jumlah'] + $jumlah;
            //         $value = "jumlah='$jumlah'";
            //         $insert = $tr->update("table_pretransaksi", $value, "id_transaksi = '$id_transaksi' AND id_barang_bhp", $id_barang_bhp, "?page=kasirTransaksi");
            //         header("location:PageKasir.php?page=kasirTransaksi");
            //     } else {
            //         $value = "'$id_daftar_masuk','$id_transaksi','$id_barang_bhp','$jumlah','$total'";
            //         $insert = $tr->insert("table_pretransaksi", $value, "?page=kasirTransaksi");
            //         header("location:PageKasir.php?page=kasirTransaksi");
            //     }
            // }
        }
    }
}

if (isset($_GET['delete'])) {
    $id       = $_GET['id'];
    $where    = "id_daftar_masuk";
    $response = $tr->delete("table_pretransaksi", $where, $id, "?page=kasirTransaksi");
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
                                <li class="list-inline-item">Stok Barang</li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Tambah Stok Barang</li>
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
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3>Pilih Barang</h3>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">ID Transaksi</label>
                                        <input style="font-weight: bold; color: red;" type="text" class="form-control" name="id_transaksi" value="<?= $transId; ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ID Daftar</label>
                                        <input style="font-weight: bold; color: red;" type="text" class="form-control" name="id_daftar_masuk" id="daftar_masuk" value="<?= $daftar_masuk; ?>" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="id_barang_bhp" readonly placeholder="ID barang" value="<?php echo @$dataBarangBhp['id_barang_bhp'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <a class="btn btn-primary btn-block" href="#modal_barang_bhp" data-toggle="modal">Pilih Barang</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang" value="<?php echo @$dataBarangBhp['nama_barang_bhp']; ?>" readonly>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
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
                                        </div>
                                        <button class="btn btn-primary" name="btnAdd"><i class="fa fa-plus-square"></i> Tambah ke daftar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3>Daftar Barang Masuk</h3>
                        </div>
                        <div class="card-body">
                            <!-- <?php if ($assoc2['count'] > 0 || isset($_POST['btnAdd'])) : ?>
                                <a class="btn btn-success" id="pembayaran" href="?page=kasirPembayaran">Lanjutkan ke pembayaran <i class="fa fa-cart-arrow-down"></i></a>
                            <?php endif ?>
                            <br><br>
                            <?php
                            $kr        = new lsp();
                            $transId = $kr->autokode("table_transaksi", "id_transaksi", "TR");
                            $datas     = $kr->querySelect("SELECT * FROM transaksi WHERE id_transaksi = '$transId'");
                            $sql       = "SELECT SUM(sub_total) as sub FROM table_pretransaksi WHERE id_transaksi = '$transId'";
                            $exec      = mysqli_query($con, $sql);
                            $assoc     = mysqli_fetch_assoc($exec);

                            ?> -->
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>ID Daftar</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Stok</th>
                                    <th>Sub Total</th>
                                    <td>Aksi</td>
                                </tr>
                                <?php
                                if (count($datas) > 0) {
                                    $no = 1;
                                    foreach ($datas as $dd) { ?>
                                        <tr>
                                            <td><?= $dd['id_daftar_masuk']; ?></td>
                                            <td><?= $dd['nama_barang']; ?></td>
                                            <td><?= $dd['jumlah']; ?></td>
                                            <td><?= $dd['sub_total']; ?></td>
                                            <td class="text-center">
                                                <a href="#" id="btdelete<?php echo $no; ?>" class="btn btn-danger">Batal</a>
                                            </td>
                                        </tr>
                                        <script src="vendor/jquery-3.2.1.min.js"></script>
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
                                                        window.location.href = "?page=kasirTransaksi&delete&id=<?= $dd['id_daftar_masuk']; ?>";
                                                    }
                                                })
                                            })
                                        </script>
                                    <?php $no++;
                                    } ?>
                                    <?php if (!$assoc['sub'] == "") : ?>
                                        <tr>
                                            <td colspan="4">Total Harga</td>
                                            <td><?php echo $assoc['sub'] ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php } else { ?>
                                    <td colspan="5" class="text-center">Tidak ada daftar</td>
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

        // $('#nama_barang').change(function() {
        //     var barang = $(this).val();
        //     $.ajax({
        //         type: "POST",
        //         url: 'ajaxTransaksi.php',
        //         data: {
        //             'selectData': barang
        //         },
        //         success: function(data) {
        //             $("#harga_baru").val(data);
        //             $("#jumjum").val();
        //             var jum = $("#jumjum").val();
        //             var kali = data * jum;
        //             $("#totals").val(kali);
        //         }
        //     })
        // });

        // $(".currency").autoNumeric('init', {
        //     aSign: 'Rp. ',
        //     aSep: '.',
        //     aDec: ',',
        //     aForm: true,
        //     vMax: '999999999',
        //     vMin: '0'
        // });

        // $(".stok").autoNumeric('init', {
        //     aSep: '.',
        //     aDec: ',',
        //     aForm: true,
        //     vMax: '999999999',
        //     vMin: '0'
        // });
    })
</script>