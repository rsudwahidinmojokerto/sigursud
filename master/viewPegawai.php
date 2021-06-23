<?php

$rg = new lsp();
$table_user = "tm_user";
$table_level = "tm_level_user";

$autokode = $rg->autokodeLimaDigit($table_user, "id_user", "US");
$dataUser = $rg->select($table_user);
$dataLevel = $rg->select($table_level);

if (isset($_POST['btnInput'])) {
    $id_user = $_POST['id_user'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $foto = $_FILES['foto'];
    $level = $_POST['level'];
    $redirect = "?page=viewPegawai";


    if ($nama_user == "" || $username == "" || $password == "" || $confirm == "" || $level == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi Field !!!'];
    } else {
        $response = $rg->register($id_user, $nama_user, $username, $password, $confirm, $foto, $level, $redirect);
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
                                    <label>Kode User</label>
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
                                            <th>No</th>
                                            <th>Kode Pegawai</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($dataUser as $du) {
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $du['id_user']; ?></td>
                                                <td><?= $du['nama_user'] ?></td>
                                                <td><?= $du['username'] ?></td>
                                                <td><?= $du['level'] ?></td>
                                                <td><img width="60" src="assets/img/avatar/<?= $du['foto_user'] ?>" alt=""></td>
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
                                                            window.location.href = "?page=viewPegawai&delete&id=<?php echo $du['id_user'] ?>";
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