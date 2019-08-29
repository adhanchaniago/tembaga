<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tanggal_indo'))
{
	function tanggal_indo($tanggal){
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		if($tanggal != 0){
		$split = explode('-', $tanggal);
		return $split[2] . '-' . $bulan[ (int)$split[1] ] . '-' . $split[0];
		}else{
		return '-';
		}
	}
}