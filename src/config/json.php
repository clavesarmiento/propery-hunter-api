<?php

namespace App\Helper;

class JSON {

	public static function encode($data) {
		return json_encode($data);
	}


	public static function decode($data) {
		return json_decode($data);
	}
}