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
	$r=$ctr->MainModel->view_pencarian();
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
	$r=$ctr->MainModel->view_file();
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
	$ctr->load('buku', 'lib/IOFiles.php');
	$iofiles = new IOFiles();
	
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
	$r=$ctr->PeminjamanModel->view_peminjaman();
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
 * Verb: detailbuku
 */
$app->options('/detailfile/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/detailfile/:kode', function($kode) use ($app,$ctr) {
	$ctr->load('model','file');
	$ctr->load('helper', 'date');
	$r=$ctr->FileModel->view_detildatafile($kode);
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