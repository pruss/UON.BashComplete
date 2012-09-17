<?php
namespace UON\BashComplete\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "UON.BashComplete".           *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Standard controller for the UON.BashComplete package 
 *
 * @FLOW3\Scope("singleton")
 */
class StandardController extends \TYPO3\FLOW3\Mvc\Controller\ActionController {

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('foos', array(
			'bar', 'baz'
		));
	}

}

?>