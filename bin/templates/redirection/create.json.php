<?php

current_context()->response->getHeaders()->set('Access-Control-Allow-Origin', '*');
current_context()->response->getHeaders()->set('Access-Control-Allow-Headers', 'Content-type');

echo json_encode([
	'status' => 'OK',
	'payload' => [
		'id' => $redirect->_id,
		'email' => $redirect->alias
	]
]);
