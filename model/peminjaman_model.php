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
	
	public function tambah_peminjaman(){
		extract($this->prepare_post(array('anggota', 'buku', 'idp')));
		$cek=$this->db->query("select max(kode_peminjaman) as kdpj from tbl_peminjaman_pengembalian",true);
		$kdpjm=floatval($cek->kdpj)+1;
		
		$ins=$this->db->query("INSERT INTO tbl_peminjaman_pengembalian VALUES($kdpjm,'$anggota', '$idp','pinjam')");
		$tgl_pinjam=date('Y-m-d');
		$tgl_kembali=date('Y-m-d', time() + (7 * 24 * 60 * 60));
		
		foreach($buku as $key => $judul){
			$edit=$this->db->query("update tbl_buku set sisa_stok_buku = sisa_stok_buku - 1 where id_buku='$judul'");
			
			$ins2=$this->db->query("insert into tbl_detail_peminjaman VALUES(null, '$kdpjm', '$judul','$tgl_pinjam', '$tgl_kembali', '', '')");
			
		}
		return $this->view_peminjaman();
	}
	
	public function view_detilpjm($kode){
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_detail_peminjaman where kode_peminjaman='$kode'");
		
		if(! $hasil)  return FALSE;		
		
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
				
			$r[]=array(
				'id_buku'=>$d->id_buku,
				'tgl_pinjam'=>datedb_to_tanggal($d->tgl_pinjam, 'd-F-Y'),
				'tgl_kembali'=>datedb_to_tanggal($d->tgl_kembali, 'd-F-Y'),
				'tgl_pengembalian' => ($d->tgl_pengembalian == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_pengembalian, 'd-m-Y')),
				'denda'=>$d->denda
			);
		}
		
		return $r;
	}

}