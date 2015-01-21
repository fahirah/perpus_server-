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
	
	private function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '. @$sz[$factor];
	}
	
	public function view_pencarian($iofiles) {
		extract($this->prepare_get(array('cpagebk','cpagefl','judul','pengarang','penerbit','isbn','tipe')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$penerbit=$this->db->escape_str($penerbit);
		$tipe=$this->db->escape_str($tipe);
		$cpagebk = floatval($cpagebk);
		$cpagefl = floatval($cpagefl);
		//total halaman
		$tdph=10;
		$r=array();
		$p=array();
		$numpagefl=0;
		$numpagebk=0;
		
		if(empty($tipe)){
			$numpagebk=1;
			$hasil=$this->db->query("select * from tbl_buku order by rand() limit 2");
			
			if(count($hasil)<=0)  return FALSE;
			else{
				for($i=0; $i<count($hasil);$i++){
					$d=$hasil[$i];
					$isbn=$d->isbn_buku;
					$judul=$d->judul_buku;
					$pengarang=$d->pengarang_buku;
					$penerbit=$d->penerbit_buku;
					$tahun=$d->tahun_terbit_buku;
					
					$pnmptn=$d->no_penempatan;
					$b=strlen($pnmptn);
					$c=$b-4;
					$ddc=substr($pnmptn,0,$c);
					$ambil=$this->db->query("select count(id_buku) as jumlah from tbl_buku where substr(no_penempatan, 1,$c)='$ddc' and isbn_buku='$isbn' and judul_buku='$judul' and pengarang_buku='$pengarang' and penerbit_buku='$penerbit' and tahun_terbit_buku='$tahun'",true);
					$jumlah=$ambil->jumlah;
				
				
					$r[]=array(
						'id'=>$d->id_buku,
						'isbn'=>$d->isbn_buku,
						'judul'=>$d->judul_buku,
						'sampul'=>$d->sampul_buku,
						'penempatan'=>$ddc,
						'pengarang'=>$d->pengarang_buku,
						'macam'=>$d->macam_buku,
						'bahasa'=>$d->bahasa_buku,
						'penerbit'=>$d->penerbit_buku,
						'tahun'=>$d->tahun_terbit_buku
					);
				}
			}
			
			$numpagefl=1;
			$hasilfl=$this->db->query("select * from tbl_file order by rand() limit 2");
			
			if(count($hasilfl)<=0)  return FALSE;
			else{
				for($i=0; $i<count($hasilfl);$i++){
					$d=$hasilfl[$i];
					$nama=$d->nama_file;
					$attr=$iofiles->get_attrib($nama);
					$p[]=array(
						'kode'=>$d->kode_file,
						'judul'=>$d->judul_file,
						'sampul'=>$d->sampul_file,
						'ukuran'=>$this->human_filesize($attr['size']).'B',
						'tipe'=>$attr['type'],
						'pengarang'=>$d->pengarang_file,
						'macam'=>$d->macam_file,
						'bahasa'=>$d->bahasa_file,
						'penerbit'=>$d->penerbit_file,
						'tahun'=>$d->tahun_terbit_file,
						'tgl'=>($d->tgl_upload == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_upload, 'd-F-Y')),
						'ringkasan'=>$d->ringkasan
					);
				}
			}
		}else if($tipe=="buku"){
			$where = array();
			if ( ! empty($judul)) $where[] = "judul_buku like '%{$judul}%'";
			if ( ! empty($pengarang)) $where[] = "pengarang_buku like '%{$pengarang}%'";
			if ( ! empty($penerbit)) $where[] = "penerbit_buku like '%{$penerbit}%'";
			if ( ! empty($isbn)) $where[] = "isbn_buku like '%{$isbn}%'";
			
			$sqlcount = "select count(id_buku) as hasil from tbl_buku";
			$sql = "SELECT * FROM tbl_buku";
			
			if ( ! empty($where)) {
				$sqlcount .= " WHERE " . implode(' OR ', $where);
				$sql .= " WHERE " . implode(' OR ', $where);
			}
			
			$totalhalaman=$this->db->query($sqlcount,true);
			
			$numpagebk=ceil($totalhalaman->hasil/$tdph);
			$startbk=$cpagebk*$tdph;
			$r=array();
		
			$hasil=$this->db->query($sql . " limit $startbk,$tdph");
					
			if(count($hasil)<=0)  return FALSE;
			else{
				for($i=0; $i<count($hasil);$i++){
					$d=$hasil[$i];
					
					$r[]=array(
						'isbn'=>$d->isbn_buku,
						'judul'=>$d->judul_buku,
						'sampul'=>$d->sampul_buku,
						'pengarang'=>$d->pengarang_buku,
						'macam'=>$d->macam_buku,
						'bahasa'=>$d->bahasa_buku,
						'penerbit'=>$d->penerbit_buku,
						'tahun'=>$d->tahun_terbit_buku
					);
				}
			}
		}else if($tipe=="file"){
			$wherefl = array();
			if ( ! empty($judul)) $wherefl[] = "judul_file like '%{$judul}%'";
			if ( ! empty($pengarang)) $wherefl[] = "pengarang_file like '%{$pengarang}%'";
			if ( ! empty($penerbit)) $wherefl[] = "penerbit_file like '%{$penerbit}%'";
			
			$sqlcountfl = "select count(kode_file) as hasil from tbl_file";
			$sqlfl = "SELECT * FROM tbl_file";
			
			if ( ! empty($wherefl)) {
				$sqlcountfl .= " WHERE " . implode(' OR ', $wherefl);
				$sqlfl .= " WHERE " . implode(' OR ', $wherefl);
			}
		
			$totalhalamanfl=$this->db->query($sqlcountfl,true);
			
			$numpagefl=ceil($totalhalamanfl->hasil/$tdph);
			$startfl=$cpagefl*$tdph;
					
			$hasilfl=$this->db->query($sqlfl . " limit $startfl,$tdph");
			
			if(count($hasilfl)<=0)  return FALSE;
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
						'tgl'=>($d->tgl_upload == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_upload, 'd-F-Y')),
						'ringkasan'=>$d->ringkasan
					);
				}
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
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' or penerbit_buku='%{$kata}%'",true);
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
			$hasil=$this->db->query("SELECT * FROM tbl_buku where judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' or penerbit_buku like '%{$kata}% limit $start,$tdph");
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
					'judul'=>$d->judul_buku,
					'isbn'=>$d->isbn_buku,
					'sampul'=>$d->sampul_buku,
					'pengarang'=>$d->pengarang_buku,
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
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' or pengarang_file like '%{$kata}%' or penerbit_file like '%{$kata}%' order by tgl_upload desc limit $start,$tdph");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' order by tgl_upload desc limit $start,$tdph");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where pengarang_file like '%{$kata}%' order by tgl_upload desc limit $start,$tdph");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where penerbit_file like '%{$kata}%'  limit $start,$tdph");
		}
		
		if(count($hasil)<=0) return FALSE;
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
			
				$r[]=array(
					'id'=>$d->kode_file,
					'judul'=>$d->judul_file,
					'sampul'=>$d->sampul_file,
					'pengarang'=>$d->pengarang_file,
					'macam'=>$d->macam_file,
					'bahasa'=>$d->bahasa_file,
					'penerbit'=>$d->penerbit_file,
					'tahun'=>$d->tahun_terbit_file,
					'tgl'=>date('d-m-Y', strtotime($d->tgl_upload)),
					'ringkasan'=>$d->ringkasan,
					'idp'=>$d->id_anggota
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
		
		$pw=md5($password);
		
		//query ke database
		if($status==2){
			$hasil=$this->db->query("SELECT * from tbl_petugas where username='".$username."' and password_petugas='".$pw."'",TRUE);
			$id = $hasil->id_petugas;
			if(count($hasil)<=0)  return FALSE;
			else return array(
				'token'=> crypt($username, $pw),
				'id'=>$id,
				'status'=>2
			);
		}else if($status==1){
			$hasil=$this->db->query("SELECT * from tbl_anggota where no_identitas='".$username."' and password_anggota='".$pw."'",TRUE);
			$id = $hasil->id_anggota;
			if(count($hasil)<=0)  return FALSE;
			else return array(
				'token'=> crypt($username, $pw),
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
		
		$input=$this->db->query("insert into tbl_aktivitas values(null, '$user', '$id',now())");
		$iofiles->download($nama);
	}
	
	public function delete_file($id){
		$id = floatval($id);
		$ambil=$this->db->query("select nama_file,sampul_file from tbl_file where kode_file='$id'",true);
		@unlink($ambil->nama_file);
		$sampul=$ambil->sampul_file;
		
		if($sampul!="sampul/sampul_file.jpg"){
			@unlink($sampul);
		}
		$this->db->query("delete from tbl_file where kode_file='$id'");
	}
	
	public function view_peminjaman($id) {		
		$r=array();
		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		
		$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_anggota='$id' and tgl_pengembalian='0000-00-00'");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
				
				$idbuku=$d->id_buku;
				$ambilbk=$this->db->query("select judul_buku from tbl_buku where id_buku='$idbuku'",true);
				$judul=$ambilbk->judul_buku;
				$iddet=$d->id_detail_peminjaman;
				$tglkembali=$d->tgl_kembali;	
				$tgl_pengembalian=$d->tgl_pengembalian;	
				$iddetail=$d->id_detail_peminjaman;
				$ambilhr=$this->db->query("select datediff(now(), '$tglkembali') as jumlah from tbl_detail_peminjaman where id_detail_peminjaman='$iddet'",true);
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
				'tgl_kembali'=>($d->tgl_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_kembali, 'd-F-Y')),
				'denda'=>$denda
			);
		}
		return $r;
	}
	
	
	public function view_pengaturananggota() {
		extract($this->prepare_get(array('id')));
		$r=array();
	
		$ambilpt=$this->db->query("select * from tbl_anggota where id_anggota='$id'",true);
			
		$r=array(
			'id'=>$ambilpt->id_anggota,
			'nama'=>$ambilpt->nama_anggota,
			'noid'=>$ambilpt->no_identitas,
			'jk'=>$ambilpt->jeniskelamin_anggota,
			'gender'=>($ambilpt->jeniskelamin_anggota == 'P' ? 'Perempuan' : 'Laki-laki'),
			'telp'=>$ambilpt->telp_anggota,
			'alamat'=>$ambilpt->alamat_anggota,
			'pw'=>''
		);	
		
		return array(
			'datapt'=>$r
			
		);
	}
	
	public function ubah_pengaturanakun(){
		extract($this->prepare_post(array('id','nama','jk','telp','alamat','pw')));
		$id = floatval($id);
		$nama=$this->db->escape_str($nama);
		$jk=$this->db->escape_str($jk);
		//edit
		$edit=$this->db->query("update tbl_anggota set nama_anggota='$nama', jeniskelamin_anggota='$jk', telp_anggota='$telp', alamat_anggota='$alamat' where id_anggota='$id'");
		
		if(!empty($pw)){
			$pw=md5($pw);
			$edit2=$this->db->query("update tbl_anggota set password_anggota='$pw' where id_anggota='$id'");
		}
		return $this->view_pengaturananggota();
	}
		
		
	public function view_berandaanggota($iofiles) {
		$q=	$s=array();
		
		$ambilbkbr=$this->db->query("select * from  tbl_buku order by id_buku desc limit 5");
		if(count($ambilbkbr)<=0)  return FALSE;
		else{
			for($i=0; $i<count($ambilbkbr);$i++){
				$d=$ambilbkbr[$i];
					
				$q[]=array(
					'isbn'=>$d->isbn_buku,
					'judul'=>$d->judul_buku,
					'sampul'=>$d->sampul_buku,
					'penempatan'=>$d->no_penempatan,
					'pengarang'=>$d->pengarang_buku,
					'macam'=>$d->macam_buku,
					'bahasa'=>$d->bahasa_buku,
					'penerbit'=>$d->penerbit_buku,
					'tahun'=>$d->tahun_terbit_buku
				);
			}
		}
		
		$ambilflbr=$this->db->query("select * from  tbl_file order by kode_file desc limit 5");
		if(count($ambilflbr)<=0)  return FALSE;
		else{
			for($i=0; $i<count($ambilflbr);$i++){
				$d=$ambilflbr[$i];
				$nama=$d->nama_file;
				$attr=$iofiles->get_attrib($nama);
				$s[]=array(
					'kode'=>$d->kode_file,
					'judul'=>$d->judul_file,
					'sampul'=>$d->sampul_file,
					'ukuran'=>$this->human_filesize($attr['size']).'B',
					'tipe'=>$attr['type'],
					'pengarang'=>$d->pengarang_file,
					'macam'=>$d->macam_file,
					'bahasa'=>$d->bahasa_file,
					'penerbit'=>$d->penerbit_file,
					'tahun'=>$d->tahun_terbit_file,
					'tgl'=>($d->tgl_upload == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_upload, 'd-F-Y')),
					'ringkasan'=>$d->ringkasan
				);
			}
		}
		
		
		return array(
			'bukubaru' =>$q,
			'filebaru' =>$s
		);
	}
}
