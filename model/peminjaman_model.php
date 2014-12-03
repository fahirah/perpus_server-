<?php
/**
 * Peminjaman Model
 */
namespace Model;

class PeminjamanModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_peminjaman() {
		extract($this->prepare_get(array('cpagepjm','kata')));
		$kata=$this->db->escape_str($kata);
		$cpagepjm = floatval($cpagepjm);
		//total halaman
		$tdph=20;
	
		$totalhalaman=$this->db->query("select count(kode_peminjaman) as hasil from tbl_peminjaman_pengembalian",true);
				
		$numpagepjm=ceil($totalhalaman->hasil/$tdph);
		$start=$cpagepjm*$tdph;
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_peminjaman_pengembalian limit $start,$tdph");
		
		if(count($hasil)<=0)  return FALSE;
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				
				$r[]=array(
					'kode'=>$d->kode_peminjaman,
					'idang'=>$d->id_anggota,
				);
			}
			return array(
			'data' => $r,
			'numpagepjm' => $numpagepjm
			);
		}
	}	
		
	public function view_detilbuku($kode){
		$r=array();
		$d=$this->db->query("SELECT * FROM tbl_buku where kode_buku='$kode' and sisa_stok_buku!=0 ",true);
		
		if(! $d)  return FALSE;				
		
		return array(
			'id'=>$d->id_buku,
			'kode'=>$d->kode_buku,
			'judul'=>$d->judul_buku,
			'stok'=>$d->stok_buku,
			'tgl_pinjam'=>date('d-m-Y'),
			'tgl_kembali'=>date('d-m-Y', time() + (7 * 24 * 60 * 60))
		);
	}

}