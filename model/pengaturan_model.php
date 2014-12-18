<?php
/**
 * Buku Model
 */
namespace Model;

class PengaturanModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_pengaturan() {
		$r=array();
		$d=$this->db->query("select * from tbl_pengaturan ",true);
		
		if(! $d)  return FALSE;				
		return array(
			'kode'=>$d->kode_pengaturan,
			'denda'=>$d->bayar_denda,
			'jumlah'=>$d->jumlah_buku,
			'lama'=> $d->lama_pinjam
		);
	}

	public function ubah_pengaturan(){
		extract($this->prepare_post(array('kode','jumlah','denda','lama')));
		$jumlah = floatval($jumlah);
		$denda = floatval($denda);
		$lama = floatval($lama);
		
		//edit
		$edit=$this->db->query("update tbl_pengaturan set bayar_denda='$denda', jumlah_buku='$jumlah', lama_pinjam='$lama'");
		
		return $this->view_pengaturan();
		
	}
}