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
		extract($this->prepare_get(array('cpage','kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		$cpage = floatval($cpage);
		//total halaman
		$tdph=20;
		if(empty($jenis)){
			$totalhalaman=$this->db->query("select count(id_anggota) as hasil from tbl_anggota where nama_anggota like '%{$kata}%' or id_anggota like '%{$kata}%' or no_identitas like '%{$kata}%' ",true);
		}else if($jenis=="no"){
			$totalhalaman=$this->db->query("select count(id_anggota) as hasil from tbl_anggota where no_identitas like '%{$kata}%' ",true);
		}else if($jenis=="id"){
			$totalhalaman=$this->db->query("select count(id_anggota) as hasil from tbl_anggota where id_anggota like '%{$kata}%' ",true);
		}else if($jenis=="nama"){
			$totalhalaman=$this->db->query("select count(id_anggota) as hasil from tbl_anggota where nama_anggota like '%{$kata}%' ",true);
		}
		$numpage=ceil($totalhalaman->hasil/$tdph);
		$start=$cpage*$tdph;
		
		$r=array();
		//$p=array();
		if(empty($jenis)){
			$hasil=$this->db->query("select * from tbl_anggota where nama_anggota like '%{$kata}%' or id_anggota like '%{$kata}%' or no_identitas like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="no"){
			$hasil=$this->db->query("select * from tbl_anggota where no_identitas like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="id"){
			$hasil=$this->db->query("select * from tbl_anggota where id_anggota like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="nama"){
			$hasil=$this->db->query("select * from tbl_anggota where nama_anggota like '%{$kata}%' limit $start,$tdph");
		}
		
		if(count($hasil)<=0)  return FALSE;
		else{
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
					'gender'=> $d->jeniskelamin_anggota,
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
	}	
	
	public function tambah_anggota(){
		extract($this->prepare_post(array('id','nama','identitas','alamat','telp','gender','status','prodi')));
		$nama=$this->db->escape_str($nama);
		$alamat=$this->db->escape_str($alamat);
		$gender=$this->db->escape_str($gender);
		$status=$this->db->escape_str($status);
		$id = floatval($id);
		$pw=md5($identitas);
		if (empty($id)) {
			$cek=$this->db->query("select max(id_anggota) as idan from tbl_anggota",true);
			$idan=$cek->idan;
			$idan++;
			//insert
			$ins=$this->db->query("insert into tbl_anggota VALUES('$idan','$prodi','$nama','$identitas','$alamat','$telp','$gender','$status','$pw')");
			
			generate_barcode($idan);
		} else {
			// edit
			$edit=$this->db->query("update tbl_anggota set nama_anggota='$nama', no_identitas='$identitas', alamat_anggota='$alamat',telp_anggota='$telp', jeniskelamin_anggota='$gender', status_anggota='$status', kode_prodi='$prodi',password_anggota='$pw' where id_anggota='$id'");
		}
		return $this->view_anggota();
	}
	
	public function delete_anggota($id){
		$id = floatval($id);
		$this->db->query("delete from tbl_anggota where id_anggota='$id'");
	}
	
	public function reset_password($id){
		$id = floatval($id);
		$ambilno=$this->db->query("select no_identitas from tbl_anggota where id_anggota='$id'",true);
		$no=md5($ambilno->no_identitas);
		$this->db->query("update tbl_anggota set password_anggota='$no' where id_anggota='$id'");
	}
}