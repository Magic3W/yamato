<?php

use spitfire\core\Environment;
use spitfire\exceptions\HTTPMethodException;
use spitfire\exceptions\PublicException;

class RedirectionController extends BaseController
{

	public function create() {

		if (!$this->user) {
			return $this->response->setBody('Redirecting...')->getHeaders()->redirect(url('account', 'login'));
		}

		try {
			if (!$this->request->isPost()) { throw new HTTPMethodException('Not POSTED'); }
			
			do {
				$t = sprintf('%s@%s', uniqid(), Environment::get('smtp.incoming.domain'));
			} 
			while(db()->table('redirection')->get('alias', $t)->first());

			$dbuser = UserModel::get($this->user->id);
			
			$redirect = db()->table('redirection')->newRecord();
			$redirect->user = $dbuser;
			$redirect->alias = $t;
			$redirect->store();

			foreach ($_POST['targets'] as $target) {
				$dbtarget = db()->table('target')->newRecord();
				$dbtarget->redirection = $redirect;
				$dbtarget->to = $target['email'];
				$dbtarget->since = $target['since'];
				$dbtarget->until = $target['until'];
				$dbtarget->store();
			}

			$this->response->setBody('Redirect')->getHeaders()->redirect(url('redirection', 'show', $redirect->_id));
			return;
		}
		catch (HTTPMethodException $e) {
			/*Do nothing, show the form */
		}
	}

	public function index() {
		if (!$this->user) {
			return $this->response->setBody('Redirecting...')->getHeaders()->redirect(url('account', 'login'));
		}

		$redirections = db()->table('redirection')->getAll()->setOrder('_id', 'DESC')->range(0, 100);

		$this->view->set('redirections', $redirections);
	}
	
	public function show(RedirectionModel $redirection) {
		if (!$this->user) {
			return $this->response->setBody('Redirecting...')->getHeaders()->redirect(url('account', 'login'));
		}

		$this->view->set('redirection', $redirection);
	}

}
