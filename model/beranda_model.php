<?php
/**
 * Beranda Model
 */
namespace Model;

class BerandaModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	private function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '. @$sz[$factor];
	}
	
	public function view_beranda($iofiles) {
		$ambilanggota=$this->db->query("select count(id_anggota) as jum_anggota from tbl_anggota ",true);
		$jumlah_anggota=$ambilanggota->jum_anggota;
		
		$ambilbuku=$this->db->query("select count(id_buku) as jum_buku from tbl_buku group by isbn_buku, judul_buku,pengarang_buku,penerbit_buku, tahun_terbit_buku ",true);
		$jumlah_buku=$ambilbuku->jum_buku;
		
		$ambilfile=$this->db->query("select count(kode_file) as jum_file from tbl_file",true);
		$jumlah_file=$ambilfile->jum_file;
		
		$ambildipinjam=$this->db->query("select count(id_buku) as banyak_dipinjam, id_buku from tbl_detail_peminjaman group by(id_buku) order by banyak_dipinjam desc limit 1",true);
		$idbuku=$ambildipinjam->id_buku;
		$ambilnmbk=$this->db->query("select judul_buku from tbl_buku where id_buku='$idbuku'",true);
		$judul=$ambilnmbk->judul_buku;
		
		$ambildiunduh=$this->db->query("select count(kode_file) as banyak_diunduh, kode_file from tbl_aktivitas group by(kode_file) order by banyak_diunduh desc limit 1",true);
		$kodefile=$ambildiunduh->kode_file;
		$ambilnmfl=$this->db->query("select judul_file from tbl_file where kode_file='$kodefile'",true);
		$namafl=$ambilnmfl->judul_file;
		
		$q=	$s=array();
		
		$ambilbkbr=$this->db->query("select * from  tbl_buku group by isbn_buku, judul_buku,pengarang_buku,penerbit_buku, tahun_terbit_buku order by id_buku desc");
		if(count($ambilbkbr)<=0)  return FALSE;
		else{
			for($i=0; $i<count($ambilbkbr);$i++){
				$d=$ambilbkbr[$i];
				
				
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
				
				
				
				//$ambiljum=$this->db->query("select count(id_buku)as jumlah from tbl_buku where isbn_buku='$isbn' and judul_buku='$judul' and pengarang_buku='$pengarang' and penerbit_buku='$penerbit' and tahun_terbit_buku='$tahun'",true);
				//$jumlah=$ambiljum->jumlah;
								
				$q[]=array(
					'kode'=>$d->kode_buku,
					'isbn'=>$d->isbn_buku,
					'judul'=>$d->judul_buku,
					'sampul'=>$d->sampul_buku,
					'penempatan'=>$ddc,
					'pengarang'=>$d->pengarang_buku,
					'macam'=>$d->macam_buku,
					'bahasa'=>$d->bahasa_buku,
					'penerbit'=>$d->penerbit_buku,
					'tahun'=>$d->tahun_terbit_buku,
					'jumlah'=>$jumlah
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
			'jum_anggota'=>$jumlah_anggota,
			'jum_buku'=>$jumlah_buku,
			'jum_file'=>$jumlah_file,
			'judul'=>$judul,
			'nama'=>$namafl,
			'bukubaru' =>$q,
			'filebaru' =>$s
		);
	}
}	