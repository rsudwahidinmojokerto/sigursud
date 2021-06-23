<?php

$rg = new lsp();
$table_user = "tm_user";
$table_level = "tm_level_user";
$table_ruangan = "tm_ruangan";

$autokode = $rg->autokodeLimaDigit($table_user, "id_user", "US");
$dataPegawai = $rg->selectPegawai();
$dataLevel = $rg->select($table_level);
$dataRuangan = $rg->select($table_ruangan);

if (isset($_POST['btnInput'])) {
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
    } else {
        $response = $rg->register($id_user, $id_ruangan, $id_level, $nama_user, $username, $password, $confirm, $foto, $redirect);
    }
}

if (isset($_GET['delete'])) {
    $response = $rg->delete($table_user, "id_user", $_GET['id'], "?page=viewPegawai");
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
                                    <input style="color: red; font-weight: bold;" class="au-input au-input--full" type="text" name="id_user" disabled value="<?= $autokode; ?>">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input class="au-input au-input--full" required type="text" name="nama_user" placeholder="Nama">
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
                                                    <option value="<?= $dl['id_level_user'] ?>"><?= $dl['nama_level_user'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="level" class="control-label mb-1">Ruangan</label>
                                            <select name="id_ruangan" class="form-control mb-1">
                                                <option value=" ">Pilih ruangan</option>
                                                <?php foreach ($dataRuangan as $dr) { ?>
                                                    <option value="<?= $dr['id_ruangan'] ?>"><?= $dr['nama_ruangan'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button name="btnInput" class="btn btn-success" type="submit"><i class="fa fa-download"></i> Simpan</button>
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
                                            <!-- <th>Level</th> -->
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
                                                <!-- <td><?= $dp['level'] ?></td> -->
                                                <td><img width="60" src="assets/img/avatar/<?= $dp['foto_user'] ?>" alt=""></td>
                                                <td>
                                                    <div class="table-data-feature">
                                                    <a href="?page=editUser&edit&id=<?= $dmb['id_user'] ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning"><i class="fa fa-edit"></i></a>
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