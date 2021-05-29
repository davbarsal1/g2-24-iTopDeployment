<?php


namespace Combodo\iTop\Test\UnitTest\Setup;

use Combodo\iTop\Test\UnitTest\ItopTestCase;
use SetupUtils;


/**
 * Class SetupUtilsTest
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 * @backupGlobals disabled
 *
 * @covers SetupUtils
 *
 * @since 2.7.4 N°3412
 * @package Combodo\iTop\Test\UnitTest\Setup
 */
class SetupUtilsTest extends ItopTestCase
{
	const ERROR = 0;
	const WARNING = 1;
	const INFO = 2;
	const TRACE = 3; // for log purposes : replace old SetupLog::Log calls

	protected function setUp()
	{
		parent::setUp();

		require_once APPROOT.'setup/setuputils.class.inc.php';
		require_once APPROOT.'setup/setuppage.class.inc.php';
	}

	/**
	 * @dataProvider CheckGraphvizProvider
	 */
	public function testCheckGraphviz($sScriptPath, $iSeverity, $sLabel){
		/** @var \CheckResult $oCheck */
		$aCheck = SetupUtils::CheckGraphviz($sScriptPath);
		$bLabelFound = false;
		foreach ($aCheck as $oCheck) {
			$this->assertGreaterThanOrEqual($iSeverity, $oCheck->iSeverity);
			if (!$bLabelFound && (empty($sLabel) || strpos($oCheck->sLabel, $sLabel) !== false)) {
				$bLabelFound = true;
			}
		}
		$this->assertTrue($bLabelFound, "label '$sLabel' not found");
	}

	public function CheckGraphvizProvider(){
		if (substr(PHP_OS,0,3) === 'WIN'){
			return [];
		}

		return [
			"bash injection" => [
				"touch /tmp/toto",
				self::WARNING,
				"could not be executed: Please make sure it is installed and in the path",
			],
			"command ok" => [
				"/usr/bin/whereis",
				self::INFO,
				"",
			],
			"empty command => dot by default" => [
				"",
				self::INFO,
				"",
			],
			"command failed" => [
				"/bin/ls",
				self::WARNING,
				"dot could not be executed (retcode=2): Please make sure it is installed and in the path",
			]
		];
	}


}
