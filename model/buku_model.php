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
				'id'=>$d->id_buku,
				'kode'=>$d->kode_buku,
				'judul'=>$d->judul_buku,
				'pengarang'=>$d->pengarang_buku,
				'stok'=>$d->stok_buku,
				'macam'=>$d->macam_buku,
				'bahasa'=>$d->bahasa_buku,
				'penempatan'=>$d->no_penempatan,
				'penerbit'=>$d->penerbit_buku,
				'tahun'=>$d->tahun_terbit_buku
			);
		}
		return $r;
	}	
	
	public function tambah_buku(){
		extract($this->prepare_post(array('id', 'kode', 'judul', 'pengarang', 'stok', 'macam', 'bahasa', 'penempatan', 'penerbit', 'tahun')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$macam=$this->db->escape_str($macam);
		$bahasa=$this->db->escape_str($bahasa);
		$penerbit=$this->db->escape_str($penerbit);
		$id = floatval($id);
		
		if (empty($id)) {
			//insert
			$ins=$this->db->query("INSERT INTO tbl_buku VALUES(0,'$kode','$judul','$pengarang','$stok','$macam','$bahasa','$penempatan','$penerbit','$tahun')");
		} else {
			// edit
			$edit=$this->db->query("update tbl_buku set kode_buku='$kode', judul_buku='$judul', pengarang_buku='$pengarang',stok_buku='$stok', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$penempatan', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun' where id_buku='$id'");
			echo $this->db->get_error();
			return;
		}
		return $this->view_buku();
	}

}