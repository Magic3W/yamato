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
				
				/**
				 * We do not accept stuff that does not validate as email. This
				 * way we make sure we can send to all the recipients of a redirection.
				 */
				if (!filter_var($target['email'], FILTER_VALIDATE_EMAIL)) {
					continue;
				}
				
				$dbtarget = db()->table('target')->newRecord();
				$dbtarget->redirection = $redirect;
				$dbtarget->to = $target['email'];
				$dbtarget->since = Strings::startsWith($target['since'], '+')? time() + substr($target['since'], 1) : $target['since'];
				$dbtarget->until = Strings::startsWith($target['until'], '+')? time() + substr($target['until'], 1) : $target['until'];
				$dbtarget->store();
			}

			$this->view->set('redirect', $redirect);
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
