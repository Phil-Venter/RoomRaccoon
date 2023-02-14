<?php

class Error
{
	public static function error($req, $res) {
		$res->output = $req->error;
	}
}