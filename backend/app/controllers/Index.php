<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

use BT\Controller\Page;
use BT\Validate\NotEmpty;
use BT\Query\Driver;

use Snitches\Service\Sync;

class IndexController extends Page {
	/**
	 * GET /
	 */
	public function index() {
		$response = $this->response();
		$response->render('index');
		return $response;
	}


	/**
	 * POST /api/sync
	 */
	public function sync() {
		$driver = new Driver($this->settings());
		$svc = new Sync($driver, $this->log());
		$svc->download($this->_settings);

		$response = $this->response();
		$response->redirect('/');
		return $response;
	}
}
