<?php
/**
 * Pengaturan Model
 */
namespace Model;

class PengaturanModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_pengaturan() {
		extract($this->prepare_get(array('id')));
		$r=array();
		$p=array();
		$q=array();
		$s=array();
		$d=$this->db->query("select * from tbl_pengaturan ",true);
		
		$r=array(
			'kode'=>$d->kode_pengaturan,
			'denda'=>$d->bayar_denda,
			'jumlah'=>$d->jumlah_buku,
			'lama'=> $d->lama_pinjam
		);
		
		$ambilprodi=$this->db->query("select * from tbl_prodi");
		if(count($ambilprodi)>0){
			for($i=0;$i<count($ambilprodi);$i++){
				$e=$ambilprodi[$i];
				$p[]=array(
					'kodepr'=>$e->kode_prodi,
					'namapr'=>$e->nama_prodi
				);
			}
		}
		if(!empty($id)){
			$ambilpt=$this->db->query("select * from tbl_petugas where id_petugas='$id'",true);
			
			$q=array(
				'id'=>$ambilpt->id_petugas,
				'nama'=>$ambilpt->nama_petugas,
				'un'=>$ambilpt->username,
				'jk'=>$ambilpt->jeniskelamin_petugas,
				'gender'=>($ambilpt->jeniskelamin_petugas == 'P' ? 'Perempuan' : 'Laki-laki'),
				'telp'=>$ambilpt->telp_petugas
			);
				
		}
		$ambiladmin=$this->db->query("select * from tbl_petugas where id_petugas!='$id'");
		if(count($ambiladmin)>0){
			for($i=0;$i<count($ambiladmin);$i++){
				$f=$ambiladmin[$i];
				$s[]=array(
					'idad'=>$f->id_petugas,
					'nama'=>$f->nama_petugas,
					'gender'=>($f->jeniskelamin_petugas == 'P' ? 'Perempuan' : 'Laki-laki'),
					'jk'=>$f->jeniskelamin_petugas,
					'telp'=>$f->telp_petugas,
					'un'=>$f->username
				);
			}
		}
		return array(
			'data' => $r,
			'datapr'=>$p,
			'datapt'=>$q,
			'dataad'=>$s
			
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
	
	public function tambah_prodi(){
		extract($this->prepare_post(array('kodepr','namapr')));
		$nama=$this->db->escape_str($namapr);
		$id = floatval($kodepr);
		
		if (empty($id)) {
			//insert
			$ins=$this->db->query("INSERT INTO tbl_prodi VALUES(0,'$nama')");
		} else {
			// edit
			$edit=$this->db->query("update tbl_prodi set nama_prodi='$nama' where kode_prodi='$id'");
		}
		return $this->view_pengaturan();
	}
	
	public function delete_prodi($kd){
		$id = floatval($kd);
		$this->db->query("delete from tbl_prodi where kode_prodi='$id'");
		return $this->view_pengaturan();
	}
	
	public function ubah_pengaturanakun(){
		extract($this->prepare_post(array('id','nama','jk','telp', 'un','pw')));
		$idp = floatval($id);
		$nama=$this->db->escape_str($nama);
		$jk=$this->db->escape_str($jk);
		$un=$this->db->escape_str($un);
	
		//edit
		$edit=$this->db->query("update tbl_petugas set nama_petugas='$nama', jeniskelamin_petugas='$jk', telp_petugas='$telp', username='$un' where id_petugas='$idp'");
		
		if(!empty($pw)){
			$pw=md5($pw);
			$edit2=$this->db->query("update tbl_petugas set password_petugas='$pw' where id_petugas='$idp'");
		}
		return $this->view_pengaturan();
	}
	
	public function tambah_petugas(){
		extract($this->prepare_post(array('idad','nama', 'jk', 'telp', 'un')));
		$nama=$this->db->escape_str($nama);
		$un=$this->db->escape_str($un);
		$id = floatval($idad);
		
		if (empty($id)) {
			//insert
			$pw=md5($un);
			$ins=$this->db->query("INSERT INTO tbl_petugas VALUES(0,'$nama', '$jk', '$telp', '$un', '$pw')");
		} else {
			// edit
			$pw=md5($un);
			$edit=$this->db->query("update tbl_petugas set nama_petugas='$nama', jeniskelamin_petugas='$jk', telp_petugas='$telp', username='$un', password_petugas='$pw' where id_petugas='$id'");
		}
		return $this->view_pengaturan();
	}
	
	public function delete_petugas($kd){
		$id = floatval($kd);
		$this->db->query("delete from tbl_petugas where id_petugas='$id'");
		return $this->view_pengaturan();
	}
	
	public function reset_password($id){
		$id = floatval($id);
		$ambilno=$this->db->query("select username from tbl_petugas where id_petugas='$id'",true);
		$no=md5($ambilno->username);
		$this->db->query("update tbl_petugas set password_petugas='$no' where id_petugas='$id'");
	}
}