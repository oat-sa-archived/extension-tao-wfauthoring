<?php
/**  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2013 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 * 
 */

/**
 * Removes recursiv calls to the workflow engine, by resolving them
 * into a single workflow.
 * 
 * Assumes that the called workflows have a single entry and exit
 *
 * @access public
 * @package wfEngine
 * @subpackage models_classes
 */
class wfAuthoring_models_classes_ProcessFlattener
    extends wfAuthoring_models_classes_ProcessCloner{
    
    private $processDefinition;
    
    public function __construct(core_kernel_classes_Resource $processDefinition) {
        $this->processDefinition = $processDefinition;
        parent::__construct();
    } 
    
    public function flatten() {
        $activities = wfEngine_models_classes_ProcessDefinitionService::singleton()->getAllActivities($this->processDefinition);
        foreach ($activities as $activity) {
            $services = wfEngine_models_classes_ActivityService::singleton()->getInteractiveServices($activity);
            // only replace single services
            if (count($services) == 1) {
                $serviceCall = current($services);
                $serviceDefinition = $serviceCall->getUniquePropertyValue(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_SERVICEDEFINITION));
                if ($serviceDefinition->getUri() == INSTANCE_SERVICE_PROCESSRUNNER) {
                    // found a wfEngine call, extract processDefnition
                    
                    $subProcess = $this->getSubProcess($serviceCall);
                    if (empty($subProcess)) {
                        throw new common_exception_InconsistentData('Missing process uri in service call '.$serviceCall->getUri());
                    }
                    
                    // @todo test the process first
                    
                    // @todo clone sub process
                    common_Logger::w('Should have cloned subprocess '.$subProcess);
                    
                    //$info = $this->cloneProcessSegment($subProcess);
                    
                    /*
                    //clone the process segment:
                    $testInterfaces = $this->processCloner->cloneProcessSegment($testProcess, false);
                     
                    if(!empty($testInterfaces['in']) && !empty($testInterfaces['out'])){
                        $inActivity = $testInterfaces['in'];
                        $firstout = current($testInterfaces['out']);
                        common_Logger::i('Cloning T '.$activity->getUri().' to '.$inActivity->getUri().'=>'.$firstout->getUri());
                        $this->processCloner->addClonedActivity($inActivity, $activity, $firstout);
                    
                        $toLink[] = $activity;
                    }else{
                        throw new Exception("the process segment of the test process {$testProcess->getUri()} cannot be cloned");
                    }
                    */
                }
            }
        }
    }
    
    protected function getSubProcess($service) {
        $returnValue = null;
        $propertyIterator = $service->getPropertyValuesCollection(new core_kernel_classes_Property(PROPERTY_CALLOFSERVICES_ACTUALPARAMETERIN))->getIterator();
        foreach ($propertyIterator as $actualParam) {
            $formalParam = $actualParam->getUniquePropertyValue(new core_kernel_classes_Property(PROPERTY_ACTUALPARAMETER_FORMALPARAMETER));
            if ($formalParam->getUri() == INSTANCE_FORMALPARAM_PROCESSDEFINITION) {
                $returnValue = $actualParam->getOnePropertyValue(new core_kernel_classes_Property(PROPERTY_ACTUALPARAMETER_CONSTANTVALUE));
                break;
            }
        }
        return $returnValue;
    }
    
    
}