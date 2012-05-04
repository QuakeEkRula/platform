<?php
$elements_data = AdminHelper::getElementsData();
$effective_user = AdminHelper::getPersistentData('cash_effective_user');

if ($request_parameters) {
	$page_request = new CASHRequest(
		array(
			'cash_request_type' => 'element', 
			'cash_action' => 'getelement',
			'id' => $request_parameters[0]
		)
	);
	if ($page_request->response['payload']['user_id'] == $effective_user) {
		$cash_admin->page_data['title'] = 'Elements: View “' . $page_request->response['payload']['name'] . '”';
		
		$element_type = $page_request->response['payload']['type'];
		$page_tips = 'More soon.';
		
		$cash_admin->requestAndStore(
			array(
				'cash_request_type' => 'element', 
				'cash_action' => 'getanalytics',
				'analtyics_type' => 'elementbylocation',
				'element_id' => $request_parameters[0],
				'user_id' => AdminHelper::getPersistentData('cash_effective_user')
			),
			'elementbylocation'
		);
		
		$cash_admin->requestAndStore(
			array(
				'cash_request_type' => 'element', 
				'cash_action' => 'getanalytics',
				'analtyics_type' => 'elementbymethod',
				'element_id' => $request_parameters[0],
				'user_id' => AdminHelper::getPersistentData('cash_effective_user')
			),
			'elementbymethod'
		);
	} else {
		// var_dump($page_request->response);
		header('Location: ' . ADMIN_WWW_BASE_PATH . '/elements/view/');
	}
} else {
	$cash_admin->requestAndStore(
		array(
			'cash_request_type' => 'element', 
			'cash_action' => 'getelementsforuser',
			'user_id' => AdminHelper::getPersistentData('cash_effective_user')
		),
		'getelementsforuser'
	);
}
?>