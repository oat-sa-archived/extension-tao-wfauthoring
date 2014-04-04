<?php

/**
 * 
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
 *
 */



/**
 * Short description of class wfAuthoring_models_classes_wfAuthoringService
 *
 * @access public
 * @author Joel Bout, <joel.bout@tudor.lu>
 * @package wfAuthoring
 
 */
class wfAuthoring_models_classes_wfAuthoringService
    extends tao_models_classes_GenerisService
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute processClass
     *
     * @access protected
     * @var Resource
     */
    protected $processClass = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @return mixed
     */
    public function __construct()
    {
        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C5A begin
		parent::__construct();
		$this->processClass = new core_kernel_classes_Class(CLASS_PROCESS);
        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C5A end
    }

    /**
     * Short description of method getProcessClass
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  string uri
     * @return core_kernel_classes_Class
     */
    public function getProcessClass($uri = '')
    {
        $returnValue = null;

        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C6B begin
		if(empty($uri) && !is_null($this->processClass)){
			$returnValue = $this->processClass;
		}
		else{
			$clazz = new core_kernel_classes_Class($uri);
			if($this->isProcessClass($clazz)){
				$returnValue = $clazz;
			}
		}
        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C6B end

        return $returnValue;
    }

    /**
     * Short description of method isProcessClass
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Class clazz
     * @return boolean
     */
    public function isProcessClass( core_kernel_classes_Class $clazz)
    {
        $returnValue = (bool) false;

        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C70 begin
		if($clazz->getUri() == $this->processClass->getUri()){
			$returnValue = true;	
		}
		else{
			foreach($this->processClass->getSubClasses() as $subclass){
				if($clazz->getUri() == $subclass->getUri()){
					$returnValue = true;
					break;	
				}
			}
		}
        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C70 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method cloneProcess
     *
     * @access public
     * @author Joel Bout, <joel.bout@tudor.lu>
     * @param  Resource instance
     * @param  Class clazz
     * @return core_kernel_classes_Resource
     */
    public function cloneProcess( core_kernel_classes_Resource $instance,  core_kernel_classes_Class $clazz)
    {
        $returnValue = null;

        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C73 begin
		if(!is_null($instance) && !is_null($clazz)){
			$processCloner = new wfAuthoring_models_classes_ProcessCloner();
			$returnValue = $processCloner->cloneProcess($instance);
		}				
        // section 10-13-1-39-1f91722d:12e9641f6ad:-8000:0000000000002C73 end

        return $returnValue;
    }

} /* end of class wfAuthoring_models_classes_wfAuthoringService */

?>