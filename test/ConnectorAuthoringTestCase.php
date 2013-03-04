<?php
require_once dirname(__FILE__) . '/../../wfEngine/test/wfEngineServiceTest.php';
/*
require_once dirname(__FILE__) . '/../../tao/test/TaoTestRunner.php';
include_once dirname(__FILE__) . '/../includes/raw_start.php';
*/
class ConnectorAuthoringTestCase extends wfEngineServiceTest {
	
	/**
	 * @var wfAuthoring_models_classes_ConnectorService
	 */
	private $service;
	
	/**
	 * tests initialization
	 */
	public function setUp(){
		parent::setUp();
		TaoTestRunner::initTest();
		
		$this->service = wfAuthoring_models_classes_ConnectorService::singleton();
	}
	
	
	public function testSequential(){
		$process = wfAuthoring_models_classes_ProcessService::singleton()->createProcess('Scripted Process');
	
		$activityAuthoring = wfAuthoring_models_classes_ActivityService::singleton();
		
		$webservice = new core_kernel_classes_Resource('http://www.tao.lu/Ontologies/TAODelivery.rdf#ServiceWebService');
		$activity = array();
		for ($i = 1; $i <= 5; $i++) {
			$activity[$i] = $activityAuthoring->createFromServiceDefinition($process, $webservice, array());
		}
		
		wfAuthoring_models_classes_ProcessService::singleton()->setFirstActivity($process, $activity[1]);
		
		$this->service->createSequential($activity[1], $activity[2]);
		$con1 = $this->service->createConnector($activity[2]);
		$this->service->createSequential($con1, $activity[3]);
		$this->service->createSequential($activity[3], $activity[4]);
		
		$this->runProcess($process);
		
		wfAuthoring_models_classes_ProcessService::singleton()->deleteProcess($process);
	}
	
	private function runProcess($processDefinition) {
		$user = $this->createUser('timmy');
		$this->changeUser('timmy');
		$processExecutionService = wfEngine_models_classes_ProcessExecutionService::singleton();
		$processInstance = $processExecutionService->createProcessExecution($processDefinition, $processDefinition->getLabel().' instance', '');
		
		$currentActivityExecutions = $processExecutionService->getCurrentActivityExecutions($processInstance);
		while (count($currentActivityExecutions) > 0) {
			$current = array_shift($currentActivityExecutions);
			$transitionResult = $processExecutionService->performTransition($processInstance, $current);
			foreach ($transitionResult as $executed) {
				$this->assertTrue($executed->hasType(new core_kernel_classes_Class(CLASS_ACTIVITY_EXECUTION)));
			}
			$currentActivityExecutions = $processExecutionService->getCurrentActivityExecutions($processInstance);
		}
		$processExecutionService->deleteProcessExecution($processInstance);
		$user->delete();
	}
	
	public function tearDown() {
		parent::tearDown();
    }

}
?>