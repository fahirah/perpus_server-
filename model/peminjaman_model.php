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
	
		$totalhalaman=$this->db->query("select count(kode_peminjaman) as hasil from tbl_peminjaman_pengembalian where id_anggota like '%{$kata}%'",true);
				
		$numpagepjm=ceil($totalhalaman->hasil/$tdph);
		$start=$cpagepjm*$tdph;
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_peminjaman_pengembalian where id_anggota like '%{$kata}%' limit $start,$tdph");
		
		if(count($hasil)<=0)  return FALSE;
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				$idang=$d->id_anggota;
				$ambilan=$this->db->query("SELECT * from tbl_anggota where id_anggota='".$idang."'", true);
				$nama = $ambilan-> nama_anggota;
				
				$r[]=array(
					'kode'=>$d->kode_peminjaman,
					'idang'=>$idang,
					'nmang'=>$nama
				);
			}
			return array(
			'data' => $r,
			'numpagepjm' => $numpagepjm
			);
		}
	}	
		
	public function cek_anggota($id){
		$d=$this->db->query("SELECT * FROM tbl_anggota where id_anggota='$id'",true);		
		if(! $d)  return FALSE;				
		
		$ambilkdp=$this->db->query("select * from tbl_peminjaman_pengembalian where id_anggota='$id' and status_peminjaman='pinjam'");
		$htg=0;
		if(count($ambilkdp)>0){
			for($i=0;$i<count($ambilkdp);$i++){
				$h=$ambilkdp[$i];
				$kodep=$h->kode_peminjaman;
				$ambiljum=$this->db->query("select count(id_detail_peminjaman) as jum from tbl_detail_peminjaman where kode_peminjaman='$kodep'",true);
				$jum=$ambiljum->jum;
				$htg+=$jum;
			}
		}
		$ambilpgtrn=$this->db->query("select * from tbl_pengaturan", true);
		$jumpjm=$ambilpgtrn->jumlah_buku;
		if($htg>$jumpjm) return FALSE;
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
		
		$ambilan=$this->db->query("SELECT * FROM tbl_peminjaman_pengembalian where kode_peminjaman='$kode'",true);
		$idan=$ambilan->id_anggota;
		$ambilan=$this->db->query("SELECT * from tbl_anggota where id_anggota='".$idan."'", TRUE);
		$nama = $ambilan-> nama_anggota;
		$stts = $ambilan->status_anggota;
		
		$hasil=$this->db->query("SELECT * FROM tbl_detail_peminjaman where kode_peminjaman='$kode'");
	
		if(! $hasil)  return FALSE;		
		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
				
			$idbk=$d->id_buku;
			$ambilbk=$this->db->query("SELECT * from tbl_buku where id_buku='".$idbk."'", TRUE);
			$kode_buku = $ambilbk-> kode_buku;
			$judul = $ambilbk->judul_buku;
			$id=$d->id_detail_peminjaman;
			$tgl=$d->tgl_kembali;	
			$tgl_pengembalian=$d->tgl_pengembalian;
			$ambilhr=$this->db->query("select datediff(now(), '$tgl') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$id'",true);
			$jum_hari=$ambilhr->jumlah;
			if($stts=='mahasiswa'){
				if($tgl_pengembalian=='0000-00-00'){
					if($jum_hari>=0){
						$denda="Rp. ".($jum_hari*$bayar).",00";				
					}else{
						$denda="Rp. 0,00";
					}					
				}else{
					$denda="-";
				}
			}else{
				$denda="-";
			}
			$r[]=array(
				'id_buku'=>$d->id_buku,
				'kd_buku'=>$kode_buku,
				'judul'=>$judul,
				'tgl_pinjam'=>datedb_to_tanggal($d->tgl_pinjam, 'd-F-Y'),
				'tgl_kembali'=>datedb_to_tanggal($d->tgl_kembali, 'd-F-Y'),
				'tgl_pengembalian' => ($d->tgl_pengembalian == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_pengembalian, 'd-m-Y')),
				'denda'=>$denda
			);
		}
		
		//return $r;
		return array(
			'kode_pinjam' => $kode,
			'id_anggota' => $idan,
			'nama_anggota' => $nama,
			'data' =>$r
		);
	}
	
	public function perpanjang_pjm($kodepjm, $kodebk){		
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where kode_peminjaman='$kodepjm' and id_buku='$kodebk'",true);
		$lalu = datedb_to_tanggal($hasil->tgl_kembali, 'U');
		$tambah = date('Y-m-d', + ($lalu + (7 * 24 * 60 * 60)));
		$bxk=($hasil->banyak_perpanjang)+1;
		$edit=$this->db->query("update tbl_detail_peminjaman set tgl_kembali='$tambah', banyak_perpanjang='$bxk' where kode_peminjaman='$kodepjm' and id_buku='$kodebk'");
	}

	public function kembali_pjm($kodepjm, $kodebk){		
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where kode_peminjaman='$kodepjm' and id_buku='$kodebk'",true);
		$editbk=$this->db->query("update tbl_buku set sisa_stok_buku = sisa_stok_buku + 1 where id_buku='$kodebk'");
		$editpjm=$this->db->query("update tbl_detail_peminjaman set tgl_pengembalian=now() where kode_peminjaman='$kodepjm' and id_buku='$kodebk'");
		
		$ambiltgl=$this->db->query("select * from tbl_detail_peminjaman where kode_peminjaman='$kodepjm'");
		$htg=0;
	
		$jumlah=count($ambiltgl);
		for($i=0;$i<$jumlah;$i++){
			$d=$ambiltgl[$i];
			if($d->tgl_pengembalian != '0000-00-00') $htg++;
		}
		if($htg==$jumlah){
			$editstts=$this->db->query("update tbl_peminjaman_pengembalian set status_peminjaman='kembali' where kode_peminjaman='$kodepjm'");
		}
	}
	
	public function delete_peminjaman($kode){
		$kode = floatval($kode);
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where kode_peminjaman='$kode'");
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$kodebk=$d->id_buku;
			$editbk=$this->db->query("update tbl_buku set sisa_stok_buku = sisa_stok_buku + 1 where id_buku='$kodebk'");
		}
		
		$this->db->query("delete from tbl_detail_peminjaman where kode_peminjaman='$kode'");
		$this->db->query("delete from tbl_peminjaman_pengembalian where kode_peminjaman='$kode'");
	}

}