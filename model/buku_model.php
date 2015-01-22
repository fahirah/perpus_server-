<?php
/**
 * Buku Model
 */
namespace Model;

class BukuModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function view_kelasutama() {
		$r=array();
		$hasil=$this->db->query("select * from tbl_kelasutama_ddc");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			
			$r[]=array(
				'id'=>$d->id_kelasutama,
				'kode'=>$d->kode_kelasutama,
				'ket'=>$d->keterangan_kelasutama,
			);
		}
		return $r;
	}

	public function view_devisi($kode) {
		$r=array();
		$hasil=$this->db->query("select * from tbl_devisi_ddc where id_kelasutama='$kode'");
		for($i=0; $i<count($hasil);$i++){
			$d=$hasil[$i];
			
			$r[]=array(
				'iddev'=>$d->id_devisi,
				'kodedev'=>$d->kode_devisi,
				'ketdev'=>$d->keterangan_devisi,
				'idkls'=>$d->id_kelasutama
			);
		}
		return $r;
	}
	
	public function view_buku() {
		extract($this->prepare_get(array('cpagebk','kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		$cpagebk = floatval($cpagebk);
		//total halaman
		$tdph=20;
	
		if(empty($jenis)){
			$totalhalaman=$this->db->query("select count(id_buku) as hasil from tbl_buku where isbn_buku like '%{$kata}%' or judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' or penerbit_buku like '%{kata}%' ",true);
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
			$hasil=$this->db->query("SELECT * FROM tbl_buku where isbn_buku like '%{$kata}%' or judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%' order by id_buku desc limit $start,$tdph");
		}else if($jenis=="isbn"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where isbn_buku like '%{$kata}%' order by id_buku desc limit $start,$tdph");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where judul_buku like '%{$kata}%' order by id_buku desc limit $start,$tdph");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where pengarang_buku like '%{$kata}%' order by id_buku desc limit $start,$tdph");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("SELECT * FROM tbl_buku where penerbit_buku like '%{$kata}%' order by id_buku desc limit $start,$tdph");
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
				$exp=explode('.',$pn[3]);
				$idp=$d->id_petugas;  
				$ambilpt=$this->db->query("select nama_petugas from tbl_petugas where id_petugas='$idp'",true);
				$namapt=$ambilpt->nama_petugas;
				$iddev=$d->id_devisi;
				$ambilkls=$this->db->query("select id_kelasutama from tbl_devisi_ddc where id_devisi='$iddev'",true);
				$klsutama=$ambilkls->id_kelasutama;
				$r[]=array(
					'id'=>$id,
					'isbn'=>$d->isbn_buku,
					'sampul'=>$d->sampul_buku,
					'judul'=>$d->judul_buku,
					'pengarang'=>$d->pengarang_buku,
					'macam'=>$d->macam_buku,
					'bahasa'=>$d->bahasa_buku,
					'penempatan'=>$pn[0],
					'stok'=>($exp[1] == '0' ? $exp[1] : '-1'),
					'pn'=>$penempatan,
					'penerbit'=>$d->penerbit_buku,
					'tahun'=>$d->tahun_terbit_buku, 
					'kota'=>$d->kota_terbit_buku,
					'inventaris'=>$d->no_inventaris,
					'tgl'=>$d->tanggal_input,
					//'tgl'=>datedb_to_tanggal($d->tanggal_input, 'd-F-Y'),
					'statusbk'=>($d->status_buku == 'L' ? 'Layak' : 'Tidak Layak'),
					'status'=>$d->status_buku,
					'idpetugas'=>$d->id_petugas,
					'namapetugas'=>$namapt,
					'jumlah'=>$jumlah,
					'ringkasan'=>$d->ringkasan_buku,
					'devisi'=>$iddev,
					'klsutama'=>$klsutama
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
		$d=$this->db->query("select * from tbl_buku where id_buku='$kode'",true);
		
		if(! $d)  return FALSE;				
		
		$id=$d->id_buku;
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
		$jumlahbk=$ambil->jumlah;
				
		$ambiljml=$this->db->query("select count(id_buku) as jumlah from tbl_detail_peminjaman where id_buku='$id'",true);
		$jumlah=$ambiljml->jumlah;
		
		$ambiljml2=$this->db->query("select count(id_buku) as jumlah from tbl_detail_peminjaman where id_buku='$id' and tgl_pengembalian='0000-00-00'",true);
		$jumlah2=$ambiljml2->jumlah;
				
		//$ambiljum=$this->db->query("select count(id_buku)as jumlah from tbl_buku where isbn_buku='$isbn' and judul_buku='$judul' and pengarang_buku='$pengarang' and penerbit_buku='$penerbit' and tahun_terbit_buku='$tahun'",true);
		//$jumlahbk=$ambiljum->jumlah;
				
		$idp=$d->id_petugas;  
		$ambilpt=$this->db->query("select nama_petugas from tbl_petugas where id_petugas='$idp'",true);
		$namapt=$ambilpt->nama_petugas;
				
		$r[]=array(
			'id'=>$d->id_buku,
			'isbn'=>$d->isbn_buku,
			'sampul'=>$d->sampul_buku,
			'judul'=>$d->judul_buku,
			'pengarang'=>$d->pengarang_buku,
			'macam'=>$d->macam_buku,
			'bahasa'=>$d->bahasa_buku,
			'penempatan'=>$ddc,
			'pn'=>$d->no_penempatan,
			'penerbit'=>$d->penerbit_buku,
			'tahun'=>$d->tahun_terbit_buku,
			'kota'=>$d->kota_terbit_buku,
			'inventaris'=>$d->no_inventaris,
			'tgl'=>$d->tanggal_input,
			'jumlah'=>$jumlah,
			'jumlahbk'=>$jumlahbk, 
			'jumlahpjm'=>$jumlah2,
			'status'=>$d->status_buku,
			'ringkasan'=>$d->ringkasan_buku,
			'idpetugas'=>$d->id_petugas,
			'namapetugas'=>$namapt
		);
	
		//$ambilid=$this->db->query("select id_buku from tbl_buku where kode_buku='$kode'",true);
		//$idbk=$ambilid->id_buku;
		
		$p=array();
			
		$ambilpjm=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$kode' and tgl_pengembalian='0000-00-00'");
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
		extract($this->prepare_post(array('id', 'isbn', 'judul', 'pengarang', 'stok', 'macam', 'bahasa', 'kota', 'devisi', 'penerbit', 'tahun','ringkasan', 'status','id_user')));
		$judul=$this->db->escape_str($judul);
		$pengarang=$this->db->escape_str($pengarang);
		$macam=$this->db->escape_str($macam);
		$bahasa=$this->db->escape_str($bahasa);
		$penerbit=$this->db->escape_str($penerbit);
		$ringkasan=$this->db->escape_str($ringkasan);
		$id = floatval($id);
		$id_user = floatval($id_user);
		$stok = floatval($stok);
		
		$config['upload_path']   = 'sampul/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name']  = TRUE;
		$config['overwrite']	 = TRUE;
		$iofiles->upload_config($config);
		$iofiles->upload('buku');
		
		$filename = $iofiles->upload_get_param('file_name');
		$filepath = 'sampul/'.$filename;
		
		$ambildev=$this->db->query("select * from tbl_devisi_ddc where id_devisi='$devisi'",true);
		$penempatan=$ambildev->kode_devisi;
		
		$a=explode(",", $pengarang);
		$b=explode(" ",$a[0]);
		$c=(count($b))-1;		
		$d=strtoupper(substr($b[$c],0,3));
		
		$e=strtoupper(substr($judul,0,1));
		$nopnmptn=$penempatan."/".$d."/".$e;
		$f=strlen($nopnmptn);
	
		$cekpn=$this->db->query("select count(id_buku) as jum_bk from tbl_buku where isbn_buku='$isbn' and judul_buku='$judul' and pengarang_buku='$pengarang' and macam_buku='$macam' and bahasa_buku='$bahasa' and kota_terbit_buku='$kota' and penerbit_buku='$penerbit' and tahun_terbit_buku='$tahun' and substr(no_penempatan, 1,$f)='$nopnmptn'",true);
		$jum_bk=$cekpn->jum_bk;
				
		if (empty($id)) {
			//insert
			if($stok==0){
				$cek=$this->db->query("select max(id_buku) as idbk from tbl_buku",true);
				$idbk=$cek->idbk;
				$idbk++;
				$pn=$nopnmptn."/C.0";
				$inven=$idbk."/PF/PB";
				
				if($filename != null){
					$ins=$this->db->query("insert into tbl_buku VALUES(0,'$isbn','$filepath','$judul','$pengarang','$macam','$bahasa','$inven','$pn','$kota','$penerbit','$tahun', '$ringkasan', 'TL', '$id_user',NOW(),'$devisi')");
				}else{
					$ins=$this->db->query("insert into tbl_buku VALUES(0,'$isbn','sampul/sampul_buku.jpg','$judul','$pengarang','$macam','$bahasa','$inven','$pn','$kota','$penerbit','$tahun','$ringkasan', 'TL', '$id_user', NOW(),'$devisi')");
				}
			}else{
				for($i=1;$i<=$stok;$i++){
					$cek=$this->db->query("select max(id_buku) as idbk from tbl_buku",true);
					$idbk=$cek->idbk;
					$idbk++;
					$jum_bk++;
					$pn=$nopnmptn."/C.".$jum_bk;
					$inven=$idbk."/PF/PB";
					
					if($filename != null){
						$ins=$this->db->query("insert into tbl_buku VALUES(0,'$isbn','$filepath','$judul','$pengarang','$macam','$bahasa','$inven','$pn','$kota','$penerbit','$tahun', '$ringkasan', 'L', '$id_user',NOW(),'$devisi')");
					}else{
						$ins=$this->db->query("insert into tbl_buku VALUES(0,'$isbn','sampul/sampul_buku.jpg','$judul','$pengarang','$macam','$bahasa','$inven','$pn','$kota','$penerbit','$tahun','$ringkasan', 'L', '$id_user', NOW(),'$devisi')");
					}
					$kodeddc=str_replace('/','_',$pn);
					// panggil
					generate_barcode($kodeddc);
				}
			}			
		} else {		
			if($stok==0){
				$a=explode(",", $pengarang);
				$b=explode(" ",$a[0]);
				$c=(count($b))-1;		
				$d=strtoupper(substr($b[$c],0,3));
				
				$e=strtoupper(substr($judul,0,1));
				$nopnmptn=$penempatan."/".$d."/".$e;
			
				$ambil=$this->db->query("select sampul_buku from tbl_buku where id_buku='$id'",true);
				$pnp=$nopnmptn."/C.0";
				if($filename != null){
					@unlink($ambil->sampul_buku);
					
					$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn',  sampul_buku='$filepath', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$pnp', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun', kota_terbit_buku='$kota', ringkasan_buku='$ringkasan', id_devisi='$devisi' where id_buku='$id'");
				}else{
					$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$pnp', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun', kota_terbit_buku='$kota', ringkasan_buku='$ringkasan', id_devisi='$devisi' where id_buku='$id'");
				}
				
			}else if($stok>0){
				//cek
				$cekstk=$this->db->query("select no_penempatan, no_inventaris from tbl_buku where id_buku='$id'",true);
				$nopn=$cekstk->no_penempatan;
				$noinv=$cekstk->no_inventaris;
				
				for($i=1;$i<=$stok;$i++){
				
					if($i==1){
						$ambil=$this->db->query("select sampul_buku from tbl_buku where id_buku='$id'",true);
						$pnp=$nopnmptn."/C.".$i;
						if($filename != null){
							@unlink($ambil->sampul_buku);
							
							$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn',  sampul_buku='$filepath', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$pnp', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun', kota_terbit_buku='$kota', ringkasan_buku='$ringkasan', status_buku='L',id_devisi='$devisi' where id_buku='$id'");
						}else{
							$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', no_penempatan='$pnp', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun', kota_terbit_buku='$kota', ringkasan_buku='$ringkasan', status_buku='L',id_devisi='$devisi' where id_buku='$id'");
						}
					}else{
						$cek=$this->db->query("select max(id_buku) as idbk from tbl_buku",true);
						$idbk=$cek->idbk;
						$idbk++;
						$jum_bk++;
						$pn=$nopnmptn."/C.".$jum_bk;
						$inven=$idbk."/PF/PB";
						
						if($filename != null){
							$ins=$this->db->query("insert into tbl_buku VALUES(0,'$isbn','$filepath','$judul','$pengarang','$macam','$bahasa','$inven','$pn','$kota','$penerbit','$tahun', '$ringkasan', 'L', '$id_user',NOW())");
						}else{
							$ins=$this->db->query("insert into tbl_buku VALUES(0,'$isbn','sampul/sampul_buku.jpg','$judul','$pengarang','$macam','$bahasa','$inven','$pn','$kota','$penerbit','$tahun','$ringkasan', 'L', '$id_user', NOW(),'$devisi')");
						}
						
						$kodeddc=str_replace('/','_',$pn);
						// panggil
						generate_barcode($kodeddc);
					}
				}
				
			}else{
				$a=explode(",", $pengarang);
				$b=explode(" ",$a[0]);
				$c=(count($b))-1;		
				$d=strtoupper(substr($b[$c],0,3));
				
				$e=strtoupper(substr($judul,0,1));
				$nopnmptn=$penempatan."/".$d."/".$e;
			
				$ambil=$this->db->query("select * from tbl_buku where id_buku='$id'",true);
				$isbnlm=$ambil->isbn_buku;
				$judullm=$ambil->judul_buku;
				$pengaranglm=$ambil->pengarang_buku;
				$macamlm=$ambil->macam_buku;
				$bahasalm=$ambil->bahasa_buku;
				$kotalm=$ambil->kota_terbit_buku;
				$penerbitlm=$ambil->penerbit_buku;		
				$tahunlm=$ambil->tahun_terbit_buku;
				$devisilm=$ambil->id_devisi;
				$nopn=$ambil->no_penempatan;
				$a=explode("/",$nopn);
				$c=$a[3];
				$pnp=$nopnmptn."/".$c;
				$nopnp=$a[0]."/".$a[1]."/".$a[2];
				$f=strlen($nopnp);
				$edit2=$this->db->query("update tbl_buku set status_buku='$status' where id_buku='$id'");
				
				$ambildatabk=$this->db->query("select id_buku,no_penempatan from tbl_buku where substr(no_penempatan, 1,$f)='$nopnp' or isbn_buku='$isbnlm' and judul_buku='$judullm' and pengarang_buku='$pengaranglm' and macam_buku='$macamlm' and bahasa_buku='$bahasalm' and kota_terbit_buku='$kotalm' and penerbit_buku='$penerbitlm' and tahun_terbit_buku='$tahunlm'");
				
				for($i=0; $i<count($ambildatabk);$i++){
					$d=$ambildatabk[$i];
					$idbk=$d->id_buku;
					$nopenempatanbk=$d->no_penempatan;
					$pch=explode('/',$nopenempatanbk);
					$pnp=$nopnmptn."/".$pch[3];
					$tmpt="barcode"/$nopenempatanbk;
					@unlink($tmpt);
					
					$editno=$this->db->query("update tbl_buku set no_penempatan='$pnp' where id_buku='$idbk'");
					$kodeddc=str_replace('/','_',$pnp);
					// panggil
					generate_barcode($kodeddc);
				}
				
				if($filename != null){
					@unlink($ambil->sampul_buku);
					
					$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn',  sampul_buku='$filepath', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun', kota_terbit_buku='$kota', ringkasan_buku='$ringkasan', id_devisi='$devisi' where id_buku='$id' and substr(no_penempatan, 1,$f)='$nopnp' or isbn_buku='$isbnlm' and judul_buku='$judullm' and pengarang_buku='$pengaranglm' and macam_buku='$macamlm' and bahasa_buku='$bahasalm' and kota_terbit_buku='$kotalm' and penerbit_buku='$penerbitlm' and tahun_terbit_buku='$tahunlm'");
					
				}else{
					$edit=$this->db->query("update tbl_buku set isbn_buku='$isbn', judul_buku='$judul', pengarang_buku='$pengarang', macam_buku='$macam', bahasa_buku='$bahasa', penerbit_buku='$penerbit', tahun_terbit_buku='$tahun', kota_terbit_buku='$kota', ringkasan_buku='$ringkasan', id_devisi='$devisi' where id_buku='$id' and substr(no_penempatan, 1,$f)='$nopnp' or isbn_buku='$isbnlm' and judul_buku='$judullm' and pengarang_buku='$pengaranglm' and macam_buku='$macamlm' and bahasa_buku='$bahasalm' and kota_terbit_buku='$kotalm' and penerbit_buku='$penerbitlm' and tahun_terbit_buku='$tahunlm'");
				}
				
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