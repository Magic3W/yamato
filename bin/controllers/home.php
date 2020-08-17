<?php

/**
 * Prebuilt test controller. Use this to test all the components built into
 * for right operation. This should be deleted whe using Spitfire.
 */

class HomeController extends BaseController
{
	public function index() {
		if ($this->user) {
			return $this->response->setBody('Redirecting...')->getHeaders()->redirect(url('redirection', 'create'));
		}
	}
}
