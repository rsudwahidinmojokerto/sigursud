<?php
$tr     = new lsp();
$transId = $tr->autokodeTanggal("tr_transaksi_stok_masuk", "id_transaksi_stok_masuk", "TR");
$antrian   = $tr->autokodeTanggal("tr_pretransaksi_stok_masuk", "id_pretransaksi_stok_masuk", "DM");
$dataBarang   = $tr->selectBhp("tm_barang_bhp", 'tm_kategori_bhp');
if (isset($_GET['getItem'])) {
    $id = $_GET['id'];
    $dataBarangBhp = $tr->selectWhere("tm_barang_bhp", "id_barang_bhp", $id);
    // $dataBarangBhp = $tr->
    $cekDataBhp = $tr->selectCountWhere('tr_barang_bhp_riwayat_harga_stok', 'id_barang_bhp', $id);
    var_dump($cekDataBhp);
}
$sum       = $tr->selectSum("table_pretransaksi", "sub_total");
$sql2      = "SELECT COUNT(kd_pretransaksi) as count FROM table_pretransaksi WHERE kd_transaksi = '$transId'";
$exec2     = mysqli_query($con, $sql2);
$assoc2    = mysqli_fetch_assoc($exec2);

if (isset($_POST['btnAdd'])) {
    if (!isset($_SESSION['transaksi'])) {
        $_SESSION['transaksi'] = true;
    }
    $kd_transaksi    = $_POST['kd_transaksi'];
    $kd_pretransaksi = $_POST['kd_pretransaksi'];
    $barang          = $_POST['kd_barang'];
    $jumlah          = $_POST['jumlah'];
    $total           = $_POST['total'];

    if ($kd_transaksi == "" || $kd_pretransaksi == "" || $barang == "" || $jumlah == "" || $total == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi field'];
    } else {
        if ($jumlah < 1) {
            $response = ['response' => 'negative', 'alert' => 'Pembelian minimal 1'];
        } else {
            $sisa = $tr->selectWhere("tm_barang_bhp", "kd_barang", $barang);
            if ($sisa['stok_barang'] < $jumlah) {
                $response = ['response' => 'negative', 'alert' => 'Stok tersisa ' . $sisa['stok_barang']];
            } else {
                $sql = "SELECT * FROM table_pretransaksi WHERE kd_transaksi = '$kd_transaksi' AND kd_barang = '$barang'";
                $exe = mysqli_query($con, $sql);
                $num = mysqli_num_rows($exe);
                $dta = mysqli_fetch_assoc($exe);
                if ($num > 0) {
                    $jumlah = $dta['jumlah'] + $jumlah;
                    $value = "jumlah='$jumlah'";
                    $insert = $tr->update("table_pretransaksi", $value, "kd_transaksi = '$kd_transaksi' AND kd_barang", $barang, "?page=kasirTransaksi");
                    header("location:PageKasir.php?page=kasirTransaksi");
                } else {
                    $value = "'$kd_pretransaksi','$kd_transaksi','$barang','$jumlah','$total'";
                    $insert = $tr->insert("table_pretransaksi", $value, "?page=kasirTransaksi");
                    header("location:PageKasir.php?page=kasirTransaksi");
                }
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id       = $_GET['id'];
    $where    = "kd_pretransaksi";
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
                                        <label for="">Kode Transaksi</label>
                                        <input style="font-weight: bold; color: red;" type="text" class="form-control" value="<?= $transId; ?>" readonly name="kd_transaksi">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Kode Detail</label>
                                        <input style="font-weight: bold; color: red;" type="text" class="form-control" value="<?= $antrian; ?>" readonly name="kd_pretransaksi" id="antrian">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="kd_barang" readonly placeholder="Kode barang" value="<?php echo @$dataBarangBhp['id_barang_bhp'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <a class="btn btn-primary btn-block" href="#fajarmodal" data-toggle="modal">Pilih Barang</a>
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
                                                    <input type="text" class="form-control currency" name="Hlama" id="Hlama" <?php if ($cekDataBhp['count'] < 1) { ?> value="1000" readonly <?php } else { ?> value="" readonly <?php } ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Harga Baru</label>
                                                    <input type="text" class="form-control currency" name="Hbaru" id="Hbaru">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Stok Lama</label>
                                                    <input type="text" id="lama" class="form-control stok" <?php if ($cekDataBhp['count'] < 1) { ?> value="10" readonly <?php } else { ?> value="" readonly <?php } ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Stok Baru</label>
                                                    <input type="text" id="baru" class="form-control stok">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Jumlah stok</label>
                                            <input type="text" id="jumlahstok" class="form-control stok" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Harga rata-rata</label>
                                            <input type="text" id="Hrata1" class="form-control currency" readonly="">
                                        </div>
                                        <button class="btn btn-primary" name="btnAdd"><i class="fa fa-cart-plus"></i> Tambahkan ke Antrian</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3>Detail Barang</h3>
                        </div>
                        <div class="card-body">
                            <?php if ($assoc2['count'] > 0 || isset($_POST['btnAdd'])) : ?>
                                <a class="btn btn-success" id="pembayaran" href="?page=kasirPembayaran">Lanjutkan ke pembayaran <i class="fa fa-cart-arrow-down"></i></a>
                            <?php endif ?>
                            <br><br>
                            <?php
                            $kr        = new lsp();
                            $transId = $kr->autokode("table_transaksi", "kd_transaksi", "TR");
                            $datas     = $kr->querySelect("SELECT * FROM transaksi WHERE kd_transaksi = '$transId'");
                            $sql       = "SELECT SUM(sub_total) as sub FROM table_pretransaksi WHERE kd_transaksi = '$transId'";
                            $exec      = mysqli_query($con, $sql);
                            $assoc     = mysqli_fetch_assoc($exec);

                            ?>
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>ID Detail</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <td>Batal beli</td>
                                </tr>
                                <?php
                                if (count($datas) > 0) {
                                    $no = 1;
                                    foreach ($datas as $dd) { ?>
                                        <tr>
                                            <td><?= $dd['kd_pretransaksi']; ?></td>
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
                                                        window.location.href = "?page=kasirTransaksi&delete&id=<?= $dd['kd_pretransaksi']; ?>";
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
                                    <td colspan="5" class="text-center">Tidak ada antrian</td>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fajarmodal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
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
                                <td>Kode Barang</td>
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
        // $('#nama_barang').change(function() {
        //     var barang = $(this).val();
        //     $.ajax({
        //         type: "POST",
        //         url: 'ajaxTransaksi.php',
        //         data: {
        //             'selectData': barang
        //         },
        //         success: function(data) {
        //             $("#hargaBaru").val(data);
        //             $("#jumjum").val();
        //             var jum = $("#jumjum").val();
        //             var kali = data * jum;
        //             $("#totals").val(kali);
        //         }
        //     })
        // });

        // $('#stokLama').keyup(function() {
        //     var jumlah = $(this).val();
        //     // var harba = $('#hargaBaru').val();
        //     var kali = jumlah + 100;
        //     $("#jumlahStok").val(kali);
        // });


        // $('#lama, #baru').keyup(function() {
        //     var sl = $('#lama').val();
        //     var sb = $('#baru').val();
        //     var jml = parseInt(sl) + parseInt(sb);
        //     $('#jumlahStok').val(jml);
        // });

        // $('#jumjum').keyup(function() {
        //     var jumlah = $(this).val();
        //     var harba = $('#hargaBaru').val();
        //     var kali = harba * jumlah;
        //     $("#totals").val(kali);
        // });

        $("#baru").keyup(function() {
            var lama = $("#lama").val();
            var baru = $("#baru").val();

            var jumlahstok = parseInt(lama) + parseInt(baru);
            $("#jumlahstok").val(jumlahstok);
        });

        // $("#Hlama, #Hbaru").keyup(function() {
        //     var Hlama = $("#Hlama").val();
        //     var Hbaru = $("#Hbaru").val();
        //     var lama = $("#lama").val();
        //     var baru = $("#baru").val();

        //     // var Hrata1 = ((parseInt(Hlama) * parseInt(lama)) + (parseInt(Hbaru) * parseInt(baru))) / (lama + baru);
        //     var Hrata1 = (Hlama * lama) + (Hbaru * baru);
        //     $("#Hrata1").val(Hrata1);
        //     // var Hrata1 = Hrata/2;
        //     // $("#Hrata1").val(Hrata1);
        // });

        $("#Hbaru").keyup(function() {
            var Hlama = $("#Hlama").val();
            var Hbaru = $("#Hbaru").val();
            var lama = $("#lama").val();
            var baru = $("#baru").val();

            var Hrata1 = (((Hlama * lama) + (Hbaru * baru)) / (lama + baru));
            $("#Hrata1").val(Hrata1);
        });

        // $('#bayar').keyup(function() {
        //     var bayar = $(this).val();
        //     var total = $('#tot').val();
        //     var kembalian = bayar - total;
        //     $('#kem').val(kembalian);
        // });

        // $(document).ready(function() {
        //     $('#barang_nama').change(function() {
        //         var barang = $(this).val();
        //         $.ajax({
        //             type: "POST",
        //             url: 'ajaxTransaksi.php',
        //             data: {
        //                 'selectData': barang
        //             },
        //             success: function(data) {
        //                 $("#harba").val(data);
        //                 $("#jumjum").val();
        //                 var jum = $("#jumjum").val();
        //                 var kali = data * jum;
        //                 $("#totals").val(kali);
        //             }
        //         })
        //     });


        //     $('#jumjum').keyup(function() {
        //         var jumlah = $(this).val();
        //         var harba = $('#harba').val();
        //         var kali = harba * jumlah;
        //         $("#totals").val(kali);
        //     });


        //     $('#bayar').keyup(function() {
        //         var bayar = $(this).val();
        //         var total = $('#tot').val();
        //         var kembalian = bayar - total;
        //         $('#kem').val(kembalian);
        //     })

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