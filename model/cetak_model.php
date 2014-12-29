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
	
	<table style="border-collapse: collapse;" cellpadding="2" cellspacing="2" width="200px">
		<tr style="border-top: .8mm solid #000; border-left: .8mm solid #000; border-right: .8mm solid #000; border-right: .8mm solid #000;">
			<td rowspan="4" style="border-bottom: .8mm solid #000;" height="120px" width="" >
				<img src="/barcode/B012.png" style="-moz-transform: rotate(270deg); -o-transform: rotate(270deg); -webkit-transform: rotate(270deg); transform: rotate(270deg);">
			</td>
			<td rowspan="4" style="border-bottom: .8mm solid #000;" >
				<p style="-moz-transform: rotate(270deg); -o-transform: rotate(270deg); -webkit-transform: rotate(270deg); transform: rotate(270deg);"> <?php echo $kode; ?></p>
			</td>
			<td><?php echo $a[0]; ?></td>
		</tr>
		<tr style="border-right: .8mm solid #000;">
			<td><?php echo $a[1]; ?> </td>
		</tr>
		<tr style="border-right: .8mm solid #000;">
			<td><?php echo $a[2]; ?></td>
		</tr>
		<tr style="border-right: .8mm solid #000; border-bottom: .8mm solid #000;">
			<td><?php echo "C1"; ?></td>
		</tr>
	</table>
	
	<script>
$(window).load(function(){
	//window.print();
	//window.close();
});
//window.close();
	</script>
<?php
	}	
}