<?php
/**
 * BaserTestSuiteDispatcher
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 *
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.TestSuite
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */

require_once CAKE . 'TestSuite' . DS . 'CakeTestSuiteDispatcher.php';
App::uses('BaserTestSuiteCommand', 'TestSuite');

/**
 * CakeTestSuiteDispatcher handles web requests to the test suite and runs the correct action.
 *
 * @package Baser.Lib.TestSuite
 */
class BaserTestSuiteDispatcher extends CakeTestSuiteDispatcher {

/**
 * 'Request' parameters
 *
 * @var array
 */
	public $params = array(
		'codeCoverage' => false,
		'case' => null,
		'core' => false,
		// CUSTOMIZE ADD 2014/07/02 ryuring
		// >>>
		'baser' => false,
		// <<<
		'app' => true,
		'plugin' => null,
		'output' => 'html',
		'show' => 'groups',
		'show_passes' => false,
		'filter' => false,
		'fixture' => null
	);

/**
 * Static method to initialize the test runner, keeps global space clean
 *
 * @return void
 */
	public static function run() {
		// CUSTOMIZE MODIFY 2014/07/02 ryuring
		// >>>
		//$dispatcher = new CakeTestSuiteDispatcher();
		// ---
		$dispatcher = new BaserTestSuiteDispatcher();
		// <<<
		$dispatcher->dispatch();
	}

/**
 * Generates a page containing the a list of test cases that could be run.
 *
 * @return void
 */
	protected function _testCaseList() {
		// CUSTOMIZE MODIFY 2014/07/02 ryuring
		// >>>
		//$command = new CakeTestSuiteCommand('', $this->params);
		// ---
		$command = new BaserTestSuiteCommand('', $this->params);
		// <<<
		$Reporter = $command->handleReporter($this->params['output']);
		$Reporter->paintDocumentStart();
		$Reporter->paintTestMenu();
		$Reporter->testCaseList();
		$Reporter->paintDocumentEnd();
	}

/**
 * Runs a test case file.
 *
 * @return void
 */
	protected function _runTestCase() {
		$commandArgs = array(
			'case' => $this->params['case'],
			'core' => $this->params['core'],
			// CUSTOMIZE ADD 2014/07/02 ryuring
			// >>>
			'baser' => $this->params['baser'],
			// <<<
			'app' => $this->params['app'],
			'plugin' => $this->params['plugin'],
			'codeCoverage' => $this->params['codeCoverage'],
			'showPasses' => !empty($this->params['show_passes']),
			'baseUrl' => $this->_baseUrl,
			'baseDir' => $this->_baseDir,
		);

		$options = array(
			'--filter', $this->params['filter'],
			'--output', $this->params['output'],
			'--fixture', $this->params['fixture']
		);
		restore_error_handler();

		try {
			self::time();
			// CUSTOMIZE MODIFY 2014/07/02 ryuring
			// >>>
			/*$command = new CakeTestSuiteCommand('CakeTestLoader', $commandArgs);
			$command->run($options);*/
			// ---
			$command = new BaserTestSuiteCommand('BaserTestLoader', $commandArgs);
			$result = $command->run($options);
			// <<<
		} catch (MissingConnectionException $exception) {
			ob_end_clean();
			$baseDir = $this->_baseDir;
			include CAKE . 'TestSuite' . DS . 'templates' . DS . 'missing_connection.php';
			exit();
		}
	}

/**
 * Parse URL params into a 'request'
 *
 * @return void
 */
	protected function _parseParams() {
		if (!$this->_paramsParsed) {
			if (!isset($_SERVER['SERVER_NAME'])) {
				$_SERVER['SERVER_NAME'] = '';
			}
			foreach ($this->params as $key => $value) {
				if (isset($_GET[$key])) {
					$this->params[$key] = $_GET[$key];
				}
			}
			if (isset($_GET['code_coverage'])) {
				$this->params['codeCoverage'] = true;
				$this->_checkXdebug();
			}
		}
		// CUSTOMIZE MODIFY 2014/07/02 ryuirng
		// >>>
		//if (empty($this->params['plugin']) && empty($this->params['core'])) {
		// ---
		if (empty($this->params['plugin']) && empty($this->params['core']) && empty($this->params['baser'])) {
		// <<<
			$this->params['app'] = true;
		}
		$this->params['baseUrl'] = $this->_baseUrl;
		$this->params['baseDir'] = $this->_baseDir;
	}

}
