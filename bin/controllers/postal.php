<?php

use spitfire\core\Environment;
use spitfire\exceptions\PublicException;

class PostalController extends Controller
{

	/**
	 * This endpoint receives a email from the Postal HTTP route and temporarily stores
	 * it so it can be forwarded to the users receiving the email.
	 */
	public function put($psk) {

		if ($psk !== Environment::get('smtp.incoming.secret')) {
			throw new PublicException('Forbidden', 403);
		}
		
		/**
		 * It's entirely possible that the email we're receiving is a response to 
		 * an email that was sent by us. In this case, we want the email to be 
		 * directed to a catch-all address that can handle customer requests.
		 * 
		 * It'd be interesting to be able to track whether a message was actually
		 * a response to an email we delivered earlier and see if we can pull it 
		 * up.
		 */
		if ($_POST['rcpt_to'] === Environment::get('smtp.from')) {
			$targets     = explode(',', Environment::get('smtp.catchall'));
			$replyto     = $_POST['mail_from'];
		} 
		else {
			$redirection = db()->table('redirection')->get('alias', $_POST['rcpt_to'])->first(true);
			$targets     = db()->table('target')->get('redirection', $redirection)->where('since', '<', time())->where('until', '>', time())->all()->extract('to');
			$replyto     = Environment::get('smtp.from');
		}
		
		foreach ($targets as $target) {
			$post = Array();
			$post['from']       = Environment::get('smtp.from');
			$post['to']         = [$target];
			$post['reply_to']   = $replyto;
			$post['subject']    = $_POST['subject'];
			$post['plain_body'] = $_POST['plain_body'];
			$post['html_body']  = $_POST['html_body'];
			$post['attachments']  = array_map(function ($e) { $e['name'] = $e['filename']; return $e; }, $_POST['attachments']);
			
			#Assemble the curl request
			$ch = curl_init(sprintf('https://%s/api/v1/send/message', Environment::get('postal.domain')));
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Server-API-Key:' . Environment::get('postal.key'), 'Content-type: application/json']);
			
			#Tell curl we're posting and give it the data
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			
			#We also want to hear back
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$json     = curl_exec($ch);
			$status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$response = $json? json_decode($json) : false;
			
			if ($status !== 200) { throw new \spitfire\exceptions\PublicException('Postal failure. Status: ' . $status, 500); }
			if (!$response)      { throw new \spitfire\exceptions\PublicException('Invalid response from Postal'); }
		
		}

		die('OK');
	}
}
