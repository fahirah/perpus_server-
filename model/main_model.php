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
		extract($this->prepare_get(array('cpagebk','kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		$cpagebk = floatval($cpagebk);
		//total halaman
		$tdph=20;
	
		if(empty($jenis)){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%'",true);
		}else if($jenis=="judul"){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where judul_buku like '%{$kata}%'",true);
		}else if($jenis=="pengarang"){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where pengarang_buku like '%{$kata}%'",true);
		}else if($jenis=="penerbit"){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where penerbit_buku like '%{$kata}%'",true);
		}
		
		$numpagebk=ceil($totalhalaman->hasil/$tdph);
		$start=$cpagebk*$tdph;
		$r=array();
		if(empty($jenis)){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where judul_buku like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where pengarang_buku like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where penerbit_buku like '%{$kata}%' limit $start,$tdph");
		}
		
		if(count($hasil)<=0)  return FALSE;
		else{
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
			return array(
				'data' => $r,
				'numpagebk' => $numpagebk
			);
		}
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
	
	public function view_prodi() {
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_prodi");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			
			$r[]=array(
				'kode'=>$d->kode_prodi,
				'nama'=>$d->nama_prodi,
			);
		}
		return $r;
	}
}

