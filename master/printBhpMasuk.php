<?php 
	// $struk  = new lsp();
	// $id = $_GET['id'];
	// $data   = $struk->edit("transaksi","kd_transaksi",$id);
	// $total  = $struk->selectSumWhere("transaksi","sub_total","kd_transaksi='$id'");
	// $dataDetail = $struk->edit("detailTransaksi","kd_transaksi",$id);
	// $jumlah_barang = $struk->selectSumWhere("transaksi","jumlah","kd_transaksi='$id'");
$dt = new lsp();
$status = $_GET['status'];
$id_transaksi = $_GET['id'];

$detail = $dt->querySelect("SELECT * FROM tr_barang_bhp_" . $status . "_detail LEFT JOIN tm_barang_bhp ON tr_barang_bhp_" . $status . "_detail.id_barang_bhp = tm_barang_bhp.id_barang_bhp LEFT JOIN tm_distributor ON tr_barang_bhp_" . $status . "_detail.id_distributor = tm_distributor.id_distributor WHERE id_transaksi = '" . $id_transaksi . "'");
$sub = 0;
 ?>
 <style>
 	.col-sm-8{
 		background: white;
 		padding: 20px;
 	}
 	@media print{
 		table{
 			align-content: center;
 		}
 		.ds{
 			display: none;
 		}
 		.card{
 			box-shadow: none;
 			border: none;
 		}
 		.hd{
 			display: none;
 		}
 	}
 </style>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
            	<div class="col-md-2"></div>
            	<div class="col-md-8">
            		<div class="card">
            			<div class="card-header">
            				<h4>Struk</h4>
            				<p>PT Inventory Indonesia</p>
            			</div>
            			<div class="card-body">
            				<div class="row">
				                  <div class="col-sm-6">Kode Transaksi : <?php echo $id_transaksi ?></div>
				                  <div class="col-sm-6">
				                        <p class="text-right"><span><?php echo "Tanggal Cetak : ".date("Y-m-d"); ?></p>
				                  </div>
				            </div>
				            <br>
				            <table class="table table-striped table-bordered" width="80%">
								<tr>
									<td>ID Daftar</td>
									<td>Nama Barang</td>
									<td>Jumlah Stock</td>
					                <td>Harga Satuan</td>
									<td>Sub Total</td>
								</tr>
								<?php 
								foreach ($detail as $dd): ?>
								<tr>
								<td><?= $dd['id_bhp_masuk']; ?></td>
												<td><?= $dd['nama_barang_bhp']; ?></td>
												<td><?= number_format($dd['jumlah']); ?></td>
												<td><?= number_format($dd['harga']); ?></td>
												<td><?= number_format($dd['harga'] * $dd['jumlah']); ?></td>
								</tr>
								<?php endforeach ?>
								<tr>
					                <td colspan="1"></td>
								    <td>Jumlah Pembelian Barang</td>
					                <td><?= number_format($sub); ?></td>
					              
									<td colspan="1">Total</td>
									<td><?php echo "Rp.".number_format($sub['sum']).",-" ?></td>
								</tr>
							</table>
							<br>
					            <p>Tanggal Masuk : <?php echo $dd['tanggal_masuk']; ?></p>
								<br>
								<a href="#" class="btn btn-info ds" onclick="window.print()"><i class="fa fa-print"></i> Cetak Struk</a>
								<a href="pageMaster.php?page=viewBhpMasuk" class="btn btn-danger ds">Kembali</a>
            			</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>