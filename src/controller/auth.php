<?php
use App\Models\User;
use App\Models\Admin;
use App\Helper\JSON;

class Auth {

	private $request;
	private $app;

	function __construct($request, $app) {
		$this->request = $request;
		$this->app = $app;
	}

	public function doClientLogin() {
		$user = User::where('username', $this->request->userid)
			->where('password', $this->request->password)
			->with('client')
			->first();

        $this->app->sendToOrigin($this->request->method, $user);
	}

	public function doAdminLogin() {
		$user = Admin::where('username', $this->request->userid)
			->where('password', $this->request->password)
			->first();

        $this->app->sendToOrigin($this->request->method, $user);
	}
}

