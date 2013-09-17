<?php
require_once dirname(__FILE__) . '/../../tao/test/TaoTestRunner.php';
include_once dirname(__FILE__) . '/../includes/raw_start.php';

class ProcessFlattenerTestCase extends UnitTestCase {
	
	
	protected $authoringService = null;
	protected $proc = null;
	protected $apiModel = null;
	
	/**
	 * tests initialization
	 */
	public function setUp(){
	    parent::setUp();
		TaoTestRunner::initTest();
	}

	public function testCreateServiceDefinition(){
	    $process1 = $this->createLinearProcess();
	    $arr = wfAuthoring_models_classes_ProcessService::singleton()->getRootActivities($process1);
	    $this->assertEqual(count($arr), 1);
	    $startP1 = current($arr);
	    $process2 = $this->createLinearProcess();
	    $process3 = $this->createLinearProcess();
	    
	    $super1 = $this->createLinearSuperProcess(array($process1));
	    $flattener = new wfAuthoring_models_classes_ProcessFlattener($super1);
	    $flattener->flatten();
	    $arr = wfAuthoring_models_classes_ProcessService::singleton()->getRootActivities($super1);
	    $this->assertEqual(count($arr), 1);
	    $start = current($arr);
	    //var_dump($start);
	    //var_dump($startP1);
	    wfAuthoring_models_classes_ProcessService::singleton()->deleteProcess($super1);
	    
	    $super3 = $this->createLinearSuperProcess(array($process1, $process2, $process3));
	    $flattener = new wfAuthoring_models_classes_ProcessFlattener($super3);
	    $flattener->flatten();
	    wfAuthoring_models_classes_ProcessService::singleton()->deleteProcess($super3);
	     
	    wfAuthoring_models_classes_ProcessService::singleton()->deleteProcess($process1);
	    wfAuthoring_models_classes_ProcessService::singleton()->deleteProcess($process2);
	    wfAuthoring_models_classes_ProcessService::singleton()->deleteProcess($process3);
	     
	}
	
	protected function createLinearProcess() {
	    $processDefinitionClass = new core_kernel_classes_Class(CLASS_PROCESS);
	    $processDefinition = $processDefinitionClass->createInstance('process for '.__CLASS__);
	    $this->assertIsA($processDefinition, 'core_kernel_classes_Resource');
	     
	    $activityService = wfAuthoring_models_classes_ActivityService::singleton();
	    $connectorService = wfAuthoring_models_classes_ConnectorService::singleton();
	    $webService = new core_kernel_classes_Resource('http://www.tao.lu/Ontologies/TAO.rdf#ServiceWebService');
	     
	    $activity1 = $activityService->createFromServiceDefinition($processDefinition, $webService);
	    $this->assertTrue($activity1->exists());
	    $activity2 = $activityService->createFromServiceDefinition($processDefinition, $webService);
	    $activity3 = $activityService->createFromServiceDefinition($processDefinition, $webService);
	    
	    $activity1->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_ISINITIAL), GENERIS_TRUE);
	    $connectorService->createSequential($activity1, $activity2);
	    $connectorService->createSequential($activity2, $activity3);
	    return $processDefinition;
	}
	
	protected function createLinearSuperProcess($processes) {
	    $processDefinitionClass = new core_kernel_classes_Class(CLASS_PROCESS);
	    $processDefinition = $processDefinitionClass->createInstance('process for '.__CLASS__);
	    $this->assertIsA($processDefinition, 'core_kernel_classes_Resource');
	    
	    $activityService = wfAuthoring_models_classes_ActivityService::singleton();
	    $connectorService = wfAuthoring_models_classes_ConnectorService::singleton();
	    $processRunnerService = new core_kernel_classes_Resource(INSTANCE_SERVICE_PROCESSRUNNER);
	    $processRunnerParam = new core_kernel_classes_Resource(INSTANCE_FORMALPARAM_PROCESSDEFINITION);
	    
	    $last = null;
	    foreach ($processes as $subProcess) {
	        $serviceCall = new tao_models_classes_service_ServiceCall($processRunnerService);
	        $serviceCall->addInParameter(new tao_models_classes_service_ConstantParameter($processRunnerParam, $subProcess));
	        $current = $activityService->createActivity($processDefinition);
	        $current->setPropertyValue(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_INTERACTIVESERVICES), $serviceCall->toOntology());
	        if (is_null($last)) {
	            $current->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_ISINITIAL), GENERIS_TRUE);
	        } else {
	            $connectorService->createSequential($last, $current);
	        }
	        $last = $current;
	    }
	    return $processDefinition;
	}
	
}