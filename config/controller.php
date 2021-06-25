<?php

include "helpers/dbCon.php";

$rg = new lsp();

class lsp
{

    //index.php area
    public function login($username, $password)
    {
        global $con;

        // $sql = "SELECT * FROM tm_user WHERE username ='$username'";
        $sql = "SELECT tm_user.id_user as id_user, tm_ruangan.nama_ruangan as nama_ruangan, tm_level_user.nama_level_user as level, tm_user.nama_user as nama_user, tm_user.username as username, tm_user.password as password, tm_user.foto_user as foto_user FROM tm_user LEFT JOIN tm_ruangan ON tm_ruangan.id_ruangan=tm_user.id_ruangan LEFT JOIN tm_level_user ON tm_level_user.id_level_user=tm_user.id_level_user WHERE tm_user.username = '$username'";
        // $sql = "SELECT * FROM tm_user INNER JOIN tm_ruangan ON tm_ruangan.id_ruangan=tm_user.id_ruangan INNER JOIN tm_level_user ON tm_level_user.id_level_user=tm_user.id_level_user WHERE tm_user.username = '$username'";
        $query = mysqli_query($con, $sql);
        $rows  = mysqli_num_rows($query);
        $assoc = mysqli_fetch_assoc($query);
        if ($rows > 0) {
            if (base64_decode($assoc['password']) == $password) {
                return ['response' => 'positive', 'alert' => 'Berhasil Login', 'level' => $assoc['level']];
            } else {
                return ['response' => 'negative', 'alert' => 'Password Salah'];
            }
        } else {
            return ['response' => 'negative', 'alert' => 'Username atau Password Salah'];
        }
    }

    public function redirect($redirect)
    {
        return ['response' => 'positive', 'alert' => 'Login Berhasil', 'redirect' => $redirect];
    }

    public function logout()
    {
        session_destroy();
        header("Location:index.php");
    }

    public function logout2()
    {
        session_destroy();
        header("Location:index.php");
    }

    public function selectSum($table, $namaField)
    {
        global $con;
        $sql = "SELECT SUM($namaField) as sum FROM $table";
        $query = mysqli_query($con, $sql);
        return $data = mysqli_fetch_assoc($query);
    }

    public function selectSumWhere($table, $namaField, $where)
    {
        global $con;
        $sql = "SELECT SUM($namaField) as sum FROM $table WHERE $where";
        $query = mysqli_query($con, $sql);
        return $data = mysqli_fetch_assoc($query);
    }

    public function selectCount($table, $namaField)
    {
        global $con;
        $sql = "SELECT COUNT($namaField) as count FROM $table";
        $query = mysqli_query($con, $sql);
        return $data = mysqli_fetch_assoc($query);
    }

    public function selectBetween($table, $whereparam, $param, $param1)
    {
        global $con;
        $sql = "SELECT * FROM $table WHERE $whereparam BETWEEN '$param' AND '$param1'";
        $query = mysqli_query($con, $sql);

        $sqls = "SELECT SUM(stok_barang) as count FROM $table WHERE $whereparam BETWEEN '$param' AND '$param1'";
        $querys = mysqli_query($con, $sqls);
        $assocs = mysqli_fetch_assoc($querys);
        $data = [];
        while ($bigData = mysqli_fetch_assoc($query)) {
            $data[] = $bigData;
        }
        return ['data' => $data, 'jumlah' => $assocs];
    }

    public function AuthUser($sessionUser)
    {
        global $con;
        // $sql = "SELECT * FROM tm_user WHERE username = '$sessionUser'";
        $sql = "SELECT tm_user.id_user as id_user, tm_ruangan.nama_ruangan as nama_ruangan, tm_level_user.nama_level_user as level, tm_user.nama_user as nama_user, tm_user.username as username, tm_user.password as password, tm_user.foto_user as foto_user FROM tm_user LEFT JOIN tm_ruangan ON tm_ruangan.id_ruangan=tm_user.id_ruangan LEFT JOIN tm_level_user ON tm_level_user.id_level_user=tm_user.id_level_user WHERE tm_user.username = '$sessionUser'";
        $query = mysqli_query($con, $sql);
        $bigData = mysqli_fetch_assoc($query);
        return $bigData;
    }

    public function register($id_user, $id_ruangan, $id_level, $name, $username, $password, $confirm, $foto, $redirect)
    {

        global $con;
        global $rg;

        if ($id_user == " " || empty($id_user) ||  $id_ruangan == " " || empty($id_ruangan) ||  $id_level == " " || empty($id_level) ||  $name == " " || empty($name) || $username == " " || empty($username) || $password == " " || empty($password) || $confirm == " " || empty($confirm)) {
            return ['response' => 'negative', 'alert' => 'Lengkapi Form'];
        }

        $sql     = "SELECT * FROM tm_user WHERE username = '$username'";
        $query   = mysqli_query($con, $sql);
        $rows    = mysqli_num_rows($query);

        if (strlen($username) < 6) {
            return ['response' => 'negative', 'alert' => 'username minimal 6 Huruf'];
        }

        if ($rows == 0) {

            $name     = htmlspecialchars($name);
            $username = strtolower(htmlspecialchars($username));
            $password = htmlspecialchars($password);
            $confirm  = htmlspecialchars($confirm);

            if ($password == $confirm) {
                $password = base64_encode($password);
                $response = $rg->validateImage();
                $sql = "INSERT INTO tm_user VALUES('$id_user', '$id_ruangan', '$id_level', '$name', '$username', '$password', '$response[image]')";
                $query   = mysqli_query($con, $sql);
                if ($query) {
                    return ['response' => 'positive', 'alert' => 'Registrasi Berhasil', 'redirect' => $redirect];
                } else {
                    return ['response' => 'negative', 'alert' => 'Registrasi Error'];
                }
            } else {
                return ['response' => 'negative', 'alert' => 'Password Tidak Cocok'];
            }
        } else if ($rows == 1) {
            return ['response' => 'negative', 'alert' => 'Username telah digunakan'];
        }
    }

    public function autokode($table, $field, $pre)
    {
        global $con;
        $sqlc   = "SELECT COUNT($field) as jumlah FROM $table";
        $querys = mysqli_query($con, $sqlc);
        $number = mysqli_fetch_assoc($querys);
        if ($number['jumlah'] > 0) {
            $sql    = "SELECT MAX($field) as kode FROM $table";
            $query  = mysqli_query($con, $sql);
            $number = mysqli_fetch_assoc($query);
            $strnum = substr($number['kode'], 2, 3);
            $strnum = $strnum + 1;
            if (strlen($strnum) == 3) {
                $kode = $pre . $strnum;
            } else if (strlen($strnum) == 2) {
                $kode = $pre . "0" . $strnum;
            } else if (strlen($strnum) == 1) {
                $kode = $pre . "00" . $strnum;
            }
        } else {
            $kode = $pre . "001";
        }
        return $kode;
    }

    public function autokodeLimaDigit($table, $field, $pre)
    {
        global $con;
        $sqlc   = "SELECT COUNT($field) as jumlah FROM $table";
        $querys = mysqli_query($con, $sqlc);
        $number = mysqli_fetch_assoc($querys);
        if ($number['jumlah'] > 0) {
            $sql    = "SELECT MAX($field) as kode FROM $table";
            $query  = mysqli_query($con, $sql);
            $number = mysqli_fetch_assoc($query);
            $strnum = substr($number['kode'], 2, 5);
            $strnum = $strnum + 1;
            if (strlen($strnum) == 5) {
                $kode = $pre . $strnum;
            } else if (strlen($strnum) == 4) {
                $kode = $pre . "0" . $strnum;
            } else if (strlen($strnum) == 3) {
                $kode = $pre . "00" . $strnum;
            } else if (strlen($strnum) == 2) {
                $kode = $pre . "000" . $strnum;
            } else if (strlen($strnum) == 1) {
                $kode = $pre . "0000" . $strnum;
            }
        } else {
            $kode = $pre . "00001";
        }
        return $kode;
    }

    public function autokodeTanggal($table, $field, $pre)
    {
        global $con;
        $tanggal = date('ymd');

        $sqlc   = "SELECT COUNT($field) as jumlah FROM $table";
        $querys = mysqli_query($con, $sqlc);
        $number = mysqli_fetch_assoc($querys);
        if ($number['jumlah'] > 0) {
            $sql    = "SELECT MAX($field) as kode FROM $table";
            $query  = mysqli_query($con, $sql);
            $number = mysqli_fetch_assoc($query);
            $strnum = substr($number['kode'], 2, 4);
            $strnum = $strnum + 1;
            if (strlen($strnum) == 4) {
                $kode = $pre . $tanggal . $strnum;
            } else if (strlen($strnum) == 3) {
                $kode = $pre . $tanggal .  "0" . $strnum;
            } else if (strlen($strnum) == 2) {
                $kode = $pre . $tanggal . "00" . $strnum;
            } else if (strlen($strnum) == 1) {
                $kode = $pre . $tanggal . "000" . $strnum;
            }
        } else {
            $kode = $pre . $tanggal . "0001";
        }
        return $kode;
    }

    public function querySelect($sql)
    {
        global $con;
        $query = mysqli_query($con, $sql);
        $data = [];
        while ($bigData = mysqli_fetch_assoc($query)) {
            $data[] = $bigData;
        }
        return $data;
    }

    public function selectWhere($table, $where, $whereValues)
    {
        global $con;
        $sql = "SELECT * FROM $table WHERE $where = '$whereValues'";
        $query = mysqli_query($con, $sql);
        return $data = mysqli_fetch_assoc($query);
    }

    public function edit($table, $where, $whereValues)
    {
        global $con;
        $sql = "SELECT * FROM $table WHERE $where = '$whereValues'";
        $query = mysqli_query($con, $sql);
        $data = [];
        while ($bigData = mysqli_fetch_assoc($query)) {
            $data[] = $bigData;
        }
        return $data;
    }

    public function getCountRows($table)
    {
        global $con;
        $sql   = "SELECT * FROM $table";
        $query = mysqli_query($con, $sql);
        $rows  = mysqli_num_rows($query);
        return $rows;
    }

    public function sessionCheck()
    {
        if (!isset($_SESSION['username'])) {

            return "false";
        } else {

            return "true";
        }
    }

    public function insert($table, $values, $redirect)
    {
        global $con;
        $sql   = "INSERT INTO $table VALUES($values)";
        $query = mysqli_query($con, $sql);
        if ($query) {
            return ['response' => 'positive', 'alert' => 'Berhasil Menambahkan Data', 'redirect' => $redirect];
        } else {
            echo mysqli_error($con);
            return ['response' => 'negative', 'alert' => 'Gagal Menambahkan Data'];
        }
    }

    public function insertRiwayat($table, $values)
    {
        global $con;
        $sql   = "INSERT INTO $table VALUES($values)";
        $query = mysqli_query($con, $sql);
    }

    public function update($table, $values, $where, $whereValues, $redirect)
    {
        global $con;
        $sql   = "UPDATE $table SET $values WHERE $where = '$whereValues'";
        $query = mysqli_query($con, $sql);
        if ($query) {
            return ['response' => 'positive', 'alert' => 'Berhasil update data', 'redirect' => $redirect];
        } else {
            echo mysqli_error($con);
            return ['response' => 'negative', 'alert' => 'Gagal Update Data'];
        }
    }

    public function select($table)
    {
        global $con;
        $sql = "SELECT * FROM $table";
        $query = mysqli_query($con, $sql);
        $data = [];
        while ($bigData = mysqli_fetch_assoc($query)) {
            $data[] = $bigData;
        }
        return $data;
    }

    public function selectPegawai()
    {
        global $con;
        $sql = "SELECT tm_user.id_user as id_user, tm_ruangan.nama_ruangan as nama_ruangan, tm_level_user.nama_level_user as level, tm_user.nama_user as nama_user, tm_user.username as username, tm_user.password as password, tm_user.foto_user as foto_user FROM tm_user LEFT JOIN tm_ruangan ON tm_ruangan.id_ruangan=tm_user.id_ruangan LEFT JOIN tm_level_user ON tm_level_user.id_level_user=tm_user.id_level_user";
        $query = mysqli_query($con, $sql);
        $data = [];
        while ($bigData = mysqli_fetch_assoc($query)) {
            $data[] = $bigData;
        }
        return $data;
    }

    public function selectPegawaiWhere($id_user)
    {
        global $con;
        $sql = "SELECT tm_user.id_user as id_user, tm_ruangan.nama_ruangan as nama_ruangan, tm_level_user.nama_level_user as level, tm_user.nama_user as nama_user, tm_user.username as username, tm_user.password as password, tm_user.foto_user as foto_user FROM tm_user LEFT JOIN tm_ruangan ON tm_ruangan.id_ruangan=tm_user.id_ruangan LEFT JOIN tm_level_user ON tm_level_user.id_level_user=tm_user.id_level_user WHERE tm_user.id_user='$id_user'";
        $query = mysqli_query($con, $sql);
        return $data = mysqli_fetch_assoc($query);
    }

    public function selectBhp($table1, $table2)
    {
        global $con;
        // $sql2 = "SELECT * FROM $table1 JOIN $table2 WHERE ";
        $sql = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.id_kategori_bhp = $table2.id_kategori_bhp ORDER BY $table1.id_barang_bhp";
        $query = mysqli_query($con, $sql);
        $data = [];
        while ($bigData = mysqli_fetch_assoc($query)) {
            $data[] = $bigData;
        }
        return $data;
    }

    public function selectCountWhere($table, $namaField, $where)
    {
        global $con;
        $sql = "SELECT COUNT($namaField) as count FROM $table WHERE $where";
        $query = mysqli_query($con, $sql);
        return $data = mysqli_fetch_assoc($query);
    }

    public function validateHtml($field)
    {
        $field = htmlspecialchars($field);
        return $field;
    }

    function validateImage()
    {
        global $con;
        $name       = $_FILES['foto']['name'];
        $ukuranFile = $_FILES['foto']['size'];
        $error      = $_FILES['foto']['error'];
        $tmpName    = $_FILES['foto']['tmp_name'];


        $folder = 'assets/img/';

        $ekstensiGambar = explode('.', $name);
        $namaGambar = $ekstensiGambar[0];
        $ekstensiBelakang = strtolower(end($ekstensiGambar));
        $ekstensi = ['jpg', 'jpeg', 'png', 'gif'];
        $error = array();


        if (in_array($ekstensiBelakang, $ekstensi) === false) {
            return ['response' => 'negative', 'alert' => 'Gambar hanya boleh menggunakan ekstensi jpg,jpeg,png'];
        }

        if ($ukuranFile > 4000000) {
            return ['response' => 'negative', 'alert' => 'Ukuran gambar terlalu besar'];
        }


        if (empty($errors)) {
            if (!file_exists('img')) {
                mkdir('img', 0563);
            }
        }
        $name = rand(1, 999);
        $name = time() . $name . "." . $ekstensiBelakang;
        move_uploaded_file($tmpName, $folder . $name);

        return ['types' => 'true', 'image' => $name];
    }

    public function delete($table, $where, $whereValues, $redirect)
    {
        global $con;
        $sql = "DELETE FROM $table WHERE $where = '$whereValues'";
        $query = mysqli_query($con, $sql);
        if ($query) {
            return ['response' => 'positive', 'alert' => 'Berhasil Menghapus Data', 'redirect' => $redirect];
        } else {
            echo mysqli_error($con);
            return ['response' => 'negative', 'alert' => 'Gagal Menghapus Data'];
        }
    }
}
