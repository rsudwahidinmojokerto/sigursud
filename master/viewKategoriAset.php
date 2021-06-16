<?php 
    $me       = new lsp();
    if ($_SESSION['level'] != "Admin") {
    header("location:../index.php");
    }
    $table            = "tm_kategori_aset";
    $dataKategoriaset  = $me->select($table);
    $autokode         = $me->autokode($table,"id_kategori_aset","AS");

    if (isset($_GET['delete'])) {
        $id       = $_GET['id'];
        $cek      = $me->selectCountWhere($table, "id_kategori_aset", "nama_kategori_aset='$id'");
        // echo $cek['count'];
        if ($cek['count'] > 0) {
            $response = ['response'=>'negative','alert'=>'jenis barang ini sudah di pakai di barang tidak dapat di hapus'];
        }else{
        $where    = "id_kategori_aset";
        $response = $me->delete($table, $where, $id,"?page=viewKategoriAset");
        }
    }

    if (isset($_POST['getSave'])) {
        $id_kategori_aset        = $me->validateHtml($_POST['id_kategori_aset']);
        $nama_kategori_aset      = $me->validateHtml($_POST['nama_kategori_aset']);

        $value    = "'$id_kategori_aset','$nama_kategori_aset'";
        $response = $me->insert($table, $value, "?page=viewKategoriAset");

        // $foto = $_FILES['foto'];

        // if ($kode_jenisbarang == "" || $jenis_barang == "") {
        //     $response = ['response'=>'negative','alert'=>'lengkapi field'];
        // }else{
        //     $response = $me->validateImage();
        //     if ($response['types'] == "true") {
        //         $value    = "'$kode_jenisbarang','$jenis_barang','$response[image]'";
        //         $response = $me->insert($table,$value,"?page=viewJenisbarang");
        //     }
            
        // }
    }

    if (isset($_POST['getUpdate'])) {
        $id_kategori_aset        = $me->validateHtml($_POST['id_kategori_aset']);
        $nama_kategori_aset      = $me->validateHtml($_POST['nama_kategori_aset']);

        $value = "id_kategori_aset='$id_kategori_aset',nama_kategori_aset='$nama_kategori_aset'";
        $response = $me->update($table, $value,"id_kategori_aset",$_GET['id'],"?page=viewKategoriAset");

        // if ($_FILES['foto']['name'] == "") {
        //      $value    = "kd_jenisbarang='$kode_jenisbarang',jenis_barang='$jenis_barang'";
        //      $response = $me->update($table,$value,"kd_jenisbarang",$_GET['id'],"?page=viewJenisbarang");
        // }else{
        //     $response = $me->validateImage();
        //     if ($response['types'] == "true") {
        //         $value = "kd_jenisbarang='$kode_jenisbarang',jenis_barang='$jenis_barang', foto_jenisbarang='$response[image]'";
        //         $response = $me->update($table,$value,"kd_jenisbarang",$_GET['id'],"?page=viewJenisbarang");
        //     }else{
        //         $response = ['response'=>'negative','alert'=>'Error Gambar'];
        //     }
        // }
    }

    if (isset($_GET['edit'])) {
        $editData = $me->selectWhere($table,"id_kategori_aset",$_GET['id']);
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
                                <li class="list-inline-item">Data Kategori ASET</li>
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
                            <strong class="card-title mb-3">Input Kategori</strong>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="">Kode Kategori ASET</label>
                                    <?php if(!isset($_GET['edit'])) : ?>
                                    <input type="text" class="form-control form-control-sm" name="id_kategori_aset" style="font-weight: bold; color: red;" value="<?php echo $autokode; ?>" readonly>
                                    <?php endif ?>
                                    <?php if(isset($_GET['edit'])) : ?>
                                    <input type="text" class="form-control form-control-sm" name="id_kategori_aset" style="font-weight: bold; color: red;" value="<?php echo @$editData['id_kategori_aset']; ?>" readonly>
                                    <?php endif ?>

                                </div>
                                <div class="form-group">
                                    <label for="">Nama Kategori</label>
                                    <input type="text" class="form-control form-control-sm" name="nama_kategori_aset" value="<?php echo @$editData['nama_kategori_aset'] ?>">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="">Foto</label>
                                    <input type="file" name="foto" id="gambar" class="form-control-file">
                                    <div style="padding-bottom: 15px;">
                                        <img alt="" src="img/<?= @$editData['foto_jenisbarang'] ?>" width="120" class="img-responsive" id="pict">
                                    </div>
                                </div> -->
                                <hr>
                                <?php if (isset($_GET['edit'])): ?>
                                <button type="submit" name="getUpdate" class="btn btn-warning"><i class="fa fa-check"></i> Update</button>
                                <a href="?page=viewKategoriAset" class="btn btn-danger">Cancel</a>
                                <?php endif ?>
                                <?php if (!isset($_GET['edit'])): ?>    
                                <button type="submit" name="getSave" class="btn btn-primary"><i class="fa fa-download"></i> Simpan</button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                                <?php endif ?>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                        <div class="card-header">
                            <strong class="card-title mb-3">Data Kategori</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               <table id="example" class="table table-borderless table-striped table-earning">
                                   <thead>
                                       <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <!-- <th>Logo</th> -->
                                            <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                            $no = 1;
                                            foreach($dataKategoriaset as $aset){
                                         ?>
                                       <tr>
                                            <td><?= $aset['id_kategori_aset'] ?></td>
                                            <td><?= $aset['nama_kategori_aset'] ?></td>
                                            <!-- <td><img width="60" src="img/<?= $aset['foto_jenisbarang'] ?>" alt=""></td> -->
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="?page=viewKategoriaset&edit&id=<?= $aset['id_kategori_aset'] ?>" class="btn btn-info"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <a data-toggle="tooltip" data-placement="top" title="Delete" href="#" class="btn btn-danger"><i class="fa fa-trash" id="btnDelete<?php echo $no; ?>" ></i></a>
                                                </div>
                                            </td>
                                       </tr>
                                       <script src="vendor/jquery-3.2.1.min.js"></script>
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
                                                        window.location.href="?page=viewKategoriaset&delete&id=<?php echo $aset['id_kategori_aset'] ?>";
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
