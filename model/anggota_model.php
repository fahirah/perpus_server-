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
		extract($this->prepare_get(array('cpage','kata')));
		$kata=$this->db->escape_str($kata);
		$cpage = floatval($cpage);
		//total halaman
		$tdph=20;
		$totalhalaman=$this->db->query("select count(id_anggota) as hasil from tbl_anggota where nama_anggota like '%{$kata}%' ",true);
		$numpage=ceil($totalhalaman->hasil/$tdph);
		$start=$cpage*$tdph;
		
		$r=array();
		//$p=array();
		
		$hasil=$this->db->query("SELECT * FROM tbl_anggota where nama_anggota like '%{$kata}%' limit $start,$tdph");
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
				'jk'=> ($d->jeniskelamin_anggota == 'P' ? 'Perempuan' : 'Laki-laki'),
				'gender' => $d->jeniskelamin_anggota,
				'level'=>($d->status_anggota == 'm' ? 'Mahasiswa' : 'Dosen'),
				'status'=> $d->status_anggota,
				'prodi'=>$kd,
				'kd'=>$prodi
			);
			//nama:'',identitas:'',alamat:'', telp:'', gender:'L', status:'m', prodi:''
		}
		
		return array(
			'data' => $r,
			'numpage' => $numpage
		);
	}	
	
	public function tambah_anggota(){
		extract($this->prepare_post(array('id','nama','identitas','alamat','telp','gender','status','prodi')));
		$nama=$this->db->escape_str($nama);
		$alamat=$this->db->escape_str($alamat);
		$gender=$this->db->escape_str($gender);
		$status=$this->db->escape_str($status);
		$id = floatval($id);
		
		if (empty($id)) {
			//insert
			$ins=$this->db->query("INSERT INTO tbl_anggota VALUES(0,'$nama','$identitas','$alamat','$telp','$gender','$status','$prodi','$identitas')");
		} else {
			// edit
			$edit=$this->db->query("update tbl_anggota set nama_anggota='$nama', no_identitas='$identitas', alamat_anggota='$alamat',telp_anggota='$telp', jeniskelamin_anggota='$gender', status_anggota='$status', kode_prodi='$prodi' where id_anggota='$id'");
		}
		return $this->view_anggota();
	}
	
	public function delete_anggota($id){
		$id = floatval($id);
		$this->db->query("delete from tbl_anggota where id_anggota='$id'");
	}
}