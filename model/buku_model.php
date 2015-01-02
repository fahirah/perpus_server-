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
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where kode_buku like '%{$kata}%' or isbn_buku like '%{$kata}%' or judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' or penerbit_buku like '%{kata}%' ",true);
		}else if($jenis=="kode"){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where kode_buku like '%{$kata}%'",true);
		}else if($jenis=="isbn"){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where isbn_buku like '%{$kata}%'",true);
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
			$hasil=$this->db->query("SELECT * FROM tbl_buku where kode_buku like '%{$kata}%' or isbn_buku like '%{$kata}%' or judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="kode"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where kode_buku like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="isbn"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where isbn_buku like '%{$kata}%' limit $start,$tdph");
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
				$id=$d->id_buku;
				$ambiljml=$this->db->query("select count(id_buku) as jumlah from tbl_detail_peminjaman where id_buku='$id'",true);
				$jumlah=$ambiljml->jumlah;
				$penempatan=$d->no_penempatan;
				$pn=explode("/",$penempatan);
				
				$r[]=array(
					'id'=>$id,
					'kode'=>$d->kode_buku,
					'isbn'=>$d->isbn_buku,
					'sampul'=>$d->sampul_buku,
					'judul'=>$d->judul_buku,
					'pengarang'=>$d->pengarang_buku,
					'macam'=>$d->macam_buku,
					'bahasa'=>$d->bahasa_buku,
					'penempatan'=>$pn[0],
					'pn'=>$penempatan,
					'penerbit'=>$d->penerbit_buku,
					'tahun'=>$d->tahun_terbit_buku, 
					'jumlah'=>$jumlah
				);
			}
			return array(
			'data' => $r,
			'numpagebk' => $numpagebk
			);
		}
	}

	public function view_detildatabuku($kode) {	
		$r=array();
		$d=$this->db->query("select * from tbl_buku where kode_buku='$kode'",true);
		
		if(! $d)  return FALSE;				
		
		$r[]=array(
			'id'=>$d->id_buku,
			'kode'=>$d->kode_buku,
			'isbn'=>$d->isbn_buku,
			'sampul'=>$d->sampul_buku,
			'judul'=>$d->judul_buku,
			'pengarang'=>$d->pengarang_buku,
			'macam'=>$d->macam_buku,
			'bahasa'=>$d->bahasa_buku,
			'penempatan'=>$d->no_penempatan,
			'penerbit'=>$d->penerbit_buku,
			'tahun'=>$d->tahun_terbit_buku
		);
	
		$ambilid=$this->db->query("select id_buku from tbl_buku where kode_buku='$kode'",true);
		$idbk=$ambilid->id_buku;
		
		$p=array();
			
		$ambilpjm=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$idbk' and tgl_pengembalian='0000-00-00'");
		for($i=0; $i<count($ambilpjm);$i++){
			$d=$ambilpjm[$i];
				
			$idan=$d->id_anggota;
			$ambilnm=$this->db->query("select no_identitas, nama_anggota, status_anggota from tbl_anggota where id_anggota='$idan'",true);
			$noid=$ambilnm->no_identitas;
			$nama=$ambilnm->nama_anggota;
			$status=($ambilnm->status_anggota == 'm' ? 'Mahasiswa' : 'Dosen');
		
			$p[]=array(
				'idan'=>$idan,
				'noid'=>$noid,
				'nama'=>$nama,
				'status'=>$status,
				'tgl_pinjam'=>datedb_to_tanggal($d->tgl_pinjam, 'd-F-Y'),
				'tgl_kembali'=>($d->tgl_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_kembali, 'd-F-Y'))
				//'status'=>($d->tgl_pengembalian == '0000-00-00' ? 'pinjam' : 'kembali'),
			);
		}

		return array(
			'data' =>$r,
			'datapjm'=>$p
		);
	}	
	
	public function tambah_buku($iofiles){
		extract($this->prepare_post(array('id', 'kode', 'isbn', 'judul', 'pengarang', 'stok', 'macam', 'bahasa', 'penempatan', 'penerbit', 'tahun')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$macam=$this->db->escape_str($macam);
		$bahasa=$this->db->escape_str($bahasa);
		$penerbit=$this->db->escape_str($penerbit);
		$id = floatval($id);
		$stok = floatval($stok);
		if($stok==0){
			$stok=1;
		}
		$config['upload_path']   = 'sampul/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name']  = TRUE;
		$config['overwrite']	 = TRUE;
		$iofiles->upload_config($config);
		$iofiles->upload('buku');
		
		$filename = $iofiles->upload_get_param('file_name');
		$filepath = 'sampul/'.$filename;
		
		$a=explode(",", $pengarang);
		$b=explode(" ",$a[0]);
		$c=(count($b))-1;		
		$d=strtoupper(substr($b[$c],0,3));
		
		$e=strtoupper(substr($judul,0,1));
		$nopnmptn=$penempatan."/".$d."/".$e;
		if (empty($id)) {
			//insert
			for($i=1;$i<=$stok;$i++){
				$cek=$this->db->query("select max(kode_buku) as kdbk from tbl_buku",true);
				$kdbk=$cek->kdbk;
				if($kdbk==''){
					$kodebk=1;
				}else{
					$kodebk=substr($kdbk,1,4);
					$kodebk++;
				}
				$kodebr="B".sprintf("%04s",$kodebk);
				$pn=$nopnmptn."/C.".$i;
				if($filename != null){
					$ins=$this->db->query("INSERT INTO tbl_buku VALUES(0,'$kodebr','$isbn','$filepath','$judul','$pengarang','$macam','$bahasa','$pn','$penerbit','$tahun')");
				}else{
					$ins=$this->db->query("INSERT INTO tbl_buku VALUES(0,'$kodebr','$isbn','sampul/sampul_buku.jpg','$judul','$pengarang','$macam','$bahasa','$pn','$penerbit','$tahun')");
				}
				// panggil
				generate_barcode($kodebr);
			}
			
		} else {
			// edit
			$ambil=$this->db->query("select sampul_buku, no_penempatan from tbl_buku where id_buku='$id'",true);
			$nopn=$ambil->no_penempatan;
			$a=explode("/",$nopn);
			$c=$a[3];
			$pnp=$nopnmptn."/".$c;
			if($filename != null){
				@unlink($ambil->sampul_buku);
				
				$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn', kode_buku='$kode', sampul_buku='$filepath', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$pnp', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun' where id_buku='$id'");
			}else{
				$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn', kode_buku='$kode',judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$pnp', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun' where id_buku='$id'");
			}
		}
		return $this->view_buku();
	}
	
	public function delete_buku($id){
		$id = floatval($id);
		$ambil=$this->db->query("select sampul_buku from tbl_buku where id_buku='$id'",true);
		$sampul=$ambil->sampul_buku;
		if($sampul!="sampul/sampul_buku.jpg"){
			@unlink($sampul);
		}
		$this->db->query("delete from tbl_buku where id_buku='$id'");
	}

}