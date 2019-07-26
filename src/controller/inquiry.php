<?php
use App\Models\Inquiry;
use App\Helper\JSON;

class Inquiries {

	private $request;
	private $app;

	function __construct($request, $app) {
		$this->request = $request;
		$this->app = $app;
	}

	public function save() {
		$inquiry = new Inquiry();
		$inquiry->inq_fname = $this->request->fname;
		$inquiry->inq_lname = $this->request->lname;
		$inquiry->message = $this->request->message;
		$inquiry->contact = $this->request->contact;
		$inquiry->email = $this->request->email;
		$inquiry->save();
		
        $this->app->sendToClientsExceptOrigin($this->request->method, $inquiry);
	}

	public function getInquiries() {
		$inquiries = Inquiry::all();
		
        $this->app->sendToOrigin($this->request->method, $inquiries);
	}
}

