<?php 
    $dis = new lsp();
    if ($_SESSION['level'] != "Admin") {
    header("location:../index.php");
    }
    $table = "tm_ruangan";
    $dataDis = $dis->select($table);
    $autokode = $dis->autokode($table,"id_ruangan","RU");

    if (isset($_GET['delete'])) {
        $where = "id_ruangan";
        $whereValues = $_GET['id'];
        $redirect = "?page=viewRuangan";
        $response = $dis->delete($table,$where,$whereValues,$redirect);
    }

    if (isset($_GET['edit'])) {
        $id = $_GET['id'];
        $editData = $dis->selectWhere($table,"id_ruangan",$id);
        $autokode = $editData['id_ruangan'];
    }
    if (isset($_POST['getSave'])) {
        $id_ruangan   = $dis->validateHtml($_POST['kode_ruangan']);
        $nama_ruangan = $dis->validateHtml($_POST['nama_ruangan']);
        

        if ($id_ruangan == " " || empty($id_ruangan) || $nama_ruangan == " " || empty($nama_ruangan)) {
             $response = ['response'=>'negative','alert'=>'Lengkapi field'];
             }else{
             $value = "'$id_ruangan','$nama_ruangan'";
             $response = $dis->insert($table,$value,"?page=viewRuangan");
        
        }
    }

    if (isset($_POST['getUpdate'])) {
        $id_ruangan   = $dis->validateHtml($_POST['kode_ruangan']);
        $nama_ruangan = $dis->validateHtml($_POST['nama_ruangan']);
      

        if ($id_ruangan == "" || $nama_ruangan == "") {
            $response = ['response'=>'negative','alert'=>'lengkapi field'];
            }else{
             $value = "id_ruangan='$id_ruangan',nama_ruangan='$nama_ruangan'";
                    $response = $dis->update($table,$value,"id_ruangan",$_GET['id'],"?page=viewRuangan");
        
            
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
                                <li class="list-inline-item">Data Ruangan</li>
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
                            <strong class="card-title mb-3">Input Ruangan</strong>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="">Kode Ruangan</label>
                                    <input type="text" class="form-control form-control-sm" name="kode_ruangan" style="font-weight: bold; color: red;" value="<?php echo $autokode; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Ruangan</label>
                                    <input type="text" class="form-control form-control-sm" name="nama_ruangan" value="<?php echo @$editData['nama_ruangan'] ?>">
                                </div>
                                
                                <hr>
                                <?php if (isset($_GET['edit'])): ?>
                                <button type="submit" name="getUpdate" class="btn btn-warning"><i class="fa fa-check"></i> Update</button>
                                <a href="?page=viewRuangan" class="btn btn-danger">Cancel</a>
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
                            <strong class="card-title mb-3">Data Ruangan</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               <table id="example" class="table table-borderless table-striped table-earning">
                                   <thead>
                                       <tr>
                                            <th>Kode Ruangan</th>
                                            <th>Nama Ruangan</th>
                                          
                                            <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                            $no = 1;
                                            foreach($dataDis as $ds){
                                         ?>
                                       <tr>
                                            <td><?= $ds['id_ruangan'] ?></td>
                                            <td><?= $ds['nama_ruangan'] ?></td>
                                           
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="?page=viewRuangan&edit&id=<?= $ds['id_ruangan'] ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
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
                                                            window.location.href="?page=viewRuangan&delete&id=<?php echo $ds['id_ruangan'] ?>";
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
