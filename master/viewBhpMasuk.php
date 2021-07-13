<?php
$qb = new lsp();
$dataTrxMasuk = $qb->querySelect("SELECT * FROM tr_barang_bhp WHERE status = 'masuk'");
if ($_SESSION['level'] != "Master") {
    header("location:../index.php");
}
if (isset($_GET['delete'])) {
    $response = $qb->delete("table_barang", "kd_barang", $_GET['id'], "?page=viewBarang");
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="main-content" style="margin-top: -60px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="au-card-title" style="background-image:url('assets/images/bg-title-03.jpg');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-account-calendar"></i>Data BHP Masuk
                            </h3>
                        </div>
                        <div class="card-body">
                            <a href="?page=addStokBarangMasuk" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah BHP Masuk</a>
                            </button>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table id="example" class="table table-borderless table-striped table-earning">
                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Total Harga Masuk</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($dataTrxMasuk as $dm) {
                                        ?>
                                            <tr>
                                                <td><?= $dm['id_transaksi'] ?></td>
                                                <td><?= number_format($dm['harga_total']) ?></td>
                                                <td><?= $dm['tanggal_transaksi'] ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="?page=viewBhpDetail&id=<?php echo $dm['id_transaksi'] ?>&status=masuk" data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-primary"><i class="fa fa-search"></i></a>
                                                        <a href="?page=printBhpMasuk&id=<?= $dm['id_transaksi'] ?>&status=masuk" data-toggle="tooltip" data-placement="top" title="Cetak" class="btn btn-success"><i class="fa fa-print"></i></a>
                                                        <!-- <button data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger"><i class="fa fa-trash" id="btdelete<?php echo $no; ?>"></i></button> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- <script src="assets/vendor/jquery-3.2.1.min.js"></script>
                                            <script>
                                                $('#btdelete<?php echo $no; ?>').click(function(e) {
                                                    e.preventDefault();
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
                                                            window.location.href = "?page=viewBarang&delete&id=<?php echo $dm['kd_barang'] ?>";
                                                        }
                                                    });
                                                });
                                            </script> -->
                                        <?php $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>