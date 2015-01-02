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
			}else if($status=="dikembalikan"){
				$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where tgl_pengembalian!='$tgl'",true);
			}else if($status=="terlambat"){
				$totalhalaman=$this->db->query("select count(id_detail_peminjaman) as hasil from tbl_detail_peminjaman where tgl_kembali < curdate() and tgl_pengembalian='$tgl'",true);
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
			}else if($status=="dikembalikan"){
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pengembalian!='$tgl' limit $start,$tdph");
			}else if($status=="terlambat"){
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_kembali < curdate() and tgl_pengembalian='$tgl' limit $start,$tdph");
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
	
	public function cek_jumlah($idan,$banyak){
		$banyak=floatval($banyak)+1;
		$ambiljum=$this->db->query("select count(id_detail_peminjaman) as jum from tbl_detail_peminjaman where id_anggota='$idan' and tgl_pengembalian='0000-00-00'",true);
		$htg=$ambiljum->jum;
		
		$ambilpgtrn=$this->db->query("select * from tbl_pengaturan", true);
		$jumpjm=$ambilpgtrn->jumlah_buku;
		$total=$banyak+$htg;
		//echo "banyak= ".$banyak." htg=".$htg." total=".$total." jumpjm=".$jumpjm;
		//return;
		
		if($total>$jumpjm) return FALSE;
	}
	
	public function view_detilbuku($kode,$idan){
		
		$r=array();
		$cekang=$this->db->query("select id_anggota, status_anggota from tbl_anggota where id_anggota='$idan'", true);
		if(! $cekang){
			$d2=$this->db->query("select id_anggota, status_anggota from tbl_anggota where no_identitas='$idan'",true);
			$idan=$d2->id_anggota;	
			$status= $d2->status_anggota;
		}else{
			$status= $cekang->status_anggota;
		}	
		
		$d=$this->db->query("select * from tbl_buku where kode_buku='$kode'",true);
		if(! $d){
			return FALSE;	
		}else{
			$idbk=$d->id_buku;
			$e=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$idbk' and tgl_pengembalian='0000-00-00'");
			if($e) return FALSE;
			
		}
			
		$ambilhr=$this->db->query("select lama_pinjam from tbl_pengaturan",true);
		$lama=floatval($ambilhr->lama_pinjam);
		if($status=="m"){
			$tgl_kembali=date('d-m-Y', time() + ($lama * 24 * 60 * 60));
		}else{
			$tgl_kembali='-';
		}
		
		return array(
			'id'=>$d->id_buku,
			'kode'=>$d->kode_buku,
			'judul'=>$d->judul_buku,
			'tgl_pinjam'=>date('d-m-Y'),
			'tgl_kembali'=>$tgl_kembali
		);
	}
	
	public function tambah_peminjaman(){
		extract($this->prepare_post(array('anggota', 'buku', 'idp')));
			
		$cekang=$this->db->query("select id_anggota, status_anggota from tbl_anggota where id_anggota='$anggota'", true);
		if(! $cekang){
			$d2=$this->db->query("select id_anggota, status_anggota from tbl_anggota where no_identitas='$anggota'",true);
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
			$ins2=$this->db->query("insert into tbl_detail_peminjaman VALUES(null, '$anggota', '$idp', '$judul','$tgl_pinjam', '$tgl_kembali', '', '')");
			
		}
		return $this->view_peminjaman();
	}
	
	public function perpanjang_pjm($kode, $kodebk){	
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$kode' and id_buku='$kodebk'",true);
		$tgl_kmbl=$hasil->tgl_kembali;
		$tgl_pjm=$hasil->tgl_pinjam;
		$idang=$hasil->id_anggota;
		$ambilan=$this->db->query("select * from tbl_anggota where id_anggota='".$idang."'", true);
		$stts = $ambilan->status_anggota;
		
		$lalu = datedb_to_tanggal($hasil->tgl_kembali, 'U');
		$tambah = date('Y-m-d', + ($lalu + (7 * 24 * 60 * 60)));
		$bxk=($hasil->banyak_perpanjang)+1;
		$edit=$this->db->query("update tbl_detail_peminjaman set tgl_kembali='$tambah', banyak_perpanjang='$bxk' where id_detail_peminjaman='$kode' and id_buku='$kodebk'");
		
		$ambilhr=$this->db->query("select datediff(now(), '$tgl_kmbl') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$kode'",true);
		$jum_hari=$ambilhr->jumlah;
		
		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		
		if($stts=='m'){
			if($jum_hari>=0){
				$denda=$jum_hari*$bayar;
				$input=$this->db->query("insert into tbl_denda values(null, '$kode', '$tgl_pjm', '$tgl_kmbl', now(), '$denda')");
			}				
		}	
		
	}

	public function kembali_pjm($kodepjm, $kodebk){	
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$kodepjm' and id_buku='$kodebk'",true);
		$idang=$hasil->id_anggota;
		$tgl_kmbl=$hasil->tgl_kembali;
		$tgl_pjm=$hasil->tgl_pinjam;
	
		$ambilan=$this->db->query("select * from tbl_anggota where id_anggota='".$idang."'", true);
		$stts = $ambilan->status_anggota;
			
		$ambilhr=$this->db->query("select datediff(now(), '$tgl_kmbl') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$kodepjm'",true);
		$jum_hari=$ambilhr->jumlah;
		
		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		
		if($stts=='m'){
			if($jum_hari>=0){
				$denda=$jum_hari*$bayar;
				$input=$this->db->query("insert into tbl_denda values(null, '$kodepjm', '$tgl_pjm', '$tgl_kmbl', now(), '$denda')");
			}				
		}	
			
		$editpjm=$this->db->query("update tbl_detail_peminjaman set tgl_pengembalian=now() where id_anggota='$idang' and id_buku='$kodebk'");
	}
	
	public function delete_peminjaman($kode){
		$kode = floatval($kode);
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$kode'");
		
		$this->db->query("delete from tbl_detail_peminjaman where id_detail_peminjaman='$kode'");
	}
	
	public function view_kas() {
		extract($this->prepare_get(array('cpagekas','tgl','bulan','tahun')));
		$cpagekas = floatval($cpagekas);
		//total halaman
		$tdph=20;

		$totalhalaman=$this->db->query("select count(kode_denda) as hasil from tbl_denda",true);
		if(!empty($tgl)){
			$totalhalaman=$this->db->query("select count(kode_denda) as hasil from tbl_denda where tanggal_bayar='$tgl'",true);
		}else if(!empty($bulan)){
			$thn=substr($bulan,0,4);
			$bln=substr($bulan,5,2);
			$totalhalaman=$this->db->query("select count(kode_denda) as hasil from tbl_denda where MONTH(tanggal_bayar) ='$bln' and YEAR(tanggal_bayar)='$thn'",true);
		}else if(!empty($tahun)){
			$totalhalaman=$this->db->query("select count(kode_denda) as hasil from tbl_denda where YEAR(tanggal_bayar) ='$tahun'",true);
		}
		$total_denda=0;
		$jumlah=$totalhalaman->hasil;
		$numpagekas=ceil($jumlah/$tdph);
		$start=$cpagekas*$tdph;
		$r=array();
		
		$hasil=$this->db->query("select * from tbl_denda order by tanggal_bayar limit $start,$tdph");
		if(!empty($tgl)){
			$hasil=$this->db->query("select * from tbl_denda where tanggal_bayar='$tgl' order by tanggal_bayar limit $start,$tdph");
		}else if(!empty($bulan)){
			$thn=substr($bulan,0,4);
			$bln=substr($bulan,5,2);
			$hasil=$this->db->query("select * from tbl_denda where MONTH(tanggal_bayar)='$bln' and YEAR(tanggal_bayar)='$thn' order by tanggal_bayar limit $start,$tdph");
		}else if(!empty($tahun)){
			$hasil=$this->db->query("select * from tbl_denda where YEAR(tanggal_bayar)='$tahun' order by tanggal_bayar limit $start,$tdph");
		}

		if(count($hasil)<=0)  return FALSE;
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				$iddet=$d->id_detail_peminjaman;
				$ambildet=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$iddet'",true);
				$idang=$ambildet->id_anggota;
				
				$ambilan=$this->db->query("select * from tbl_anggota where id_anggota='".$idang."'", true);
				$nama = $ambilan-> nama_anggota;
				$noid = $ambilan->no_identitas;
				
				//$ambilhr=$this->db->query("select datediff('$tgl_pengembalian', '$tgl') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$iddet'",true);
				$denda=$d->denda;
				$total_denda+=$denda;
				
				$r[]=array(
					'kodedenda'=>$d->kode_denda,
					'iddet'=>$iddet,
					'idang'=>$idang,
					'noid'=>$noid,
					'nmang'=>$nama,
					'tgl_pinjam'=>datedb_to_tanggal($ambildet->tgl_pinjam, 'd-F-Y'),
					'tgl_kembali'=>($d->tanggal_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($d->tanggal_kembali, 'd-F-Y')),
					'tgl_bayar' => ($d->tanggal_bayar == '0000-00-00' ? '-' : datedb_to_tanggal($d->tanggal_bayar, 'd-F-Y')),
					'denda'=>$denda
				);
			}
			return array(
				'data' => $r,
				'total' => $total_denda,
				//'jumlah' => $jumlah,
				'numpagekas' => $numpagekas
			);
		}
	}

}