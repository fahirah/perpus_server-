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
}