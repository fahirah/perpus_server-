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
		extract($this->prepare_get(array('cpagepjm','status','tgl','noid','bulan', 'kdbuku', 'jdbuku')));
		$status=$this->db->escape_str($status);
		$noid=$this->db->escape_str($noid);
		$jdbuku=$this->db->escape_str($jdbuku);
		$cpagepjm = floatval($cpagepjm);
		//total halaman
		$tdph=20;

		$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman",true);
		if(!empty ($status)){
			$tgl="0000-00-00";
			if($status=="dipinjam"){
				$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where tgl_pengembalian='$tgl'",true);
			}else{
				$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where tgl_pengembalian!='$tgl'",true);
			}
		}else if(!empty($tgl)){
			$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where tgl_pinjam='$tgl'",true);
		}else if(!empty($bulan)){
			$thn=substr($bulan,0,4);
			$bln=substr($bulan,5,2);
			$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where MONTH(tgl_pinjam) ='$bln' and YEAR(tgl_pinjam)='$thn'",true);
		}else if(!empty($noid)){
			$ambilid=$this->db->query("select id_anggota from tbl_anggota where no_identitas='$noid'",true);
			$idan=$ambilid->id_anggota;
			$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where  id_anggota='$idan'",true);
		}else if(!empty($kdbuku)){
			$ambilid=$this->db->query("select id_buku from tbl_buku where kode_buku='$kdbuku'",true);
			$idbk=$ambilid->id_buku;
			$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where  id_buku='$idbk'",true);
		}else if(!empty($jdbuku)){
			$ambilid=$this->db->query("select id_buku from tbl_buku where judul_buku='$jdbuku'",true);
			$jdbk=$ambilid->id_buku;
			$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where id_buku='$jdbk'",true);
		}
		$jumlahpjm=$totalhalaman->hasil;
		$numpagepjm=ceil($jumlahpjm/$tdph);
		$start=$cpagepjm*$tdph;
		$r=array();
		
		$hasil=$this->db->query("select * from tbl_detail_peminjaman  limit $start,$tdph");
		if(!empty ($status)){
			$tgl="0000-00-00";
			if($status=="dipinjam"){
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pengembalian='$tgl' limit $start,$tdph");
			}else{
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pengembalian!='$tgl' limit $start,$tdph");
			}
		}else if(!empty($tgl)){
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pinjam='$tgl' limit $start,$tdph");
		}else if(!empty($bulan)){
			$thn=substr($bulan,0,4);
			$bln=substr($bulan,5,2);
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where MONTH(tgl_pinjam)='$bln' and YEAR(tgl_pinjam)='$thn' limit $start,$tdph");
		}else if(!empty($noid)){
			$ambilid=$this->db->query("select id_anggota from tbl_anggota where no_identitas='$noid'",true);
			$idan=$ambilid->id_anggota;
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_anggota='$idan' limit $start,$tdph");
		}else if(!empty($kdbuku)){
			$ambilid=$this->db->query("select id_buku from tbl_buku where kode_buku='$kdbuku'",true);
			$idbk=$ambilid->id_buku;
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$idbk' limit $start,$tdph");
		}else if(!empty($jdbuku)){
			$ambilid=$this->db->query("select id_buku from tbl_buku where judul_buku='$jdbuku'",true);
			$jdbk=$ambilid->id_buku;
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$jdbk' limit $start,$tdph");
		}

		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		
		if(count($hasil)<=0)  return FALSE;
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				$idang=$d->id_anggota;
				$ambilan=$this->db->query("select * from tbl_anggota where id_anggota='".$idang."'", true);
				$nama = $ambilan-> nama_anggota;
				$stts = $ambilan->status_anggota;
				$noid = $ambilan->no_identitas;
				
				$idbk=$d->id_buku;
				$ambilbk=$this->db->query("select judul_buku,kode_buku from tbl_buku where id_buku='".$idbk."'", true);
				$kode_buku = $ambilbk-> kode_buku;
				$judul = $ambilbk-> judul_buku;
			
				$id=$d->id_detail_peminjaman;
				$tgl=$d->tgl_kembali;	
				$tgl_pengembalian=$d->tgl_pengembalian;
					
				$ambilhr=$this->db->query("select datediff(now(), '$tgl') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$id'",true);
				$jum_hari=$ambilhr->jumlah;
					
				if($stts=='m'){
					if($tgl_pengembalian=='0000-00-00'){
						if($jum_hari>=0){
							$denda="Rp. ".($jum_hari*$bayar).",00";				
						}else{
							$denda="Rp. 0,00";
						}					
					}else{
						$denda="--";
					}
				}else{
					$denda="-";
				}
				
				$r[]=array(
					'kodedet'=>$id,
					'idang'=>$idang,
					'noid'=>$noid,
					'nmang'=>$nama,
					'id_buku'=>$idbk,
					'kd_buku'=>$kode_buku,
					'judul'=>$judul,
					'tgl_pinjam'=>datedb_to_tanggal($d->tgl_pinjam, 'd-F-Y'),
					'tgl_kembali'=>($d->tgl_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_kembali, 'd-F-Y')),
					'tgl_pengembalian' => ($d->tgl_pengembalian == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_pengembalian, 'd-F-Y')),
					'denda'=>$denda
				);
			}
			return array(
			'data' => $r,
			'jumlah' => $jumlahpjm,
			'numpagepjm' => $numpagepjm
			);
		}
	}	
		
	public function cek_anggota($id){
		$d=$this->db->query("select * from tbl_anggota where id_anggota='$id'",true);	
		if(! $d){
			$d2=$this->db->query("select * from tbl_anggota where no_identitas='$id'",true);
			if(! $d2) return FALSE;	
		}
		
		$ambiljum=$this->db->query("select count(id_detail_peminjaman) as jum from tbl_detail_peminjaman where id_anggota='$id' and tgl_pengembalian='0000-00-00'",true);
		$htg=$ambiljum->jum;
		
		$ambilpgtrn=$this->db->query("select * from tbl_pengaturan", true);
		$jumpjm=$ambilpgtrn->jumlah_buku;
		
		if($htg>=$jumpjm) return FALSE;
	}
	
	public function view_detilbuku($kode,$idan){
		$r=array();
		$cekang=$this->db->query("select id_anggota, status_anggota from tbl_anggota where id_anggota='$idan'", true);
		if(! $cekang){
			$d2=$this->db->query("select id_anggota, status_anggota FROM tbl_anggota where no_identitas='$idan'",true);
			$idan=$d2->id_anggota;	
			$status= $d2->status_anggota;
		}else{
			$status= $cekang->status_anggota;
		}
		
		$d=$this->db->query("select * from tbl_buku where kode_buku='$kode' and sisa_stok_buku!=0 ",true);
		
		if(! $d){
			$d=$this->db->query("select * from tbl_buku where isbn_buku='$kode' and sisa_stok_buku!=0 ",true);
			if(! $d)return FALSE;				
		}
			
		$ambilhr=$this->db->query("select lama_pinjam from tbl_pengaturan",true);
		$lama=floatval($ambilhr->lama_pinjam);
		if($status=="m"){
			$tgl_kembali=date('Y-m-d', time() + ($lama * 24 * 60 * 60));
		}else{
			$tgl_kembali='-';
		}
		
		return array(
			'id'=>$d->id_buku,
			'kode'=>$d->kode_buku,
			'judul'=>$d->judul_buku,
			'stok'=>$d->stok_buku,
			'tgl_pinjam'=>date('d-m-Y'),
			'tgl_kembali'=>$tgl_kembali
		);
	}
	
	public function tambah_peminjaman(){
		extract($this->prepare_post(array('anggota', 'buku', 'idp')));
			
		$cekang=$this->db->query("select id_anggota, status_anggota from tbl_anggota where id_anggota='$anggota'", true);
		if(! $cekang){
			$d2=$this->db->query("select id_anggota, status_anggota FROM tbl_anggota where no_identitas='$anggota'",true);
			$anggota=$d2->id_anggota;	
			$status= $d2->status_anggota;
		}else{
			$status= $cekang->status_anggota;
		}
		
		$ambilhr=$this->db->query("select lama_pinjam from tbl_pengaturan",true);
		$lama=floatval($ambilhr->lama_pinjam);
		$tgl_pinjam=date('Y-m-d');
		if($status=="m"){
			$tgl_kembali=date('Y-m-d', time() + ($lama * 24 * 60 * 60));
		}else{
			$tgl_kembali=0000-00-00;
		}
		
		foreach($buku as $key => $judul){
			$edit=$this->db->query("update tbl_buku set sisa_stok_buku = sisa_stok_buku - 1 where id_buku='$judul'");
			
			$ins2=$this->db->query("insert into tbl_detail_peminjaman VALUES(null, '$anggota', '$idp', '$judul','$tgl_pinjam', '$tgl_kembali', '', '')");
			
		}
		return $this->view_peminjaman();
	}
	
	public function perpanjang_pjm($kode, $kodebk){	
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$kode' and id_buku='$kodebk'",true);
		$lalu = datedb_to_tanggal($hasil->tgl_kembali, 'U');
		$tambah = date('Y-m-d', + ($lalu + (7 * 24 * 60 * 60)));
		$bxk=($hasil->banyak_perpanjang)+1;
		$edit=$this->db->query("update tbl_detail_peminjaman set tgl_kembali='$tambah', banyak_perpanjang='$bxk' where id_detail_peminjaman='$kode' and id_buku='$kodebk'");
	}

	public function kembali_pjm($idang, $kodebk){	
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_anggota='$idang' and id_buku='$kodebk'",true);
		$editbk=$this->db->query("update tbl_buku set sisa_stok_buku = sisa_stok_buku + 1 where id_buku='$kodebk'");
		$editpjm=$this->db->query("update tbl_detail_peminjaman set tgl_pengembalian=now() where id_anggota='$idang' and id_buku='$kodebk'");
	}
	
	public function delete_peminjaman($kode){
		$kode = floatval($kode);
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$kode'");
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$kodebk=$d->id_buku;
			$editbk=$this->db->query("update tbl_buku set sisa_stok_buku = sisa_stok_buku + 1 where id_buku='$kodebk'");
		}
		
		$this->db->query("delete from tbl_detail_peminjaman where id_detail_peminjaman='$kode'");
	}

}