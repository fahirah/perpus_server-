<?php
/**
 * Main Model
 */
namespace Model;

set_time_limit(0);

class MainModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_prodi() {
		$r=array();
		$hasil=$this->db->query("SELECT * FROM tbl_prodi");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			
			$r[]=array(
				'kode'=>$d->kode_prodi,
				'nama'=>$d->nama_prodi,
			);
		}
		return $r;
	}

	public function view_pencarian() {
		extract($this->prepare_get(array('cpagebk','cpagefl','judul','pengarang','penerbit','isbn','tipe')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$penerbit=$this->db->escape_str($penerbit);
		$tipe=$this->db->escape_str($tipe);
		$cpagebk = floatval($cpagebk);
		$cpagefl = floatval($cpagefl);
		//total halaman
		$tdph=20;
		
		$where = array();
		if ( ! empty($judul)) $where[] = "judul_buku like '%{$judul}%'";
		if ( ! empty($pengarang)) $where[] = "pengarang_buku like '%{$pengarang}%'";
		if ( ! empty($pengerbit)) $where[] = "penerbit_buku like '%{$penerbit}%'";
		if ( ! empty($isbn)) $where[] = "isbn_buku like '%{$isbn}%'";
		
		$sqlcount = "select count(id_buku) as hasil from tbl_buku";
		$sql = "SELECT * FROM tbl_buku";
		
		if ( ! empty($where)) {
			$sqlcount .= " WHERE " . implode(' OR ', $where);
			$sql .= " WHERE " . implode(' OR ', $where);
		}
		
		$totalhalaman=$this->db->query($sqlcount,true);
		
		$numpagebk=ceil($totalhalaman->hasil/$tdph);
		$start=$cpagebk*$tdph;
		$r=array();
		
		$hasil=$this->db->query($sql . " limit $start,$tdph");
		
		if(count($hasil)<=0)  return FALSE;
		else{
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				
				$r[]=array(
					'kode'=>$d->kode_buku,
					'isbn'=>$d->isbn_buku,
					'judul'=>$d->judul_buku,
					'pengarang'=>$d->pengarang_buku,
					'stok'=>$d->sisa_stok_buku,
					'macam'=>$d->macam_buku,
					'bahasa'=>$d->bahasa_buku,
					'penerbit'=>$d->penerbit_buku,
					'tahun'=>$d->tahun_terbit_buku
				);
			}
		}
		
		$wherefl = array();
		if ( ! empty($judul)) $wherefl[] = "judul_file like '%{$judul}%'";
		if ( ! empty($pengarang)) $wherefl[] = "pengarang_file like '%{$pengarang}%'";
		if ( ! empty($pengerbit)) $wherefl[] = "penerbit_file like '%{$penerbit}%'";
		
		$sqlcountfl = "select count(kode_file) as hasil from tbl_file";
		$sqlfl = "SELECT * FROM tbl_file";
		
		if ( ! empty($wherefl)) {
			$sqlcountfl .= " WHERE " . implode(' OR ', $wherefl);
			$sqlfl .= " WHERE " . implode(' OR ', $wherefl);
		}
	
		$totalhalamanfl=$this->db->query($sqlcountfl,true);
		
		$numpagefl=ceil($totalhalamanfl->hasil/$tdph);
		$start=$cpagefl*$tdph;
		$p=array();
		
		$hasilfl=$this->db->query($sqlfl . " limit $start,$tdph");
		
		if(count($hasil)<=0)  return FALSE;
		else{
			for($i=0; $i<count($hasilfl);$i++){
				$d=$hasilfl[$i];
				
				$p[]=array(
					'kode'=>$d->kode_file,
					'judul'=>$d->judul_file,
					'pengarang'=>$d->pengarang_file,
					'macam'=>$d->macam_file,
					'bahasa'=>$d->bahasa_file,
					'penerbit'=>$d->penerbit_file,
					'tahun'=>$d->tahun_terbit_file,
					'tgl'=>date('d-m-Y', strtotime($d->tgl_upload)),
					'ringkasan'=>$d->ringkasan
				);
			}
		}
		
		return array(
			'buku' => array(
				'data' => $r,
				'numpagebk' => $numpagebk
			),
			'file' => array(
				'data' => $p,
				'numpagefl' => $numpagefl
			)
		);
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
					'kode'=>$d->kode_buku,
					'judul'=>$d->judul_buku,
					'pengarang'=>$d->pengarang_buku,
					'stok'=>$d->sisa_stok_buku,
					'macam'=>$d->macam_buku,
					'bahasa'=>$d->bahasa_buku,
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
	
	public function view_file() {
		extract($this->prepare_get(array('cpagefl','kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		$cpagefl = floatval($cpagefl);
		//total halaman
		$tdph=20;
		
		if(empty($jenis)){
			$totalhalaman=$this->db->query("select count(kode_file) as hasil from tbl_file where judul_file like '%{$kata}%' or pengarang_file like '%{$kata}%' or penerbit_file like '%{kata}%' ",true);
		}else if($jenis=="judul"){
			$totalhalaman=$this->db->query("select count(kode_file) as hasil from tbl_file where judul_file like '%{$kata}%'",true);
		}else if($jenis=="pengarang"){
			$totalhalaman=$this->db->query("select count(kode_file) as hasil from tbl_file where pengarang_file like '%{$kata}%'",true);
		}else if($jenis=="penerbit"){
			$totalhalaman=$this->db->query("select count(kode_file) as hasil from tbl_file where penerbit_file like '%{$kata}%'",true);
		}
		
		$numpagefl=ceil($totalhalaman->hasil/$tdph);
		$start=$cpagefl*$tdph;
		$r=array();
		if(empty($jenis)){
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' or pengarang_file like '%{$kata}%' or penerbit_file like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where pengarang_file like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where penerbit_file like '%{$kata}%' limit $start,$tdph");
		}
		
		if(count($hasil)<=0) return FALSE;
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
			
				$r[]=array(
					'kode'=>$d->kode_file,
					'judul'=>$d->judul_file,
					'pengarang'=>$d->pengarang_file,
					'macam'=>$d->macam_file,
					'bahasa'=>$d->bahasa_file,
					'penerbit'=>$d->penerbit_file,
					'tahun'=>$d->tahun_terbit_file,
					'tgl'=>date('d-m-Y', strtotime($d->tgl_upload)),
					'ringkasan'=>$d->ringkasan
				);
			}
			return array(
				'data' => $r,
				'numpagefl' => $numpagefl
			);
		}
	}
	
	public function login() {
		extract($this->prepare_post(array('username','password','status')));
		
		$username=$this->db->escape_str($username);
		$password=$this->db->escape_str($password);
		
		//query ke database
		if($status==2){
			$hasil=$this->db->query("SELECT * from tbl_petugas where username='".$username."' and password_petugas='".$password."'",TRUE);
			$id = $hasil->id_petugas;
			if(count($hasil)<=0)  return FALSE;
			else return array(
				'token'=> crypt($username, $password),
				'id'=>$id,
				'status'=>2
			);
		}else if($status==1){
			$hasil=$this->db->query("SELECT * from tbl_anggota where no_identitas='".$username."' and password_anggota='".$password."'",TRUE);
			$id = $hasil->id_anggota;
			if(count($hasil)<=0)  return FALSE;
			else return array(
				'token'=> crypt($username, $password),
				'id'=>$id,
				'status'=>1,
				'level'=>$hasil->status_anggota
			);
		}else{
			return FALSE;
		}
	}
	
	public function download_file($id,$user,$iofiles){
		$ambilfile=$this->db->query("select nama_file from tbl_file where kode_file='$id'",true);
		$nama=$ambilfile->nama_file;
		
		$input=$this->db->query("insert into tbl_aktivitas values(null, '$id', '$id',now())");
		
		
		$iofiles->download($nama);
		
	}
	
	public function view_peminjaman($id) {		
		$r=array();
		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		
		$ambilkd=$this->db->query("select * from tbl_peminjaman_pengembalian where id_anggota='$id' and status_peminjaman='pinjam'");
		if(count($ambilkd)<=0) return FALSE;
		else{
			for($j=0;$j<count($ambilkd);$j++){
				$e=$ambilkd[$j];
				$kodepjm=$e->kode_peminjaman;
				$hasil=$this->db->query("SELECT * FROM tbl_detail_peminjaman where kode_peminjaman='$kodepjm'");
				for($i=0; $i<count($hasil);$i++){
					$d=$hasil[$i];
					
					$idbuku=$d->id_buku;
					$ambilbk=$this->db->query("select kode_buku,judul_buku from tbl_buku where id_buku='$idbuku'",true);
					$kdbuku=$ambilbk->kode_buku;
					$judul=$ambilbk->judul_buku;
					
					$tglkembali=$d->tgl_kembali;	
					$tgl_pengembalian=$d->tgl_pengembalian;	
					$iddetail=$d->id_detail_peminjaman;
					$ambilhr=$this->db->query("select datediff(now(), '$tglkembali') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$id'",true);
					$jum_hari=$ambilhr->jumlah;
					if($tgl_pengembalian=='0000-00-00'){
						if($jum_hari>=0){
							$denda="Rp. ".($jum_hari*$bayar).",00";				
						}else{
							$denda="Rp. 0,00";
						}					
					}else{
						$denda='-';
					}
			
					$r[]=array(
						'idbuku'=>$kdbuku,
						'judul'=>$judul,
						'tgl_pinjam'=>datedb_to_tanggal($d->tgl_pinjam, 'd-F-Y'),
						'tgl_kembali'=>datedb_to_tanggal($d->tgl_kembali, 'd-F-Y'),
						'denda'=>$denda
					);
				}
				return $r;
			}
		}
	}

}

