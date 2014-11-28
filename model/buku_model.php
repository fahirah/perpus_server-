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
			return array(
			'data' => $r,
			'numpagebk' => $numpagebk
			);
		}
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
			$cek=$this->db->query("SELECT * FROM tbl_buku where kode_buku='$kode'");
			if(count($cek)>0)  return FALSE;
			else{
				$ins=$this->db->query("INSERT INTO tbl_buku VALUES(0,'$kode','$judul','$pengarang','$stok','$macam','$bahasa','$penempatan','$penerbit','$tahun')");
			}
		} else {
			// edit
			$edit=$this->db->query("update tbl_buku set kode_buku='$kode', judul_buku='$judul', pengarang_buku='$pengarang',stok_buku='$stok', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$penempatan', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun' where id_buku='$id'");
		}
		return $this->view_buku();
	}
	
	public function delete_buku($id){
		$id = floatval($id);
		$this->db->query("delete from tbl_buku where id_buku='$id'");
	}

}