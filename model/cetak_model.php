<?php
/**
 * cetak Model
 */
namespace Model;

class CetakModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function cetak_kartubuku($kode) {	
		$r=array();
		$d=$this->db->query("select * from tbl_buku where kode_buku='$kode'",true);
		$penempatan=$d->no_penempatan;
		$a=explode("/", $penempatan);
		if(! $d)  return FALSE;				
?>
	<script src="/lib/jquery-1.10.2.min.js"></script>
	
	<table border="0" style="border-collapse: collapse;" cellpadding="2" cellspacing="2" width="250px">
		<tr style="border-right: .8mm solid #000; border-left: .8mm solid #000; border-top: .8mm solid #000">
			<td colspan="2" align="center"><strong><font size="4px"> FAKULTAS TEKNIK <br/>	PERPUSTAKAAN </font></strong></td>
		</tr>
		<tr style="border-top: .8mm solid #000; border-left: .8mm solid #000; border-right: .8mm solid #000; border-right: .8mm solid #000;">
			<td rowspan="5" style="border-bottom: .8mm solid #000; height:120px; width:110px;" >
				<img src="/barcode/<?php echo $kode; ?>.png" style="-moz-transform: rotate(270deg); -o-transform: rotate(270deg); -webkit-transform: rotate(270deg); transform: rotate(270deg); ">
			</td>
			<td ><font size="5px"><?php echo $kode; ?> </font></td>
		</tr>
		<tr style="border-right: .8mm solid #000;">
			<td><font size="5px"> <?php echo $a[0]; ?> </font></td>
		</tr>
		<tr style="border-right: .8mm solid #000;">
			<td><font size="5px"><?php echo $a[1]; ?> </font></td>
		</tr>
		<tr style="border-right: .8mm solid #000;">
			<td><font size="5px"><?php echo $a[2]; ?> </font></td>
		</tr>
		<tr style="border-right: .8mm solid #000; border-bottom: .8mm solid #000;">
			<td><font size="5px"><?php echo $a[3]; ?> </font></td>
		</tr>
	</table>
	
	<script>
$(window).load(function(){
	window.print();
	window.close();
});
	//window.close();
	</script>
<?php
	}

	public function cetak_kartuanggota($id) {	
		$r=array();
		$d=$this->db->query("select * from tbl_anggota where id_anggota='$id'",true);
		if(! $d)  return FALSE;				
		$nama=$d->nama_anggota;
		$noid=$d->no_identitas;
		$almt=$d->alamat_anggota;
		$telp=$d->telp_anggota;
		$status=($d->status_anggota == 'm' ? 'Mahasiswa' : 'Dosen');
	
?>
	<script src="/lib/jquery-1.10.2.min.js"></script>
	
	<table border="0" style="border-collapse: collapse;" cellpadding="3" cellspacing="2"  >
		<tr style="border: .8mm solid #000; ">
			<td colspan="3">
				<table border="0">
					<tr>
						<td rowspan="2">
							<img src="/sampul/logo.png" width="60px" height="60px">
						</td>
						<td align="center">KARTU ANGGOTA PERPUSTAKAAN </td>
					</tr>
					<tr>
						<td align="center">FAKULTAS TEKNIK UNIVERSITAS MADURA</td>
					</tr>
				</table>
			</td>
		</tr>	
		<tr style=" border-left: .8mm solid #000; border-right: .8mm solid #000;">
			<td>ID Anggota </td><td>:</td><td><?php echo $id; ?></td>
		</tr>
		<tr style=" border-left: .8mm solid #000; border-right: .8mm solid #000;">
			<td>Nama Anggota </td><td>:</td><td><?php echo $nama; ?></td>
		</tr>
		<tr style=" border-left: .8mm solid #000; border-right: .8mm solid #000;">
			<td>No Identitas </td><td>:</td><td><?php echo $noid; ?></td>
		</tr>
		<tr style=" border-left: .8mm solid #000; border-right: .8mm solid #000;">
			<td>Status </td><td>:</td><td><?php echo $status; ?></td>
		</tr>
		<tr style=" border-left: .8mm solid #000; border-right: .8mm solid #000;">
			<td>Alamat </td><td>:</td><td><?php echo $almt; ?></td>
		</tr>
		<tr style=" border-left: .8mm solid #000; border-right: .8mm solid #000;">
			<td>Telp </td><td>:</td><td><?php echo $telp; ?></td>
		</tr>
		<tr height="90px" style=" border-left: .8mm solid #000; border-right: .8mm solid #000; border-bottom: .8mm solid #000;">
			<td>&nbsp;</td><td>&nbsp;</td><td> <img src="/barcode/<?php echo $id; ?>.png"> </td>
		</tr>
	</table>
	
	<script>
$(window).load(function(){
	window.print();
	window.close();
});
	//window.close();
	</script>
<?php
	}		
	
	public function cetak_pdfanggota() {
		extract($this->prepare_get(array('kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		
		$r=array();
		if(empty($jenis)){
			$hasil=$this->db->query("select * from tbl_anggota where nama_anggota like '%{$kata}%' or id_anggota like '%{$kata}%' or no_identitas like '%{$kata}%' ");
		}else if($jenis=="no"){
			$hasil=$this->db->query("select * from tbl_anggota where no_identitas like '%{$kata}%'");
		}else if($jenis=="id"){
			$hasil=$this->db->query("select * from tbl_anggota where id_anggota like '%{$kata}%'");
		}else if($jenis=="nama"){
			$hasil=$this->db->query("select * from tbl_anggota where nama_anggota like '%{$kata}%'");
		}
?>
<html xmlns="http://www.w3.org/1999/xhtml"> <!-- Bagian halaman HTML yang akan konvert -->
<head>
</head>
<body>
	<p>DATA ANGGOTA</p>
	<table border="1" style="border-collapse: collapse;" cellpadding="3" cellspacing="2" width="100%">
		<thead>
			<tr>
				<th>NO</th>
				<th>ID ANGGOTA</th>
				<th>NAMA</th>
				<th>NO IDENTITAS</th>
				<th>ALAMAT</th>
				<th>TELP</th>
				<th>JENIS KELAMIN</th>
				<th>STATUS</th>
				<th>PRODI</th>
			</tr>
		</thead>
		<tbody>
<?php
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$no=$i+1;
			$id=$d->id_anggota;
			$nama=$d->nama_anggota;
			$noid=$d->no_identitas;
			$almt=$d->alamat_anggota;
			$telp=$d->telp_anggota;
			$jk=($d->jeniskelamin_anggota == 'P' ? 'Perempuan' : 'Laki-Laki');
			$status=($d->status_anggota == 'm' ? 'Mahasiswa' : 'Dosen');
			$kd=$d->kode_prodi;
			$ambilkd=$this->db->query("select * from tbl_prodi where kode_prodi='".$kd."'", true);
			$prodi = $ambilkd->nama_prodi;
	
?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $id; ?></td>
				<td><?php echo $nama; ?></td>
				<td><?php echo $noid; ?></td>
				<td><?php echo $almt; ?></td>
				<td><?php echo $telp; ?></td>
				<td><?php echo $jk; ?></td>
				<td><?php echo $status; ?></td>
				<td><?php echo $prodi; ?></td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
</body>
</html>
<?php
	}
	
	public function cetak_pdfbuku(){
		extract($this->prepare_get(array('kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		
		$r=array();
		if(empty($jenis)){
			$hasil=$this->db->query("select * from tbl_buku where kode_buku like '%{$kata}%' or isbn_buku like '%{$kata}%' or judul_buku like '%{$kata}%' or pengarang_buku like '%{$kata}%'");
		}else if($jenis=="kode"){
			$hasil=$this->db->query("select * from tbl_buku where kode_buku like '%{$kata}%'");
		}else if($jenis=="isbn"){
			$hasil=$this->db->query("select * from tbl_buku where isbn_buku like '%{$kata}%'");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("select * from tbl_buku where judul_buku like '%{$kata}%'");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("select * from tbl_buku where pengarang_buku like '%{$kata}%'");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("select * from tbl_buku where penerbit_buku like '%{$kata}%'");
		}
?>
	<p>DATA BUKU</p>
	<table border="1" style="border-collapse: collapse;" cellpadding="3" cellspacing="2" width="100%">
		<thead>
			<tr>
				<th>NO.</th>
				<th>KODE BUKU</th>
				<th>ISBN BUKU</th>
				<th>SAMPUL BUKU</th>
				<th>JUDUL</th>
				<th>PENGARANG</th>
				<th>PENEMPATAN</th>
				<th>MACAM</th>
				<th>BAHASA</th>
				<th>PENERBIT</th>
				<th>TAHUN TERBIT</th>
				<th>TERPINJAM</th>
			</tr>
		</thead>
		<tbody>
<?php
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$no=$i+1;
			$id=$d->id_buku;
			$kode=$d->kode_buku;
			$isbn=$d->isbn_buku;
			$sampul=$d->sampul_buku;
			$judul=$d->judul_buku;
			$pengarang=$d->pengarang_buku;
			$macam=$d->macam_buku;
			$bahasa=$d->bahasa_buku;
			$pn=$d->no_penempatan;
			$penerbit=$d->penerbit_buku;
			$tahun=$d->tahun_terbit_buku;	
			$ambiljml=$this->db->query("select count(id_buku) as jumlah from tbl_detail_peminjaman where id_buku='$id'",true);
			$jumlah=$ambiljml->jumlah;
?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $kode; ?></td>
				<td><?php echo $isbn; ?></td>
				<td><img src="../<?php echo $sampul?>" width="50px" height="50px"></td>
				<td><?php echo $judul; ?></td>
				<td><?php echo $pengarang; ?></td>
				<td><?php echo $pn; ?></td>
				<td><?php echo $macam; ?></td>
				<td><?php echo $bahasa; ?></td>
				<td><?php echo $penerbit; ?></td>
				<td><?php echo $tahun; ?></td>
				<td><?php echo $jumlah; ?></td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
<?php
	}
	
	public function cetak_pdffile(){
		extract($this->prepare_get(array('kata','jenis')));
		$kata=$this->db->escape_str($kata);
		$jenis=$this->db->escape_str($jenis);
		
		$r=array();
		if(empty($jenis)){
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' or pengarang_file like '%{$kata}%' or penerbit_file like '%{$kata}%' order by tgl_upload desc ");
		}else if($jenis=="judul"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where judul_file like '%{$kata}%' order by tgl_upload desc ");
		}else if($jenis=="pengarang"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where pengarang_file like '%{$kata}%' order by tgl_upload desc");
		}else if($jenis=="penerbit"){
			$hasil=$this->db->query("SELECT * FROM tbl_file where penerbit_file like '%{$kata}%' limit order by tgl_upload desc ");
		}
?>
	<p>DATA FILE</p>
	<table border="1" style="border-collapse: collapse;" cellpadding="3" cellspacing="2" width="100%">
		<thead>
			<tr>
				<th>NO.</th>
				<th>SAMPUL</th>
				<th>JUDUL</th>
				<th>PENGARANG</th>
				<th>MACAM</th>
				<th>BAHASA</th>
				<th>PENERBIT</th>
				<th>TAHUN TERBIT</th>
				<th>PENG-UPLOAD</th>
				<th>TGL UPLOAD</th>
				<th>TER-UNDUH</th>
			</tr>
		</thead>
		<tbody>
<?php
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$no=$i+1;
			$kode=$d->kode_file;
			$ambiljml=$this->db->query("select count(kode_file) as jumlah from tbl_aktivitas where kode_file='$kode'",true);
			$jumlah=$ambiljml->jumlah;
			$idpt=$d->id_petugas;
			$idan=$d->id_anggota;
			$sampul=$d->sampul_file;
			$judul=$d->judul_file;
			$pengarang=$d->pengarang_file;
			$macam=$d->macam_file;
			$bahasa=$d->bahasa_file;
			$penerbit=($d->penerbit_file == '' ? '-' : $d->penerbit_file);
			$tahun=$d->tahun_terbit_file;
			$tgl=date('d-m-Y', strtotime($d->tgl_upload));
				
			if($idpt==0){
				$ambilnm=$this->db->query("select nama_anggota from tbl_anggota where id_anggota='$idan'",true);
				$nama=$ambilnm->nama_anggota;
			}else{
				$ambilnm=$this->db->query("select nama_petugas from tbl_petugas where id_petugas='$idpt'",true);
				$nama=$ambilnm->nama_petugas;
			}
			$idupload=($d->id_petugas != '0' ? $d->id_petugas : $d->id_anggota);
			$status=($d->id_petugas != '0' ? 'Petugas' : 'Dosen');
	
?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><img src="../<?php echo $sampul?>" width="50px" height="50px"></td>
				<td><?php echo $judul; ?></td>
				<td><?php echo $pengarang; ?></td>
				<td><?php echo $macam; ?></td>
				<td><?php echo $bahasa; ?></td>
				<td><?php echo $penerbit; ?></td>
				<td><?php echo $tahun; ?></td>
				<td><?php echo $idupload." / ".$nama." / ".$status; ?></td>
				<td><?php echo $tgl; ?></td>
				<td><?php echo $jumlah; ?></td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>

<?php
	}
	
	public function cetak_pdfpeminjaman(){
		extract($this->prepare_get(array('status','tgl','noid','bulan', 'kdbuku', 'jdbuku')));
		$status=$this->db->escape_str($status);
		$noid=$this->db->escape_str($noid);
		$jdbuku=$this->db->escape_str($jdbuku);
		
		$r=array();
		$ambilbyr=$this->db->query("select * from tbl_pengaturan",true);
		$bayar=$ambilbyr->bayar_denda;
		
		$hasil=$this->db->query("select * from tbl_detail_peminjaman");
		if(!empty ($status)){
			$tgl="0000-00-00";
			if($status=="dipinjam"){
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pengembalian='$tgl' ");
			}else if($status=="dikembalikan"){
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pengembalian!='$tgl' ");
			}else if($status=="terlambat"){
				$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_kembali < curdate() and tgl_pengembalian='$tgl' ");
			}
		}else if(!empty($tgl)){
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where tgl_pinjam='$tgl' ");
		}else if(!empty($bulan)){
			$thn=substr($bulan,0,4);
			$bln=substr($bulan,5,2);
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where MONTH(tgl_pinjam)='$bln' and YEAR(tgl_pinjam)='$thn' ");
		}else if(!empty($noid)){
			$ambilid=$this->db->query("select id_anggota from tbl_anggota where no_identitas='$noid'",true);
			$idan=$ambilid->id_anggota;
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_anggota='$idan' ");
		}else if(!empty($kdbuku)){
			$ambilid=$this->db->query("select id_buku from tbl_buku where kode_buku='$kdbuku'",true);
			$idbk=$ambilid->id_buku;
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$idbk' ");
		}else if(!empty($jdbuku)){
			$ambilid=$this->db->query("select id_buku from tbl_buku where judul_buku='$jdbuku'",true);
			$jdbk=$ambilid->id_buku;
			$hasil=$this->db->query("select * from tbl_detail_peminjaman where id_buku='$jdbk'");
		}
?>
	<p>DATA PEMINJAMAN</p>
	<table border="1" style="border-collapse: collapse;" cellpadding="3" cellspacing="2" width="100%">
		<thead>
			<tr>
				<th>NO.</th>
				<th>TGL PINJAM</th>
				<th>TGL KEMBALI</th>
				<th>TGL PENGEMBALIAN</th>
				<th>NO IDENTITAS</th>
				<th>NAMA</th>
				<th>KODE BUKU</th>
				<th>JUDUL</th>
				<th>DENDA</th>
			</tr>
		</thead>
		<tbody>
<?php
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$no=$i+1;
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
			
			$tgl_pinjam=datedb_to_tanggal($d->tgl_pinjam, 'd-F-Y');
			$tgl_kembali=($d->tgl_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_kembali, 'd-F-Y'));
			$tgl_pengembalian2 = ($d->tgl_pengembalian == '0000-00-00' ? '-' : datedb_to_tanggal($d->tgl_pengembalian, 'd-F-Y'));
?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $tgl_pinjam; ?></td>
				<td><?php echo $tgl_kembali; ?></td>
				<td><?php echo $tgl_pengembalian2; ?></td>
				<td><?php echo $noid; ?></td>
				<td><?php echo $nama; ?></td>
				<td><?php echo $kode_buku; ?></td>
				<td><?php echo $judul; ?></td>
				<td><?php echo $denda; ?></td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
		
<?php
	}
	
	public function cetak_pdfkas(){
		extract($this->prepare_get(array('tgl','bulan','tahun')));
		$denda=0;
		$total_denda=0;
		$r=array();
		$hasil=$this->db->query("select * from tbl_denda order by tanggal_bayar");
		if(!empty($tgl)){
			$hasil=$this->db->query("select * from tbl_denda where tanggal_bayar='$tgl' order by tanggal_bayar");
		}else if(!empty($bulan)){
			$thn=substr($bulan,0,4);
			$bln=substr($bulan,5,2);
			$hasil=$this->db->query("select * from tbl_denda where MONTH(tanggal_bayar)='$bln' and YEAR(tanggal_bayar)='$thn' order by tanggal_bayar");
		}else if(!empty($tahun)){
			$hasil=$this->db->query("select * from tbl_denda where YEAR(tanggal_bayar)='$tahun' order by tanggal_bayar");
		}
	
	?>
	<p>DATA KAS</p>
	<table border="1" style="border-collapse: collapse;" cellpadding="3" cellspacing="2" width="100%">
		<thead>
			<tr>
				<th>NO.</th>
				<th>TGL BAYAR</th>
				<th>NO IDENTITAS</th>
				<th>NAMA</th>
				<th>TGL PINJAM</th>
				<th>TGL KEMBALI</th>
				<th>DENDA</th>
			</tr>
		</thead>
		<tbody>
<?php
		for($i=0;$i<count($hasil);$i++){
			$d=$hasil[$i];
			$no=$i+1;
			$iddet=$d->id_detail_peminjaman;
			$ambildet=$this->db->query("select * from tbl_detail_peminjaman where id_detail_peminjaman='$iddet'",true);
			$idang=$ambildet->id_anggota;
				
			$ambilan=$this->db->query("select * from tbl_anggota where id_anggota='".$idang."'", true);
			$nama = $ambilan-> nama_anggota;
			$noid = $ambilan->no_identitas;
			
			$denda=$d->denda;
			$total_denda+=$denda;
			$tgl_pinjam=datedb_to_tanggal($ambildet->tgl_pinjam, 'd-F-Y');
			$tgl_kembali=($d->tanggal_kembali == '0000-00-00' ? '-' : datedb_to_tanggal($d->tanggal_kembali, 'd-F-Y'));
			$tgl_bayar=($d->tanggal_bayar == '0000-00-00' ? '-' : datedb_to_tanggal($d->tanggal_bayar, 'd-F-Y'));
?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $tgl_bayar; ?></td>
				<td><?php echo $noid; ?></td>
				<td><?php echo $nama; ?></td>
				<td><?php echo $tgl_pinjam; ?></td>
				<td><?php echo $tgl_kembali; ?></td>
				<td><?php echo $denda; ?></td>
			</tr>
<?php
		}
?>
			<tr>
				<td colspan="6" align="right"> Total Denda : </td>
				<td><?php echo $total_denda; ?></td>
			</tr>
		</tbody>
	</table>
<?php
	}
}
?>