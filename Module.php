<?php
/**
 * Copyright (c) 2013 Andy Robinson.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     EphChartbeat
 * @author      Andy Robinson <andy@euphio.co.uk>
 * @copyright   2013 Andy Robinson.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://euphio.co.uk
 */

namespace EphChartbeat;

use EphChartbeat\Options\ModuleOptions;
use EphChartbeat\View\Helper\Chartbeat as ChartbeatViewHelper;
use Zend\EventManager\EventInterface;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\MvcEvent;

/**
 * EphChartbeat Module
 *
 * Adds Chartbeat tracking code to a ZF2 Application
 */
class Module
{
    /**
     * Returns module configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Returns the Auto loader configuration for the module
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            //Use classmaps
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            //Fallback to autoloader
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Register the Chartbeat View Helper
     *
     * @return array
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // A view Helper for Chartbeat
                'chartbeat' => function($sm) {
                    // Grab Configuration
                    $config = $sm->get('config');
                    $config = $config['chartbeat'];

                    // Create Options Object
                    $moduleOptions = new ModuleOptions();
                    $moduleOptions->setFromArray($config);

                    // Return View Helper Instance
                    return new ChartbeatViewHelper($moduleOptions);
                },
            ),
        );
    }

    /**
     * On render invoke the view helper to render the javascript code.
     *
     * @param \Zend\EventManager\EventInterface $e
     */
    public function onBootstrap(EventInterface $e)
    {
        $application     = $e->getApplication();
        $serviceManager  = $application->getServiceManager();
        $eventManager    = $application->getEventManager();

        // Ensure HTTP request
        if (!$e->getRequest() instanceof HttpRequest) {
            return;
        }

        // Bind it
        $eventManager->attach(
            MvcEvent::EVENT_RENDER,
            function(MvcEvent $e) use ($serviceManager) {
                // Get plugin
                $view   = $serviceManager->get('ViewHelperManager');
                $plugin = $view->get('chartbeat');
                // Invoke it
                $plugin();
            }
        );
    }
}
