<?php

use App\Models\Agent;
use App\Helper\JSON;

class Agents {

	private $request;
	private $app;

	function __construct($request, $app) {
		$this->request = $request;
		$this->app = $app;
	}

	public function getAgents() {
		$agents = Agent::all();
        $this->app->sendToOrigin($this->request->method, $agents);
	}
}