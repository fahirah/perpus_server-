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
 * Verb: buku
 */
$app->post('/admin/buku', function() use ($app,$ctr) {
	$ctr->load('model','buku');
	$r=$ctr->BukuModel->tambah_buku();
	json_output($app, $r);
});
