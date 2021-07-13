<?php

$rg = new lsp();
$table_user = "tm_user";
$table_level = "tm_level_user";
$table_ruangan = "tm_ruangan";
$table_riwayat = "riwayat";

$autokode = $rg->autokodeLimaDigit($table_user, "id_user", "US");
$dataPegawai = $rg->selectPegawai();
$dataLevel = $rg->select($table_level);
$dataRuangan = $rg->select($table_ruangan);

$autokodeTanggal = $rg->autokodeTanggal($table_riwayat, 'id_riwayat', 'TMP');

if (isset($_POST['getSave'])) {
    $id_user = $_POST['id_user'];
    $id_ruangan = $_POST['id_ruangan'];
    $id_level = $_POST['id_level'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $foto = $_FILES['foto'];
    $redirect = "?page=viewPegawai";

    if ($id_level == "" || $id_ruangan == "" || $nama_user == "" || $username == "" || $password == "" || $confirm == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi Field !!!'];
    } else if ($password != $confirm) {
        $response = ['response' => 'negative', 'alert' => 'Password dan konfirmasi password tidak sama !!!'];
    } else {
        //Table riwayat
        $value1    = "'$autokodeTanggal', '" . $_SESSION['id_user'] . "', '$id_user', 'Tambah User " . "$nama_user', '" . date("Y-m-d H:i:s") . "'";
        $rg->insertRiwayat($table_riwayat, $value1);

        $response = $rg->register($id_user, $id_ruangan, $id_level, $nama_user, $username, $password, $confirm, $foto, $redirect);
    }
}

if (isset($_POST['getUpdate'])) {
    // $id_ruangan   = $dis->validateHtml($_POST['kode_ruangan']);

    $id_user = $_POST['id_user'];
    $id_ruangan = $_POST['id_ruangan'];
    $id_level = $_POST['id_level'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = base64_encode($_POST['password']);
    $confirm = base64_encode($_POST['confirm']);
    $foto = $_FILES['foto'];
    $redirect = "?page=viewPegawai";

    if ($id_level == "" || $id_ruangan == "" || $nama_user == "" || $username == "" || $password == "" || $confirm == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi Field !!!'];
    } else if ($password != $confirm) {
        $response = ['response' => 'negative', 'alert' => 'Password tidak cocok !!!'];
    } else {
        //Table riwayat
        $value1    = "'$autokodeTanggal', '" . $_SESSION['id_user'] . "', '$id_user', 'Ubah User " . "$nama_user', '" . date("Y-m-d H:i:s") . "'";
        $rg->insertRiwayat($table_riwayat, $value1);

        $hasil_foto = $rg->validateImage();
        $value = "id_user='$id_user', id_ruangan='$id_ruangan', id_level_user='$id_level', nama_user='$nama_user', username='$username', password='$password', foto_user='$hasil_foto[image]'";
        $response = $rg->update($table_user, $value, "id_user", $_GET['id'], "?page=viewPegawai");
    }
}

if (isset($_GET['edit'])) {
    $id_user = $_GET['id'];
    $editData = $rg->selectWhere($table_user, "id_user", $id_user);
    $autokode = $editData['id_user'];
}

if (isset($_GET['delete'])) {
    $id_user = $_GET['id'];
    $nama_user = $rg->selectWhere($table_user, "id_user", $id_user)['nama_user'];

    $response = $rg->delete($table_user, "id_user", $_GET['id'], "?page=viewPegawai");

    //Table riwayat
    $value1    = "'$autokodeTanggal', '" . $_SESSION['id_user'] . "', '$id_user', 'Delete User " . "$nama_user', '" . date("Y-m-d H:i:s") . "'";
    $rg->insertRiwayat($table_riwayat, $value1);
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
                                <li class="list-inline-item">Kelola Pegawai</li>
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
                        <div class="card-header">
                            <strong class="card-title mb-3">Input Pegawai</strong>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>ID User</label>
                                    <input style="color: red; font-weight: bold;" class="au-input au-input--full" type="text" name="id_user" readonly value="<?= @$autokode; ?>">
                                    <!-- <?php echo @$_SESSION['level']; ?> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input class="au-input au-input--full" required type="text" name="nama_user" placeholder="Nama" value="<?= @$editData['nama_user']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="au-input au-input--full" required type="text" name="username" placeholder="Username" value="<?= @$editData['username']; ?>">
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
                                                        <img alt="" width="110" class="img-responsive" id="pict">
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
                                                    <option value="<?= $dl['id_level_user'] ?>" <?php if (@$editData['id_level_user'] == $dl['id_level_user']) { ?> selected <?php }; ?>><?= $dl['nama_level_user'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="level" class="control-label mb-1">Ruangan</label>
                                            <select name="id_ruangan" class="form-control mb-1">
                                                <option value=" ">Pilih ruangan</option>
                                                <?php foreach ($dataRuangan as $dr) { ?>
                                                    <option value="<?= $dr['id_ruangan'] ?>" <?php if (@$editData['id_ruangan'] == $dr['id_ruangan']) { ?> selected <?php }; ?>><?= $dr['nama_ruangan'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php if (isset($_GET['edit'])) : ?>
                                    <button type="submit" name="getUpdate" class="btn btn-warning"><i class="fa fa-check"></i> Update</button>
                                    <a href="?page=viewPegawai" class="btn btn-danger">Cancel</a>
                                <?php endif ?>
                                <?php if (!isset($_GET['edit'])) : ?>
                                    <button type="submit" name="getSave" class="btn btn-primary"><i class="fa fa-download"></i> Simpan</button>
                                <?php endif ?>
                                <!-- <button name="btnRegister" class="au-btn btn-danger m-b-20" type="reset">Cancel</button> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title mb-3">Data Pegawai</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-borderless table-striped table-earning">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>ID Pegawai</th>
                                            <th>Ruangan</th>
                                            <th>Level</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($dataPegawai as $dp) {
                                        ?>
                                            <tr>
                                                <!-- <td><?= $no; ?></td> -->
                                                <td><?= $dp['id_user']; ?></td>
                                                <td><?= $dp['nama_ruangan']; ?></td>
                                                <td><?= $dp['level']; ?></td>
                                                <td><?= $dp['nama_user'] ?></td>
                                                <td><?= $dp['username'] ?></td>
                                                <td><img width="60" src="assets/img/<?= $dp['foto_user'] ?>" alt=""></td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="?page=viewPegawai&edit&id=<?= $dp['id_user'] ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                        <button data-toggle="tooltip" id="btnDelete<?php echo $no; ?>" data-placement="top" title="Delete" class="btn btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <!-- <button id="btnDelete<?php echo $no; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <script src="assets/vendor/jquery-3.2.1.min.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#id_ruangan').select2();
                                                });

                                                $('#btnDelete<?php echo $no; ?>').click(function(e) {
                                                    e.preventDefault();
                                                    swal({
                                                        title: "Hapus",
                                                        text: "Yakin Ingin menghapus?",
                                                        type: "error",
                                                        showCancelButton: true,
                                                        confirmButtonText: "Yes",
                                                        cancelButtonText: "Cancel",
                                                        closeOnConfirm: false,
                                                        closeOnCancel: true
                                                    }, function(isConfirm) {
                                                        if (isConfirm) {
                                                            window.location.href = "?page=viewPegawai&delete&id=<?php echo $dp['id_user'] ?>";
                                                        }
                                                    });
                                                });
                                            </script>
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