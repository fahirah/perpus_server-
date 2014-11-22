<?php
/**
 * Buku Model
 */
namespace Model;

class BukuModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_buku() {
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_buku");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			
			$r[]=array(
				'kode'=>$d->kode_buku,
				'judul'=>$d->judul_buku,
				'pengarang'=>$d->pengarang_buku,
				'stok'=>$d->stok_buku,
				'macam'=>$d->macam_buku,
				'bahasa'=>$d->bahasa_buku,
				'penerbit'=>$d->penerbit_buku,
				'tahun'=>$d->tahun_terbit_buku
			);
		}
		return $r;
	}	
}