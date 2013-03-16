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

namespace EphChartbeat\View\Helper;

use EphChartbeat\Options\ModuleOptions;
use Zend\View\Helper\AbstractHelper;

/**
 * A View Helper to add Chartbeat tracking code to the
 * existing InlineScript and HeadScript view helpers
 */
class Chartbeat extends AbstractHelper
{
    /**
     * A module options object
     *
     * @var \EphChartbeat\Options\ModuleOptions
     */
    protected $options;

    /**
     * Keeps track of wether the view helper has previously been renderred
     *
     * @var bool
     */
    protected $rendered = false;

    /**
     * Constructor
     *
     * @param \EphChartbeat\Options\ModuleOptions $ptions
     */
    public function __construct(ModuleOptions $options)
    {
        $this->setOptions($options);
    }

    /**
     * Adds Chartbeat tracking code to the InlineScript and HeadScript view helpers
     */
    public function __invoke ()
    {
        // Prevent double renderring
        if  ($this->rendered) {
            return;
        }

        // Add the headscript
        $headScript = 'var _sf_startpt=(new Date()).getTime()';
        $this->view->plugin('HeadScript')->appendScript($headScript);


        // Create Chartbeat configuration settings
        $inlineScript = 'var _sf_async_config={};' . PHP_EOL
                      . '_sf_async_config.uid = ' . $this->getOptions()->getUid() . ';' .PHP_EOL
                      . '_sf_async_config.domain = "' . $this->getOptions()->getDomain() . '";';

        //Add advanced options
        // @TODO implement advenced configuration

        // Append Standard Chartbeat Script
        $inlineScript .= '(function(){' . PHP_EOL
                       . '  function loadChartbeat() {' . PHP_EOL
                       . '      window._sf_endpt=(new Date()).getTime();' . PHP_EOL
                       . '      var e = document.createElement("script");' . PHP_EOL
                       . '      e.setAttribute("language", "javascript");' . PHP_EOL
                       . '      e.setAttribute("type", "text/javascript");' . PHP_EOL
                       . '      e.setAttribute("src",' . PHP_EOL
                       . '          (("https:" == document.location.protocol) ?'
                       . '              "https://a248.e.akamai.net/chartbeat.download.akamai.com/102508/" :' . PHP_EOL
                       . '              "http://static.chartbeat.com/") +' . PHP_EOL
                       . '              "js/chartbeat.js");' . PHP_EOL
                       . '      document.body.appendChild(e);' . PHP_EOL
                       . '  }' . PHP_EOL
                       . '  var oldonload = window.onload;' . PHP_EOL
                       . '  window.onload = (typeof window.onload != "function") ?' . PHP_EOL
                       . '   loadChartbeat : function() { oldonload(); loadChartbeat(); };' . PHP_EOL
                       . '})();' . PHP_EOL;

        // Append To helper
        $this->view->plugin('InlineScript')->appendScript($inlineScript);

        // Mark as rendered
        $this->setRendered(true);
    }

    /**
     * Sets the module options
     *
     * @param \EphChartbeat\Options\ModuleOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Returns the module options
     *
     * @return \EphChartbeat\Options\ModuleOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets wether the script has been renderred
     *
     * @param boolean $rendered
     */
    public function setRendered($rendered)
    {
        $this->rendered = $rendered;
    }

    /**
     * Returns wether the script has been renderred
     *
     * @return boolean
     */
    public function getRendered()
    {
        return $this->rendered;
    }
}