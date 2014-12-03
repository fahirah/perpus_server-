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
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' or pengarang_file like '%{$kata}%' or penerbit_file like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where pengarang_file like '%{$kata}%' limit $start,$tdph");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where penerbit_file like '%{$kata}%' limit $start,$tdph");
		}
		
		if(count($hasil)<=0) return array();
		else{		
			for($i=0; $i<count($hasil);$i++){
				$d=$hasil[$i];
				
				$r[]=array(
					'id'=>$d->kode_file,
					'nama'=>$d->nama_file,
					'judul'=>$d->judul_file,
					'pengarang'=>$d->pengarang_file,
					'macam'=>$d->macam_file,
					'bahasa'=>$d->bahasa_file,
					'penerbit'=>$d->penerbit_file,
					'tahun'=>$d->tahun_terbit_file,
					'ringkasan'=>$d->ringkasan
				);
			}
			return array(
			'data' => $r,
			'numpagefl' => $numpagefl
			);
		}
	}
	
	public function tambah_file($iofiles){
		extract($this->prepare_post(array('id', 'judul', 'pengarang', 'macam', 'bahasa', 'penerbit', 'tahun', 'ringkasan')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$macam=$this->db->escape_str($macam);
		$bahasa=$this->db->escape_str($bahasa);
		$penerbit=$this->db->escape_str($penerbit);
		$ringkasan=$this->db->escape_str($ringkasan);
		$id = floatval($id);
		
		$config['upload_path']   = 'berkas/';
		$config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
		$config['encrypt_name']  = TRUE;
		$config['overwrite']	 = TRUE;
		$iofiles->upload_config($config);
		$iofiles->upload('file');
		
		$filename = $iofiles->upload_get_param('file_name');
		$filepath = 'berkas/'.$filename;
	
		if (empty($id)) {
			//insert
			$ins=$this->db->query("INSERT INTO tbl_file VALUES(0,'$filepath','$judul','$pengarang','$macam','$bahasa','$penerbit','$tahun', '$ringkasan', NOW(), '$scope.user')");
		} else {
			// edit
			$ambil=$this->db->query("select nama_file from tbl_file where kode_file='$id'",true);
			if(isset($_FILES)){
				@unlink($ambil->nama_file);
				$edit=$this->db->query("update tbl_file set nama_file='$filepath', judul_file='$judul', pengarang_file='$pengarang', macam_file='$macam', bahasa_file='$bahasa', penerbit_file='$penerbit', tahun_terbit_file='$tahun',ringkasan='$ringkasan' where kode_file='$id'");
			} else {
				$edit=$this->db->query("update tbl_file set judul_file='$judul', pengarang_file='$pengarang', macam_file='$macam', bahasa_file='$bahasa', penerbit_file='$penerbit', tahun_terbit_file='$tahun',ringkasan='$ringkasan' where kode_file='$id'");
			}
		}
		return $this->view_file();
		//var_dump($_POST);
		//var_dump($_FILES);
	}
	
	public function delete_file($id){
		$id = floatval($id);
		$ambil=$this->db->query("select nama_file from tbl_file where kode_file='$id'");
		
		//$berkas=$ambil->nama_file;
		//unlink($berkas);
		//$this->db->query("delete from tbl_file where kode_file='$id'");
	}
}