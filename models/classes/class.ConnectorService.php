<?php

error_reporting(E_ALL);

/**
 * TAO - wfAuthoring/models/classes/class.ConnectorService.php
 *
 * $Id$
 *
 * This file is part of TAO.
 *
 * Automatically generated on 29.10.2012, 16:38:08 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 * @package wfAuthoring
 * @subpackage models_classes
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * Connector Services
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 */
require_once('wfEngine/models/classes/class.ConnectorService.php');

/* user defined includes */
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBE-includes begin
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBE-includes end

/* user defined constants */
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBE-constants begin
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBE-constants end

/**
 * Short description of class wfAuthoring_models_classes_ConnectorService
 *
 * @access public
 * @author Joel Bout, <joel.bout@tudor.lu>
 * @package wfAuthoring
 * @subpackage models_classes
 */
class wfAuthoring_models_classes_ConnectorService
    extends wfEngine_models_classes_ConnectorService
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Short description of method createConnector
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource sourceStep
     * @param  string label
     * @return core_kernel_classes_Resource
     */
    public function createConnector( core_kernel_classes_Resource $sourceStep, $label = '')
    {
        $returnValue = null;

        // section 10-30-1--78-4ca28256:13aace225cc:-8000:0000000000003BF9 begin
		$label = empty($label) ? $sourceStep->getLabel()."_c" : $label; 
		
		$connectorClass = new core_kernel_classes_Class(CLASS_CONNECTORS);
		$returnValue = $connectorClass->createInstance($label, "created by ProcessService.Class");
		
		if (is_null($returnValue)) {
			throw new Exception("the connector cannot be created for the activity {$activity->getUri()}");
		}
		$activityService = wfEngine_models_classes_ActivityService::singleton();
		$connectorService = wfEngine_models_classes_ConnectorService::singleton();

		//associate the connector to the activity
		$sourceStep->setPropertyValue(new core_kernel_classes_Property(PROPERTY_STEP_NEXT), $returnValue);

		//set the activity reference of the connector:
		$activityRefProp = new core_kernel_classes_Property(PROPERTY_CONNECTORS_ACTIVITYREFERENCE);
		if($activityService->isActivity($sourceStep)){
			$returnValue->setPropertyValue($activityRefProp, $sourceStep);
		}elseif($connectorService->isConnector($sourceStep)){
			$returnValue->setPropertyValue($activityRefProp, $sourceStep->getUniquePropertyValue($activityRefProp));
		}else{
			throw new Exception("invalid resource type for the activity parameter: {$sourceStep->getUri()}");
		}
        // section 10-30-1--78-4ca28256:13aace225cc:-8000:0000000000003BF9 end

        return $returnValue;
    }

    /**
     * Short description of method createConditional
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource from
     * @param  Expression condition
     * @param  Resource then
     * @param  Resource else
     * @return core_kernel_classes_Resource
     */
    public function createConditional( core_kernel_classes_Resource $from,  core_kernel_classes_Expression $condition,  core_kernel_classes_Resource $then,  core_kernel_classes_Resource $else = null)
    {
        $returnValue = null;

        // section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BC0 begin
		//Connector
		$authoringService = taoTests_models_classes_TestAuthoringService::singleton();
		$connector = $authoringService->createConnector($from);
		$connector->setPropertyValue(new core_kernel_classes_Property(PROPERTY_CONNECTORS_TYPE), INSTANCE_TYPEOFCONNECTORS_CONDITIONAL);

		//Rule
		$conditionRule = $authoringService->createConditionRuleFromXML($connector, $condition);
		$conditionRule->editPropertyValues(new core_kernel_classes_Property(PROPERTY_TRANSITIONRULES_THEN), $then->getUri());

		if (isset($else)) $conditionRule->editPropertyValues(new core_kernel_classes_Property(PROPERTY_TRANSITIONRULES_ELSE), $else->getUri());

		$returnValue = $connector;
        // section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BC0 end

        return $returnValue;
    }

    /**
     * Short description of method createTransitionRule
     *
     * @access private
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource connector
     * @param  Expression expression
     * @return core_kernel_classes_Resource
     */
    private function createTransitionRule( core_kernel_classes_Resource $connector,  core_kernel_classes_Expression $expression)
    {
        $returnValue = null;

        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BC5 begin
        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BC5 end

        return $returnValue;
    }

    /**
     * Short description of method createSequential
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource source
     * @param  Resource destination
     * @return core_kernel_classes_Resource
     */
    public function createSequential( core_kernel_classes_Resource $source,  core_kernel_classes_Resource $destination)
    {
        $returnValue = null;

        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BD3 begin
        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BD3 end

        return $returnValue;
    }

    /**
     * Short description of method createJoin
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  array sources
     * @param  Resource destination
     * @return core_kernel_classes_Resource
     */
    public function createJoin($sources,  core_kernel_classes_Resource $destination)
    {
        $returnValue = null;

        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BD7 begin
        foreach ($sources as $step) {
        	$followings = $step->getPropertyValues(new core_kernel_classes_Property(PROPERTY_STEP_NEXT));
        	if (count($followings) > 0) {
        		foreach ($followings as $followingUri) {
        			$following = new core_kernel_classes_Resource($followingUri);
        			if ($this->isConnector($following)) {
        				$this->delete($following);
        			} else {
        				throw new common_Exception('Step '.$step->getUri().' already has a non-connector attached');
        			}
        		}
        	}
		}
		
		$first = current($sources);
		$returnValue = $this->createConnector($first, "c_".$destination->getLabel());
		common_Logger::d('spawned connector '.$returnValue->getUri());
		$this->setConnectorType($returnValue, new core_kernel_classes_Resource(INSTANCE_TYPEOFCONNECTORS_JOIN));
		
		$first->removePropertyValues(new core_kernel_classes_Property(PROPERTY_STEP_NEXT));
		$returnValue->setPropertyValue(new core_kernel_classes_Property(PROPERTY_STEP_NEXT), $destination);
		common_Logger::d('removed previous connections, added next');
		
		
		foreach ($sources as $activity) {
			$flow = new wfEngine_models_classes_ProcessFlow();
			$multiplicity = $flow->getCardinality($activity);
			$cardinality = wfEngine_models_classes_ActivityCardinalityService::singleton()->createCardinality($returnValue, $multiplicity);
			$activity->setPropertyValue(new core_kernel_classes_Property(PROPERTY_STEP_NEXT), $cardinality);
			common_Logger::d('spawned cardinality '.$cardinality->getUri().' with value '.$multiplicity);
		}
        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BD7 end

        return $returnValue;
    }

    /**
     * Short description of method createSplit
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource source
     * @param  array destinations
     * @return core_kernel_classes_Resource
     */
    public function createSplit( core_kernel_classes_Resource $source, $destinations)
    {
        $returnValue = null;

        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BDB begin
        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BDB end

        return $returnValue;
    }

    /**
     * Short description of method setSplitVariables
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource connector
     * @param  array variables
     * @return boolean
     */
    public function setSplitVariables( core_kernel_classes_Resource $connector, $variables)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BEA begin
    	if($this->getType($connector)->getUri() == INSTANCE_TYPEOFCONNECTORS_PARALLEL){
			$cardinalityService = wfEngine_models_classes_ActivityCardinalityService::singleton();
			foreach($this->getNextActivities($connector) as $cardinality){
				
				if($cardinalityService->isCardinality($cardinality)){
					
					//find the right cardinality resource (according to the activity defined in the connector):
					$activity = $cardinalityService->getDestination($cardinality);
					if(!is_null($activity) && isset($variables[$activity->getUri()])){
						$returnValue = $cardinalityService->editSplitVariables($cardinality, $variables[$activity->getUri()]);
					}
				}
				
			}
		
		}
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BEA end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setConnectorType
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource connector
     * @param  Resource type
     * @return boolean
     */
    public function setConnectorType( core_kernel_classes_Resource $connector,  core_kernel_classes_Resource $type)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BE6 begin
        
        //@TODO: check range of type of connectors:
		$returnValue = $connector->editPropertyValues(new core_kernel_classes_Property(PROPERTY_CONNECTORS_TYPE), $type->getUri());
		
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BE6 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method delete
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource connector
     * @return boolean
     */
    public function delete( core_kernel_classes_Resource $connector)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BDF begin
        $cardinalityService = wfEngine_models_classes_ActivityCardinalityService::singleton();
		
		if(!$this->isConnector($connector)){
			// throw new Exception("the resource in the parameter is not a connector: {$connector->getLabel()} ({$connector->uriResource})");
			return $returnValue;
		}
		
		//get the type of connector:
		$connectorType = $connector->getOnePropertyValue(new core_kernel_classes_Property(PROPERTY_CONNECTORS_TYPE));
		if(!is_null($connectorType) && $connectorType instanceof core_kernel_classes_Resource){
			if($connectorType->uriResource == INSTANCE_TYPEOFCONNECTORS_CONDITIONAL){
				//delete the related rule:
				$relatedRule = $this->getTransitionRule($connector);
				if(!is_null($relatedRule)){
					$processAuthoringService = wfAuthoring_models_classes_ProcessService::singleton();
					$processAuthoringService->deleteRule($relatedRule);
				}
			}
		}
		
		//delete cardinality resources if exists in previous activities:
		foreach($this->getPreviousActivities($connector) as $prevActivity){
			if($cardinalityService->isCardinality($prevActivity)){
				$prevActivity->delete();//delete the cardinality resource
			}
		}
		
		//manage the connection to the following activities
		$activityRef = $connector->getUniquePropertyValue(new core_kernel_classes_Property(PROPERTY_CONNECTORS_ACTIVITYREFERENCE))->uriResource;
		foreach($this->getNextActivities($connector) as $nextActivity){
			
			$activity = null;
			
			if($cardinalityService->isCardinality($nextActivity)){
				try{
				$activity = $cardinalityService->getDestination($nextActivity);
				}catch(Exception $e){
					//the actiivty could be null if the reference have been removed...
				}
				
				$nextActivity->delete();//delete the cardinality resource
			}else{
				$activity = $nextActivity;
			}
			
			if(!is_null($activity) && $this->isConnector($activity)){
				$nextActivityRef = $activity->getUniquePropertyValue(new core_kernel_classes_Property(PROPERTY_CONNECTORS_ACTIVITYREFERENCE))->uriResource;
				if($nextActivityRef == $activityRef){
					$this->delete($activity);//delete following connectors only if they have the same activity reference
				}
			}
		}
		
		//delete connector itself:
		$returnValue = $connector->delete(true);
        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BDF end

        return (bool) $returnValue;
    }

} /* end of class wfAuthoring_models_classes_ConnectorService */

?>