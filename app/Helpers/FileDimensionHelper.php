<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 08/01/18
 * Time: 18:49
 */

namespace App\Helpers;


class FileDimensionHelper
{
	public static function bytesToHuman($bytes)
	{
		$units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

		for ($i = 0; $bytes > 1024; $i++) {
			$bytes /= 1024;
		}

		return round($bytes, 2) . ' ' . $units[$i];
	}
}