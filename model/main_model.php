<?php
/**
 * Main Model
 */
namespace Model;

set_time_limit(0);

class MainModel extends ModelBase {
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
	
	public function view_file() {
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_file");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			
			$r[]=array(
				'kode'=>$d->kode_file,
				'judul'=>$d->judul_file,
				'pengarang'=>$d->pengarang_file,
				'macam'=>$d->macam_file,
				'bahasa'=>$d->bahasa_file,
				'penerbit'=>$d->penerbit_file,
				'tahun'=>$d->tahun_terbit_file,
				'tgl'=>$d->tgl_upload,
				'ringkasan'=>$d->ringkasan
			);
		}
		return $r;
	}
	
	public function login() {
		extract($this->prepare_post(array('username','password','status')));
		
		$username=$this->db->escape_str($username);
		$password=$this->db->escape_str($password);
		
		//query ke database
	if($status==2){
		$hasil=$this->db->query("SELECT * from tbl_petugas where username='".$username."' and password_petugas='".$password."'",TRUE);
		$id = $hasil->id_petugas;
		if(count($hasil)<=0)  return FALSE;
		else return array(
			'token'=> crypt($username, $password),
			'id'=>$id,
			'status'=>2
		);
	}else if($status==1){
		$hasil=$this->db->query("SELECT * from tbl_anggota where no_identitas='".$username."' and password_anggota='".$password."'",TRUE);
		$id = $hasil->id_anggota;
		if(count($hasil)<=0)  return FALSE;
		else return array(
			'token'=> crypt($username, $password),
			'id'=>$id,
			'status'=>1
		);
	}
	else{
		return FALSE;
	}
	}	
}

