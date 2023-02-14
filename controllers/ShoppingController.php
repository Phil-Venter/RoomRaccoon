<?php

class ShoppingController
{
	public static function index($req, $res) {
		$shopping = (new Shopping())->all();
		return $res->view('shopping', [
			'name' => 'Philip'
		]);
	}

	public static function create($req, $res) {
		$res->redirect('/');
	}
	public static function update($req, $res) {
		$res->redirect('/');
	}
	public static function destroy($req, $res) {
		$res->redirect('/');
	}
}