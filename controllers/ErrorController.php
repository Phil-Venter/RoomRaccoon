<?php

class ErrorController
{
	public static function error($req, $res) {
		return $res->view('error', [
			'code' => $res->code,
		]);
	}
}