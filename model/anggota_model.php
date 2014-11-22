<?php
/**
 * Anggota Model
 */
namespace Model;

class AnggotaModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_anggota() {
		$r=array();
		//$p=array();
		
		$hasil=$this->db->query("SELECT * FROM tbl_anggota");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			$kd=$d->kode_prodi;
			$ambilkd=$this->db->query("SELECT * from tbl_prodi where kode_prodi='".$kd."'", TRUE);
			$prodi = $ambilkd->nama_prodi;
			
			$r[]=array(
				'id'=>$d->id_anggota,
				'nama'=>$d->nama_anggota,
				'identitas'=>$d->no_identitas,
				'alamat'=>$d->alamat_anggota,
				'telp'=>$d->telp_anggota,
				'gender'=>$d->jeniskelamin_anggota,
				'status'=>$d->status_anggota,
				'kd'=>$prodi
			);
		}
		
		/*$ambilprodi=$this->db->query("SELECT * FROM tbl_prodi");
		for($i=0; $i<count($ambilprodi);$i++){
			$d=$ambilprodi[$i];
			$p[]=array(
				'kode'=>$d->kode_prodi;
				'prodi'=>$d->nama_prodi;
			);
		} */
		
	/*	return array(
		  'anggota' => $r,
		  'prodi' => $p
		);*/
		return $r;
	}	
	
	public function tambah_anggota(){
		extract($this->prepare_post(array('nama','identitas','alamat','telp','gender','status','prodi')));
		$nama=$this->db->escape_str($nama);
		$alamat=$this->db->escape_str($alamat);
		$gender=$this->db->escape_str($gender);
		$status=$this->db->escape_str($status);
		
		//insert
		$ins=$this->db->query("INSERT INTO tbl_anggota VALUES(0,'$nama','$identitas','$alamat','$telp','$gender','$status','$kd','$identitas')");
		
		return $this->view_anggota();
	}
}