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
				
				$r[]=array(
					'id'=>$d->id_buku,
					'kode'=>$d->kode_buku,
					'isbn'=>$d->isbn_buku,
					'sampul'=>$d->sampul_buku,
					'judul'=>$d->judul_buku,
					'pengarang'=>$d->pengarang_buku,
					'stok'=>$d->stok_buku,
					'sisa'=>$d->sisa_stok_buku,
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
			'stok'=>$d->stok_buku,
			'sisa'=>$d->sisa_stok_buku,
			'macam'=>$d->macam_buku,
			'bahasa'=>$d->bahasa_buku,
			'penempatan'=>$d->no_penempatan,
			'penerbit'=>$d->penerbit_buku,
			'tahun'=>$d->tahun_terbit_buku
		);
		
		$p=array();
		$ambilid=$this->db->query("select id_buku from tbl_buku where kode_buku='$kode'",true);
		$idbk=$ambilid->id_buku;
		
		$ambilpjm=$this->db->query("select * from tbl_peminjaman_pengembalian where status_peminjaman='pinjam'");
		for($i=0; $i<count($ambilpjm);$i++){
			$d=$ambilpjm[$i];
				
			$kdpjm=$d->kode_peminjaman;
			$idan=$d->id_anggota;
			$ambilnm=$this->db->query("select nama_anggota, status_anggota from tbl_anggota where id_anggota='$idan'",true);
			$nama=$ambilnm->nama_anggota;
			$status=($ambilnm->status_anggota == 'm' ? 'Mahasiswa' : 'Dosen');
			$ambilbk=$this->db->query("select * from tbl_detail_peminjaman where kode_peminjaman='$kdpjm' and id_buku='$idbk'");
			if(count($ambilbk)>0){
				for($j=0;$j<count($ambilbk);$j++){
					$e=$ambilbk[$j];
					$p[]=array(
						'kdpjm'=>$e->kode_peminjaman,
						'idan'=>$idan,
						'nama'=>$nama,
						'status'=>$status,
						'tgl_pinjam'=>datedb_to_tanggal($e->tgl_pinjam, 'd-F-Y'),
						'tgl_kembali'=>($e->tgl_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($e->tgl_kembali, 'd-F-Y')),
					);
				}
			}
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
		
		$config['upload_path']   = 'sampul/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name']  = TRUE;
		$config['overwrite']	 = TRUE;
		$iofiles->upload_config($config);
		$iofiles->upload('buku');
		
		$filename = $iofiles->upload_get_param('file_name');
		$filepath = 'sampul/'.$filename;
	
		if (empty($id)) {
			//insert
			$cek=$this->db->query("SELECT * FROM tbl_buku where kode_buku='$kode'");
			if(count($cek)>0)  return FALSE;
			else{
				$ins=$this->db->query("INSERT INTO tbl_buku VALUES(0,'$kode','$isbn','$filepath','$judul','$pengarang','$stok','$stok','$macam','$bahasa','$penempatan','$penerbit','$tahun')");
			}
		} else {
			// edit
			$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn', kode_buku='$kode', sampul_buku='$filepath' judul_buku='$judul', pengarang_buku='$pengarang',stok_buku='$stok', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$penempatan', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun' where id_buku='$id'");
		}
		return $this->view_buku();
	}
	
	public function delete_buku($id){
		$id = floatval($id);
		$this->db->query("delete from tbl_buku where id_buku='$id'");
	}

}