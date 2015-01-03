<?php

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: blank
 */
$app->options('/', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/', function() use ($app) { 
	echo "<h1>REST WEB SERVICE</h1>";
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: pencarian
 */
$app->options('/pencarian', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/pencarian', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$ctr->load('helper', 'date');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
	$r=$ctr->MainModel->view_pencarian($iofiles);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: buku
 */
$app->options('/buku', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/buku', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->view_buku();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: file
 */
$app->options('/file', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/file', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->view_file();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: login
 */
$app->options('/login', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/login', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->login();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: buku
 */
$app->options('/user/buku', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/user/buku', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->view_buku();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: file
 */
$app->options('/user/file', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/user/file', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$ctr->load('helper', 'date');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
	$r=$ctr->MainModel->view_file($iofiles);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: file
 */
$app->post('/file', function() use ($app,$ctr) {
	$ctr->load('model','file');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
	$r=$ctr->FileModel->tambah_file($iofiles);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: download file
 */
$app->options('/download/:id/:user', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/download/:id/:user', function($id,$user) use ($app,$ctr) {
	$ctr->load('model','main');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	$r=$ctr->MainModel->download_file($id,$user,$iofiles);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: file
 */
$app->options('/user/file/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/user/file/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->delete_file($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: peminjaman
 */
$app->options('/user/peminjaman/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/user/peminjaman/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','main');
	$ctr->load('helper', 'date');
	$r=$ctr->MainModel->view_peminjaman($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: beranda petugas
 */
$app->options('/admin/beranda', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/beranda', function() use ($app,$ctr) {
	$ctr->load('model','beranda');
	$ctr->load('helper', 'date');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
	$r=$ctr->BerandaModel->view_beranda($iofiles);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: beranda anggota
 */
$app->options('/user/beranda', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/user/beranda', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$ctr->load('helper', 'date');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
	$r=$ctr->MainModel->view_berandaanggota($iofiles);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: anggota
 */
$app->options('/admin/anggota', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/anggota', function() use ($app,$ctr) {
	$ctr->load('model','anggota');
	$r=$ctr->AnggotaModel->view_anggota();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: anggota
 */
$app->post('/admin/anggota', function() use ($app,$ctr) {
	$ctr->load('model','anggota');
	$ctr->load('file', 'lib/barcode.php');
	$r=$ctr->AnggotaModel->tambah_anggota();
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: prodi
 */
$app->options('/prodi', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/prodi', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->view_prodi();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: anggota
 */
$app->options('/admin/anggota/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/anggota/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','anggota');
	$r=$ctr->AnggotaModel->delete_anggota($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak kartu anggota
 */
$app->options('/cetak/anggota/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetak/anggota/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->CetakModel->cetak_kartuanggota($id);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak pdf file
 */
$app->options('/cetakpdf/file', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetakpdf/file', function() use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->CetakModel->cetak_pdffile();
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: buku
 */
$app->options('/admin/buku', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/buku', function() use ($app,$ctr) {
	$ctr->load('model','buku');
	$r=$ctr->BukuModel->view_buku();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: reset password anggota
 */
$app->options('/admin/anggota/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/anggota/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','anggota');
	$r=$ctr->AnggotaModel->reset_password($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: buku
 */
$app->post('/admin/buku', function() use ($app,$ctr) {
	$ctr->load('model','buku');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	$ctr->load('file', 'lib/barcode.php');
	
	$r=$ctr->BukuModel->tambah_buku($iofiles);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: buku
 */
$app->options('/admin/buku/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/buku/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','buku');
	$r=$ctr->BukuModel->delete_buku($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: file
 */
$app->options('/admin/file', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/file', function() use ($app,$ctr) {
	$ctr->load('model','file');
	$r=$ctr->FileModel->view_file();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: file
 */
$app->post('/admin/file', function() use ($app,$ctr) {
	$ctr->load('model','file');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
	$r=$ctr->FileModel->tambah_file($iofiles);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: file
 */
$app->options('/admin/file/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/file/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','file');
	$r=$ctr->FileModel->delete_file($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: peminjaman
 */
$app->options('/admin/peminjaman', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/peminjaman', function() use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$ctr->load('helper', 'date');
	$r=$ctr->PeminjamanModel->view_peminjaman();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: peminjaman/kas
 */
$app->options('/admin/peminjaman/kas', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/peminjaman/kas', function() use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$ctr->load('helper', 'date');
	$r=$ctr->PeminjamanModel->view_kas();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cekanggota
 */
$app->options('/cekanggota/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cekanggota/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$r=$ctr->PeminjamanModel->cek_anggota($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cekjumlah
 */
$app->options('/cekjumlah/:idan/:banyak', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cekjumlah/:idan/:banyak', function($idan,$banyak) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$r=$ctr->PeminjamanModel->cek_jumlah($idan,$banyak);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cekbuku
 */
$app->options('/cekbuku/:kode/:idan', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cekbuku/:kode/:idan', function($kode,$idan) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$r=$ctr->PeminjamanModel->view_detilbuku($kode,$idan);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: detailbuku
 */
$app->options('/detailbuku/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/detailbuku/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','buku');
	$ctr->load('helper', 'date');
	$r=$ctr->BukuModel->view_detildatabuku($kode);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: detailfile
 */
$app->options('/detailfile/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/detailfile/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','file');
	$ctr->load('helper', 'date');
	$ctr->load('file', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	$r=$ctr->FileModel->view_detildatafile($kode,$iofiles);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: detailbukubaru
 */
$app->options('/detailbukubaru/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/detailbukubaru/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','beranda');
	$ctr->load('helper', 'date');
	$r=$ctr->BerandaModel->view_detildatabukubaru($kode);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: detailfilebaru
 */
$app->options('/detailfilebaru/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/detailfilbarue/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','beranda');
	$ctr->load('helper', 'date');
	$r=$ctr->BerandaModel->view_detildatafilebaru($kode);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: peminjaman
 */
$app->post('/admin/peminjaman', function() use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$r=$ctr->PeminjamanModel->tambah_peminjaman();
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: detailpeminjaman
 */
$app->options('/detailpjm/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/detailpjm/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$ctr->load('helper', 'date');
	$r=$ctr->PeminjamanModel->view_detilpjm($kode);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: bayar denda
 
$app->options('/bayardenda/:kodepjm/:kodebk', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/bayardenda/:kodepjm/:kodebk', function($kodepjm, $kodebk) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$ctr->load('helper', 'date');
	$r=$ctr->PeminjamanModel->bayar_denda($kodepjm, $kodebk);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});
*/

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: perpanjang peminjaman
 */
$app->options('/perpanjangpjm/:kodepjm/:kodebk', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/perpanjangpjm/:kodepjm/:kodebk', function($kodepjm, $kodebk) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$ctr->load('helper', 'date');
	$r=$ctr->PeminjamanModel->perpanjang_pjm($kodepjm, $kodebk);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: kembali peminjaman
 */
$app->options('/kembalipjm/:kodepjm/:kodebk', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/kembalipjm/:kodepjm/:kodebk', function($kodepjm, $kodebk) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$ctr->load('helper', 'date');
	$r=$ctr->PeminjamanModel->kembali_pjm($kodepjm, $kodebk);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: peminjaman
 */
$app->options('/admin/peminjaman/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/peminjaman/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','peminjaman');
	$r=$ctr->PeminjamanModel->delete_peminjaman($kode);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: pengaturan
 */
$app->options('/admin/pengaturan', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/pengaturan', function() use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->view_pengaturan();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: pengaturan
 */
$app->options('/admin/pengaturan', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/pengaturan', function() use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->ubah_pengaturan();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb:pengaturanprodi
 */
$app->post('/admin/pengaturanprodi', function() use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->tambah_prodi();
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: pengaturanprodi
 */
$app->options('/admin/pengaturanprodi/:kd', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/pengaturanprodi/:kd', function($kd) use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->delete_prodi($kd);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: pengaturanakun
 */
$app->options('/admin/pengaturanakun', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/pengaturanakun', function() use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->ubah_pengaturanakun();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb:petugas
 */
$app->post('/admin/petugas', function() use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->tambah_petugas();
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: petugas
 */
$app->options('/admin/petugas/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/petugas/:kd', function($kd) use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->delete_petugas($kd);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: reset password petugas
 */
$app->options('/admin/pengaturan/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/pengaturan/:id', function($id) use ($app,$ctr) {
	$ctr->load('model','pengaturan');
	$r=$ctr->PengaturanModel->reset_password($id);
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});


// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: pengaturan anggota
 */
$app->options('/user/pengaturan', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/user/pengaturan', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->view_pengaturananggota();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak kartu buku
 */
$app->options('/cetak/buku/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetak/buku/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->CetakModel->cetak_kartubuku($kode);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: pengaturanakun anggota
 */
$app->options('/user/pengaturan', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/user/pengaturan', function() use ($app,$ctr) {
	$ctr->load('model','main');
	$r=$ctr->MainModel->ubah_pengaturanakun();
	if($r===FALSE)
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak pdf anggota
 */
$app->options('/cetakpdf/anggota', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetakpdf/anggota', function() use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->CetakModel->cetak_pdfanggota();
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak pdf buku
 */
$app->options('/cetakpdf/buku', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetakpdf/buku', function() use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->CetakModel->cetak_pdfbuku();
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak pdf peminjaman
 */
$app->options('/cetakpdf/peminjaman', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetakpdf/peminjaman', function() use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->load('helper', 'date');
	$ctr->CetakModel->cetak_pdfpeminjaman();
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: cetak pdf kas
 */
$app->options('/cetakpdf/kas', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/cetakpdf/kas', function() use ($app,$ctr) {
	$ctr->load('model','cetak');
	$ctr->load('helper', 'date');
	$ctr->CetakModel->cetak_pdfkas();
});