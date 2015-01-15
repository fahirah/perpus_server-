<?php
/**
 * File Model
 */
namespace Model;

class FileModel extends ModelBase {
	public function __construct() {
		parent::__construct();
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
			$hasil=$this->db->query("SELECT * FROM tbl_file where penerbit_file like '%{$kata}%' limit order by tgl_upload desc limit $start,$tdph");
		}
		
		if(count($hasil)<=0) return FALSE;
		//return array();
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				$kode=$d->kode_file;
				$ambiljml=$this->db->query("select count(kode_file) as jumlah from tbl_aktivitas where kode_file='$kode'",true);
				$jumlah=$ambiljml->jumlah;
				$idpt=$d->id_petugas;
				$idan=$d->id_anggota;
				
				if($idan!=0){
					$ambilnm=$this->db->query("select nama_anggota from tbl_anggota where id_anggota='$idan'",true);
					$nama=$ambilnm->nama_anggota;
				}
				if($idpt!=0){
					$ambilnm=$this->db->query("select nama_petugas from tbl_petugas where id_petugas='$idpt'",true);
					$nama=$ambilnm->nama_petugas;
				}
				$idupload=($d->id_petugas != 0 ? $d->id_petugas : $d->id_anggota);
				$status=($d->id_petugas != 0 ? 'Petugas' : 'Dosen');
				
				$r[]=array(
					'id'=>$kode,
					'nama'=>$d->nama_file,
					'sampul'=>$d->sampul_file,
					'judul'=>$d->judul_file,
					'pengarang'=>$d->pengarang_file,
					'macam'=>$d->macam_file,
					'bahasa'=>$d->bahasa_file,
					'penerbit'=>$d->penerbit_file,
					'tahun'=>$d->tahun_terbit_file,
					'jumlah'=>$jumlah,
					'idu'=>$idupload,
					'nmu'=>$nama,
					'status'=>$status,
					'ringkasan'=>$d->ringkasan,
					'tgl'=>date('d-m-Y', strtotime($d->tgl_upload))
				);
			}
			return array(
			'data' => $r,
			'numpagefl' => $numpagefl
			);
		}
	}
	
	private function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '. @$sz[$factor];
	}
	
	public function view_detildatafile($kode,$iofiles) {
		$r=array();
		$d=$this->db->query("select * from tbl_file where kode_file='$kode'",true);
		
		if(! $d)  return FALSE;	
		$nama=$d->nama_file;
		$attr=$iofiles->get_attrib($nama);	
		$idpt=$d->id_petugas;
		$idan=$d->id_anggota;
		if($idpt==0){
			$ambilnm=$this->db->query("select nama_anggota from tbl_anggota where id_anggota='$idan'",true);
			$namaup=$ambilnm->nama_anggota;
		}else{
			$ambilnm=$this->db->query("select nama_petugas from tbl_petugas where id_petugas='$idpt'",true);
			$namaup=$ambilnm->nama_petugas;
		}
		$idupload=($d->id_petugas != '0' ? $d->id_petugas : $d->id_anggota);
		$status=($d->id_petugas != '0' ? 'Petugas' : 'Dosen');		
		$r[]=array(
			'id'=>$d->kode_file,
			'nama'=>$nama,
			'judul'=>$d->judul_file,
			'sampul'=>$d->sampul_file,
			'ukuran'=>$this->human_filesize($attr['size']).'B',
			'tipe'=>$attr['type'],
			'pengarang'=>$d->pengarang_file,
			'idu'=>$idupload,
			'nmu'=>$namaup,
			'status'=>$status,
			'macam'=>$d->macam_file,
			'bahasa'=>($d->bahasa_file == '' ? '-' : $d->bahasa_file),
			'penerbit'=>($d->penerbit_file == '' ? '-' : $d->penerbit_file),
			'tahun'=>($d->tahun_terbit_file== '' ? '-' : $d->tahun_terbit_file),
			'ringkasan'=>$d->ringkasan,
			'tgl'=>date('d-m-Y', strtotime($d->tgl_upload))
		);
		
		$p=array();		
		$ambilfl=$this->db->query("select * from tbl_aktivitas where kode_file='$kode'");
		if(count($ambilfl)>0){
			for($j=0;$j<count($ambilfl);$j++){
				$e=$ambilfl[$j];
				$idan=$e->id_anggota;
				$ambilnm=$this->db->query("select no_identitas, nama_anggota, status_anggota from tbl_anggota where id_anggota='$idan'",true);
				$noid=$ambilnm->no_identitas;
				$nama=$ambilnm->nama_anggota;
				$nama=$ambilnm->nama_anggota;
				$status=($ambilnm->status_anggota == 'm' ? 'Mahasiswa' : 'Dosen');

				$p[]=array(
					'kd'=>$e->kode_aktivitas,
					'idan'=>$idan,
					'noid'=>$noid,
					'nama'=>$nama,
					'status'=>$status,
					'tgl_download'=>datedb_to_tanggal($e->tgl_download, 'd-F-Y')
				);
			}
		}
		return array(
			'data' =>$r,
			'datadownload'=>$p
		);
	}
	
	public function tambah_file($iofiles){
		//var_dump($_FILES);
		//return;
		
		extract($this->prepare_post(array('id', 'judul', 'pengarang', 'macam', 'bahasa', 'penerbit', 'tahun', 'ringkasan','status', 'id_user')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$macam=$this->db->escape_str($macam);
		$bahasa=$this->db->escape_str($bahasa);
		$penerbit=$this->db->escape_str($penerbit);
		$ringkasan=$this->db->escape_str($ringkasan);
		$id = floatval($id);
		
		//upload berkas
		$config['upload_path']   = 'berkas/';
		$config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
		$config['encrypt_name']  = TRUE;
		$config['overwrite']	 = TRUE;
		$iofiles->upload_config($config);
		$iofiles->upload('file1');
		
		$filename = $iofiles->upload_get_param('file_name');
		$filepath = 'berkas/'.$filename;
		
		//upload sampul
		if (isset($_FILES['file2'])) {
			$config = array();
			$config['upload_path']   = 'sampul/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['encrypt_name']  = TRUE;
			$config['overwrite']	 = TRUE;
			$iofiles->upload_config($config);
			$iofiles->upload('file2');
			
			$filename2 = $iofiles->upload_get_param('file_name');
			$filepath2= 'sampul/'.$filename2;
		} else{
			$filename2 = 'sampul_file.jpg';
			$filepath2= 'sampul/'.$filename2;
		}
		
		if ($status == 2){
			// berarti petugas
			$petugas=$id_user;
			$dosen=0;
		} else{
			// berarti dosen
			$dosen=$id_user;
			$petugas=0;
		}
		
		if (empty($id)) {
			//insert
			if($petugas!=0){
				$ins=$this->db->query("insert into tbl_file VALUES(0,null,'$petugas','$filepath2', '$filepath','$judul','$pengarang','$ringkasan',NOW(),'$macam','$bahasa','$penerbit','$tahun')");
			}else{
				$ins=$this->db->query("insert into tbl_file VALUES(0,'$dosen',null,'$filepath2', '$filepath','$judul','$pengarang','$ringkasan',NOW(),'$macam','$bahasa','$penerbit','$tahun')");
			}
		} else {
			// edit
			$ambil=$this->db->query("select nama_file, sampul_file from tbl_file where kode_file='$id'",true);
			if(isset($_FILES['file1'])){
				@unlink($ambil->nama_file);
				$edit=$this->db->query("update tbl_file set nama_file='$filepath', judul_file='$judul', pengarang_file='$pengarang', macam_file='$macam', bahasa_file='$bahasa', penerbit_file='$penerbit', tahun_terbit_file='$tahun',ringkasan='$ringkasan' where kode_file='$id'");
			} else if(isset($_FILES['file2'])){
				@unlink($ambil->sampul_file);
				$edit=$this->db->query("update tbl_file set sampul_file='$filepath2', judul_file='$judul', pengarang_file='$pengarang', macam_file='$macam', bahasa_file='$bahasa', penerbit_file='$penerbit', tahun_terbit_file='$tahun',ringkasan='$ringkasan' where kode_file='$id'");
			}else {
				$edit=$this->db->query("update tbl_file set judul_file='$judul', pengarang_file='$pengarang', macam_file='$macam', bahasa_file='$bahasa', penerbit_file='$penerbit', tahun_terbit_file='$tahun',ringkasan='$ringkasan' where kode_file='$id'");
			}
		}
		return $this->view_file();
		//var_dump($_POST);
		//var_dump($_FILES);
	}
	
	public function delete_file($id){
		$id = floatval($id);
		$ambil=$this->db->query("select nama_file, sampul_file from tbl_file where kode_file='$id'",true);
		@unlink($ambil->nama_file);
		$sampul=$ambil->sampul_file;
		
		if($sampul!="sampul/sampul_file.jpg"){
			@unlink($sampul);
		}
		$this->db->query("delete from tbl_file where kode_file='$id'");
	}
}