<?php 
    $dis = new lsp();
    if ($_SESSION['level'] != "Master") {
    header("location:../index.php");
    }
    $table = "tm_distributor";
    $dataDis = $dis->select($table);
    $autokode = $dis->autokodeLimaDigit($table,"id_distributor","DS");

    if (isset($_GET['delete'])) {
        $where = "id_distributor";
        $whereValues = $_GET['id'];
        $redirect = "?page=viewDistributor";
        $response = $dis->delete($table, $where, $whereValues, $redirect);
    }

    if (isset($_GET['edit'])) {
        $id = $_GET['id'];
        $editData = $dis->selectWhere($table,"id_distributor",$id);
        $autokode = $editData['id_distributor'];
    }
    if (isset($_POST['getSave'])) {
        $id_distributor   = $dis->validateHtml($_POST['id_distributor']);
        $nama_distributor = $dis->validateHtml($_POST['nama_distributor']);
        $alamat           = $dis->validateHtml($_POST['alamat']);
        $telp             = $dis->validateHtml($_POST['telp']);

        if ($id_distributor == " " || empty($id_distributor) || $nama_distributor == " " || empty($nama_distributor) || $alamat == " " || empty($alamat) || $telp == " " || empty($telp)) {
            $response = ['response'=>'negative','alert'=>'Lengkapi field'];
        } else {
            $validno = substr($telp, 0,2);
            if ($validno != "08") {
                $response = ['response'=>'negative','alert'=>'Masukan nomor HP yang valid'];
            } else {
                if (strlen($telp) < 12) {
                    $response = ['response'=>'negative','alert'=>'Masukan 12 digit nomor HP'];
                }else{
                    $value = "'$id_distributor','$nama_distributor','$alamat','$telp'";
                    $response = $dis->insert($table,$value,"?page=viewDistributor");
                }
            }
        }
    }

    if (isset($_POST['getUpdate'])) {
        $id_distributor   = $dis->validateHtml($_POST['kode_distributor']);
        $nama_distributor = $dis->validateHtml($_POST['nama_distributor']);
        $telp             = $dis->validateHtml($_POST['telp']);
        $alamat           = $dis->validateHtml($_POST['alamat']);

        if ($id_distributor == "" || $nama_distributor == "" || $telp == "" || $alamat == "") {
            $response = ['response'=>'negative','alert'=>'lengkapi field'];
        }else{
            $validno = substr($telp, 0,2);
            if ($validno != "08") {
                $response = ['response'=>'negative','alert'=>'Masukan nohp yang valid'];
            }else{
                if (strlen($telp) < 11) {
                    $response = ['response'=>'negative','alert'=>'Masukan 11 digit nohp'];
                }else{
                    $value = "id_distributor='$id_distributor', nama_distributor='$nama_distributor', alamat='$alamat', telp='$telp'";
                    $response = $dis->update($table, $value,"id_distributor",$_GET['id'], "?page=viewDistributor");
                }
            }
        }
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
                                <li class="list-inline-item">Data Distributor</li>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" >
                            <strong class="card-title mb-3">Tambah Distributor</strong>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="">ID distributor</label>
                                    <input type="text" class="form-control form-control-sm" name="kode_distributor" style="font-weight: bold; color: red;" value="<?php echo $autokode; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama distributor</label>
                                    <input type="text" class="form-control form-control-sm" name="nama_distributor" value="<?php echo @$editData['nama_distributor'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">No.HP distributor</label>
                                    <input type="text" class="form-control form-control-sm" name="telp" value="<?php echo @$editData['telp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" rows="5" class="form-control"><?php echo @$editData['alamat'] ?></textarea>
                                </div>
                                <hr>
                                <?php if (isset($_GET['edit'])): ?>
                                <button type="submit" name="getUpdate" class="btn btn-warning"><i class="fa fa-check"></i> Update</button>
                                <a href="?page=viewDistributor" class="btn btn-danger">Cancel</a>
                                <?php endif ?>
                                <?php if (!isset($_GET['edit'])): ?>    
                                <button type="submit" name="getSave" class="btn btn-primary"><i class="fa fa-download"></i> Simpan</button>
                                <?php endif ?>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                        <div class="card-header">
                            <strong class="card-title mb-3">Data Distributor</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               <table id="example" class="table table-borderless table-striped table-earning">
                                   <thead>
                                       <tr>
                                            <th>Kode distributor</th>
                                            <th>Nama</th>
                                            <th>No HP</th>
                                            <th>Alamat</th>
                                            <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                            $no = 1;
                                            foreach($dataDis as $ds){
                                         ?>
                                       <tr>
                                            <td><?= $ds['id_distributor'] ?></td>
                                            <td><?= $ds['nama_distributor'] ?></td>
                                            <td><?= $ds['telp'] ?></td>
                                            <td><?= $ds['alamat'] ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="?page=viewDistributor&edit&id=<?= $ds['id_distributor'] ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="Delete" href="#" class="btn btn-danger"><i class="fa fa-trash" id="btnDelete<?php echo $no; ?>" ></i></a>
                                                </div>
                                            </td>
                                       </tr>
                                       <script src="assets/vendor/jquery-3.2.1.min.js"></script>
                                       <script>
                                        $('#btnDelete<?php echo $no; ?>').click(function(e){
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
                                                            window.location.href="?page=viewDistributor&delete&id=<?php echo $ds['id_distributor'] ?>";
                                                        }
                                                      });
                                                    });
                                        </script>
                                       <?php $no++; } ?>
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
</div>
