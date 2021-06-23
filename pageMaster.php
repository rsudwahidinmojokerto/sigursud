<?php
include "helpers/sessionCheck.php";
?>

<!DOCTYPE html>
<html>

<!-- Header - Meta, Title, CSS,  -->
<?php
include "app/views/_layout/_meta.php";
include "app/views/_layout/_css.php";
?>

<body>
    <div class="page-wrapper">
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <img src="assets/images/icon/logo-sigu-white.png" alt="RSUD Wahidin" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="assets/img/avatar/<?= $auth['foto_user'] ?>" />
                    </div>
                    <h4 class="name"><?= $auth['nama_user']; ?></h4>
                    <h6 class="email" style="color: #FF8C00;"><?= $auth['nama_ruangan']; ?></h6>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="?page">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fas fa-cogs"></i>Kategori Barang</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="?page=viewKategoriBhp">Kategori BHP</a>
                                </li>
                                <li>
                                    <a href="?page=viewKategoriAset">Kategori ASET</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?page=viewStokBarang">
                                <i class="fas fa-archive"></i>Stock Barang</a>
                        </li>
                        <li>
                            <a href="?page=viewMasterBarangBhp">
                                <i class="fas fa-archive"></i>Master Barang</a>
                        </li>
                        <li>
                            <a href="?page=viewDistributor">
                                <i class="fas fa-truck"></i>Master Distributor</a>
                        </li>
                        <li>
                            <a href="?page=viewRuangan">
                                <i class="fas fa-users"></i>Master Ruangan</a>
                        </li>
                        <li>
                            <a href="?page=viewPegawai">
                                <i class="fas fa-users"></i>Master Pegawai</a>
                        </li>
                        <li>
                            <a href="?page=viewSatuan">
                                <i class="fas fa-users"></i>Master Satuan</a>
                        </li>
                        <!-- <li>
                            <a href="?page=viewJenisbarang">
                            <i class="fas fa-filter"></i>Jenis Barang</a>
                        </li> -->
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-container2">
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <img src="assets/images/icon/logo-sigu-white.png" width="340" aalt="CoolAdmin" />
                                </a>
                            </div>
                            <div class="header-button2">
                                <div class="header-button-item js-item-menu">
                                    <i class="zmdi zmdi-search"></i>
                                    <div class="search-dropdown js-dropdown">
                                        <form action="">
                                            <input class="au-input au-input--full au-input--h65" type="text" placeholder="Search for datas &amp; reports..." />
                                            <span class="search-dropdown__icon">
                                                <i class="zmdi zmdi-search"></i>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="header-button-item has-noti js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>You have 3 Notifications</p>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-email-open"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a email notification</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c2 img-cir img-40">
                                                <i class="zmdi zmdi-account-box"></i>
                                            </div>
                                            <div class="content">
                                                <p>Your account has been blocked</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c3 img-cir img-40">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a new file</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__footer">
                                            <a href="#">All notifications</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="?page=profile">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-settings"></i>Setting</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="homepage.php?logout" id="forLogout">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <img src="assets/images/icon/logo-sigu-white.png" lt="Cool Admin" />
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar2">
                    <div class="account2">
                        <div class="image img-cir img-120">
                            <img src="assets/img/avatar/<?= $auth['foto_user'] ?>" alt="John Doe" />
                        </div>
                        <h4 class="name"><?= $auth['nama_user'] ?></h4>
                        <a href="#">Sign out</a>
                    </div>
                    <nav class="navbar-sidebar2">
                        <ul class="list-unstyled navbar__list">
                            <li>
                                <a href="?page">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="?page=viewBarang">
                                    <i class="fas fa-archive"></i>Barang</a>
                            </li>
                            <li>
                                <a href="?page=viewDistributor">
                                    <i class="fas fa-users"></i>Distributor</a>
                            </li>
                            <li>
                                <a href="?page=viewRuangan">
                                    <i class="fas fa-users"></i>Ruangan</a>
                            </li>
                            <li>
                                <a href="?page=viewJenisbarang">
                                    <i class="fas fa-filter"></i>Jenis Barang</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <?php
            @$page = $_GET['page'];
            switch ($page) {
                case 'viewBarang':
                    include "master/viewBarang.php";
                    break;
                case 'viewStokBarang':
                    include "master/viewStokBarang.php";
                    break;
                case 'viewSatuan':
                    include "master/viewSatuan.php";
                    break;
                case 'viewPegawai':
                    include "master/viewPegawai.php";
                    break;
                case 'viewMasterBarangBhp':
                    include "master/viewMasterBarangBhp.php";
                    break;
                case 'viewDistributor':
                    include "master/viewDistributor.php";
                    break;
                case 'viewRuangan':
                    include "master/viewRuangan.php";
                    break;
                case 'viewJenisbarang':
                    include "master/viewJenisbarang.php";
                    break;
                case 'viewKategoriBhp':
                    include "master/viewKategoriBhp.php";
                    break;
                case 'viewKategoriAset':
                    include "master/viewKategoriAset.php";
                    break;
                case 'addBarangBhp':
                    include "master/addBarangBhp.php";
                    break;
                case 'addStokBarangMasuk':
                    include "master/addStokBarangMasuk.php";
                    break;
                case 'editBarangBhp':
                    include "master/editBarangBhp.php";
                    break;
                case 'viewBarangDetail':
                    include "master/viewBarangDetail.php";
                    break;
                case 'viewBarangEdit':
                    include "master/viewBarangEdit.php";
                    break;
                case 'profile':
                    include "profile.php";
                    break;
                default:
                    $page = "dashboard";
                    include "master/dashboard.php";
                    break;
            }
            ?>
        </div>
    </div>

    <!-- <script src="assets/vendor/jquery-3.2.1.min.js"></script> -->

    <!-- Footer - JS  -->
    <?php include "app/views/_layout/_js.php" ?>

    <script>
        $(document).ready(function() {
            function preview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#pict').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#gambar').change(function() {
                preview(this);
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            function preview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#pict2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#gambar2').change(function() {
                preview(this);
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#forLogout').click(function(e) {
                e.preventDefault();
                swal({
                    title: "Logout",
                    text: "Yakin Logout?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = "?logout";
                    }
                });
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <?php include "helpers/alert.php"; ?>
</body>

</html>