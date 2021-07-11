<?php
$dt = new lsp();
$status = $_GET['status'];
$id_transaksi = $_GET['id'];
$detail = $dt->querySelect("SELECT * FROM tr_barang_bhp_" . $status . "_detail LEFT JOIN tm_barang_bhp ON tr_barang_bhp_" . $status . "_detail.id_barang_bhp = tm_barang_bhp.id_barang_bhp LEFT JOIN tm_distributor ON tr_barang_bhp_" . $status . "_detail.id_distributor = tm_distributor.id_distributor WHERE id_transaksi = '" . $id_transaksi . "'");
$sub = 0;
if ($_SESSION['level'] != "Master") {
	header("location:../index.php");
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
								<li class="list-inline-item seprate">
									<span>/</span>
								</li>
								<li class="list-inline-item">Detail BHP Masuk ID <?= $id_transaksi; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="main-content" style="margin-top: -80px;">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="au-card-title" style="background-image:url('assets/images/bg-title-02.jpg');">
							<div class="bg-overlay bg-overlay--blue"></div>
							<h3>
								<i class="zmdi zmdi-assignment-check"></i>Detail Transaksi <b><?= $id_transaksi; ?></b>
							</h3>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<tr>
										<th>ID Daftar</th>
										<th>Nama Barang</th>
										<th>Distributor</th>
										<th>Jumlah Stok</th>
										<th>Harga</th>
										<th>Sub Total</th>
									</tr>
									<?php
									if (count($detail) > 0) {
										$no = 1;
										foreach ($detail as $dd) { ?>
											<tr>
												<td><?= $dd['id_bhp_masuk']; ?></td>
												<td><?= $dd['nama_barang_bhp']; ?></td>
												<td><?= $dd['nama_distributor']; ?></td>
												<td><?= number_format($dd['jumlah']); ?></td>
												<td><?= number_format($dd['harga']); ?></td>
												<td><?= number_format($dd['harga'] * $dd['jumlah']); ?></td>
											</tr>
										<?php $no++;
											$sub += $dd['harga'] * $dd['jumlah'];
										} ?>
										<?php if (count($detail) > 0) : ?>
											<tr>
												<td colspan="5">Total Harga</td>
												<td><?= number_format($sub); ?></td>
											</tr>
										<?php endif ?>
									<?php } else { ?>
										<td colspan="7" class="text-center">Tidak ada daftar</td>
									<?php } ?>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-sm-2">
									<a href="?page=viewBhp<?= ucfirst($status); ?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Kembali</a>
								</div>
								<div class="col-sm-8"></div>
								<div class="col-sm-2">
									<a href="?page=printBhp<?= ucfirst($status); ?>" class="btn btn-success btn-block"><i class="fa fa-print"></i> Cetak</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="main-content" style="margin-top: 20px;">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-header">
							<img class="align-self-center mr-3" width="70" src="img/<?php echo $detail['foto_jenisbarang'] ?>" alt="">
							<h4 class="text-right"><?= $detail['nama_barang'] ?></h4>
						</div>
						<div class="card-body">
							<img style="min-height: 200px; width: 100%; display: block;" src="img/<?php echo $detail['gambar'] ?>">
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h3>Detail Barang</h3>
						</div>
						<div class="card-body">
							<table class="table" cellpadding="10">
								<tr>
									<td>Kode Barang</td>
									<td>:</td>
									<td style="font-weight: bold; color: red;"><?php echo $detail['kd_barang']; ?></td>
								</tr>
								<tr>
									<td>Nama Barang</td>
									<td>:</td>
									<td><?php echo $detail['nama_barang']; ?></td>
								</tr>
								<tr>
									<td>Jenis Barang</td>
									<td>:</td>
									<td><?php echo $detail['jenis_barang']; ?></td>
								</tr>
								<tr>
									<td>Distributor</td>
									<td>:</td>
									<td><?php echo $detail['nama_distributor']; ?></td>
								</tr>
								<tr>
									<td>Tanggal Masuk</td>
									<td>:</td>
									<td><?php echo $detail['tanggal_masuk']; ?></td>
								</tr>
								<tr>
									<td>Harga</td>
									<td>:</td>
									<td><?php echo "Rp." . number_format($detail['harga_barang']) . "-,"; ?></td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>:</td>
									<td><?php echo $detail['stok_barang'] ?></td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>:</td>
									<td><?php echo $detail['keterangan'] ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<a href="?page=viewBarang" class="btn btn-danger"><i class="fa fa-repeat"></i> Kembali</a>
		</div>
	</div>
</div> -->