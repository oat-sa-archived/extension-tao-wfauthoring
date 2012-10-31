<?php

error_reporting(E_ALL);

/**
 * TAO - wfAuthoring/models/classes/class.ActivityService.php
 *
 * $Id$
 *
 * This file is part of TAO.
 *
 * Automatically generated on 30.10.2012, 18:38:20 with ArgoUML PHP module 
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
 * Service that retrieve information about Activty definition during runtime
 *
 * @author Joel Bout, <joel.bout@tudor.lu>
 */
require_once('wfEngine/models/classes/class.ActivityService.php');

/* user defined includes */
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBF-includes begin
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBF-includes end

/* user defined constants */
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBF-constants begin
// section 10-30-1--78--3f16755c:13a9722f969:-8000:0000000000003BBF-constants end

/**
 * Short description of class wfAuthoring_models_classes_ActivityService
 *
 * @access public
 * @author Joel Bout, <joel.bout@tudor.lu>
 * @package wfAuthoring
 * @subpackage models_classes
 */
class wfAuthoring_models_classes_ActivityService
    extends wfEngine_models_classes_ActivityService
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Short description of method createActivity
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource process
     * @param  string label
     * @return core_kernel_classes_Resource
     */
    public function createActivity( core_kernel_classes_Resource $process, $label = '')
    {
        $returnValue = null;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003C06 begin
	    $activityLabel = "";
		$number = 0;

		if(empty($label)){
			$number = $process->getPropertyValuesCollection(new core_kernel_classes_Property(PROPERTY_PROCESS_ACTIVITIES))->count();
			$number += 1;
			$activityLabel = "Activity_$number";
		}else{
			$activityLabel = $label;
		}

		$activityClass = new core_kernel_classes_Class(CLASS_ACTIVITIES);
		$activity = $activityClass->createInstance($activityLabel, "created by ActivityService.Class");

		if(!empty($activity)){
			//associate the new instance to the process instance
			$process->setPropertyValue(new core_kernel_classes_Property(PROPERTY_PROCESS_ACTIVITIES), $activity->uriResource);

			//set if it is the first or not:
			if($number == 1){
				$activity->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_ISINITIAL), GENERIS_TRUE);
			}else{
				$activity->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_ISINITIAL), GENERIS_FALSE);
			}

			//by default, set the 'isHidden' property value to false:
			$activity->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_ISHIDDEN), GENERIS_FALSE);

			//by default we add the back and forward controls to the activity
			$activity->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_CONTROLS), array(INSTANCE_CONTROL_BACKWARD, INSTANCE_CONTROL_FORWARD));

			$returnValue = $activity;
		}else{
			throw new Exception("the activity cannot be created for the process {$process->uriResource}");
		}
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003C06 end

        return $returnValue;
    }

    /**
     * Short description of method createFromServiceDefinition
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource process
     * @param  Resource serviceDefinition
     * @param  array inputParameters
     * @return core_kernel_classes_Resource
     */
    public function createFromServiceDefinition( core_kernel_classes_Resource $process,  core_kernel_classes_Resource $serviceDefinition, $inputParameters = array())
    {
        $returnValue = null;

        // section 10-30-1--78--1bae53d3:13ab273fb8e:-8000:0000000000003BF9 begin
        $returnValue = $this->createActivity($process);
        $service = $this->addService($returnValue);
        $service->editPropertyValues(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_SERVICEDEFINITION), $serviceDefinition);
        
        // section 10-30-1--78--1bae53d3:13ab273fb8e:-8000:0000000000003BF9 end

        return $returnValue;
    }

    /**
     * Short description of method addService
     *
     * @access protected
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource activity
     * @return core_kernel_classes_Resource
     */
    protected function addService( core_kernel_classes_Resource $activity)
    {
        $returnValue = null;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BF0 begin
    	$number = $activity->getPropertyValuesCollection(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_INTERACTIVESERVICES))->count();
		$number += 1;

		//an interactive service of an activity is a call of service:
		$callOfServiceClass = new core_kernel_classes_Class(CLASS_CALLOFSERVICES);

		//create new resource for the property value of the current call of service PROPERTY_CALLOFSERVICES_ACTUALPARAMETERIN or PROPERTY_CALLOFSERVICES_ACTUALPARAMETEROUT
		$returnValue = $callOfServiceClass->createInstance($activity->getLabel()."_service_".$number, "created by ProcessAuthoringService.Class");

		if(empty($returnValue)){
			throw new Exception("the interactive service cannot be created for the activity {$activity->uriResource}");
		}
		
		//associate the new instance to the activity instance
		$activity->setPropertyValue(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_INTERACTIVESERVICES), $returnValue->uriResource);

		//set default position and size value:
		$returnValue->setPropertyValue(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_WIDTH), 100);
		$returnValue->setPropertyValue(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_HEIGHT), 100);
		$returnValue->setPropertyValue(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_TOP), 0);
		$returnValue->setPropertyValue(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_LEFT), 0);
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BF0 end

        return $returnValue;
    }

    /**
     * Short description of method delete
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource activity
     * @return boolean
     */
    public function delete( core_kernel_classes_Resource $activity)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BE3 begin
        $connectorService = wfAuthoring_models_classes_ConnectorService::singleton();
		$interactiveServiceService = wfEngine_models_classes_InteractiveServiceService::singleton();
		$connectorClass = new core_kernel_classes_Class(CLASS_CONNECTORS);
		$connectors = $connectorClass->searchInstances(array(PROPERTY_CONNECTORS_ACTIVITYREFERENCE => $activity->uriResource), array('like' => false, 'recursive' => 0));
		foreach($connectors as $connector){
			$connectorService->delete($connector);
		}
		
		//deleting resource "acitivty" with its references should be enough normally to remove all references... to be tested
				
		//delete call of service!!
		foreach($this->getInteractiveServices($activity) as $service){
			$interactiveServiceService->deleteInteractiveService($service);
		}
		
		//delete referenced actiivty cardinality resources:
		$activityCardinalityClass = new core_kernel_classes_Class(CLASS_ACTIVITYCARDINALITY);
		$cardinalities = $activityCardinalityClass->searchInstances(array(PROPERTY_STEP_NEXT => $activity->uriResource), array('like'=>false));
		foreach($cardinalities as $cardinality) {
			$cardinality->delete(true);
		}
		
		//delete activity itself:
		$returnValue = $activity->delete(true);
        // section 10-30-1--78-7cfbed5f:13a9c4b075b:-8000:0000000000003BE3 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setACL
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource activity
     * @param  Resource mode
     * @param  Resource target
     * @return boolean
     */
    public function setACL( core_kernel_classes_Resource $activity,  core_kernel_classes_Resource $mode,  core_kernel_classes_Resource $target = null)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BEE begin
        
		//check the kind of resources
        if($this->getClass($activity)->uriResource != CLASS_ACTIVITIES){
        	throw new Exception("Activity must be an instance of the class Activities");
        }
        if(!in_array($mode->uriResource, array_keys($this->getAclModes()))){
        	throw new Exception("Unknow acl mode");
        }
        
        //set the ACL mode
        $properties = array(
        	PROPERTY_ACTIVITIES_ACL_MODE => $mode->uriResource
        );
        
        switch($mode->uriResource){
        	case INSTANCE_ACL_ROLE:
        	case INSTANCE_ACL_ROLE_RESTRICTED_USER:
        	case INSTANCE_ACL_ROLE_RESTRICTED_USER_INHERITED:
			case INSTANCE_ACL_ROLE_RESTRICTED_USER_DELIVERY:{
        		if(is_null($target)){
        			throw new Exception("Target must reference a role resource");
        		}
        		$properties[PROPERTY_ACTIVITIES_RESTRICTED_ROLE] = $target->uriResource;
        		break;
        	}	
        	case INSTANCE_ACL_USER:{
        		if(is_null($target)){
        			throw new Exception("Target must reference a user resource");
        		}
        		$properties[PROPERTY_ACTIVITIES_RESTRICTED_USER] = $target->uriResource;
        		break;
			}
        }
        
        //bind the mode and the target (user or role) to the activity
        $returnValue = $this->bindProperties($activity, $properties);
		
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BEE end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setControls
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource activity
     * @param  array controls
     * @return boolean
     */
    public function setControls( core_kernel_classes_Resource $activity, $controls)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BF3 begin
        $possibleValues = $this->getAllControls();
		if(is_array($controls)){
			$values = array();
			foreach($controls as $control){
				if(in_array($control, $possibleValues)){
					$values[] = $control;
				}
			}
			$returnValue = $activity->editPropertyValues(new core_kernel_classes_Property(PROPERTY_ACTIVITIES_CONTROLS), $values);
		}
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BF3 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setHidden
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource activity
     * @param  boolean hidden
     * @return boolean
     */
    public function setHidden( core_kernel_classes_Resource $activity, $hidden = true)
    {
        $returnValue = (bool) false;

        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BF5 begin
        $propHidden = new core_kernel_classes_Property(PROPERTY_ACTIVITIES_ISHIDDEN);
		$hidden = (bool) $hidden;
		$returnValue = $activity->editPropertyValues($propHidden, ($hidden)?GENERIS_TRUE:GENERIS_FALSE);
		$this->setCache(__CLASS__.'::isHidden', array($activity), $hidden);
        // section 10-30-1--78-1d59cf09:13aab8708e6:-8000:0000000000003BF5 end

        return (bool) $returnValue;
    }

} /* end of class wfAuthoring_models_classes_ActivityService */

?>