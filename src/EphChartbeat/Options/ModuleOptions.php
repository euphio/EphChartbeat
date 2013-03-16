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

namespace EphChartbeat\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * EphChartbeat Module Options
 *
 * An options object for EphChartbeat
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * The domain that Chartbeat is installed on.
     *
     * @var string
     */
    protected $domain;

    /**
     * Prevent Chartbeat from using cookies
     *
     * @var boolean
     */
    protected $noCookies;

    /**
     * A path override (see http://chartbeat.com/docs/configuration_variables/#path)
     *
     * @var string
     */
    protected $path;

    /**
     * The chartbeat User id
     *
     * @var string
     */
    protected $uid;

    /**
     * Use the canonical path instead of the actual URL
     *
     * @var boolean
     */
    protected $useCanonical;

    /**
     * Sets the Domain that chartbeat is installed on
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        // Strip 'www.' if present
        $domain = str_replace('www.', '', $domain);
        $this->domain = $domain;
    }

    /**
     * Returns the Domain the chartbeat is installed on
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets wether Chartbeat should use cookies
     *
     * @param boolean $noCookies
     */
    public function setNoCookies($noCookies)
    {
        $this->noCookies = $noCookies;
    }

    /**
     * Returns wether Chartbeat should use cookies
     *
     * @return boolean
     */
    public function getNoCookies()
    {
        return $this->noCookies;
    }

    /**
     * Sets the overridden path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Returns the overridden path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the Chartbeat user id
     *
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Returns the Chartbeat user id
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Sets wether to the canonical path instead of the actual URL
     *
     * @param boolean $useCanonical
     */
    public function setUseCanonical($useCanonical)
    {
        $this->useCanonical = $useCanonical;
    }

    /**
     * Returns wether to the canonical path instead of the actual URL
     *
     * @return boolean
     */
    public function getUseCanonical()
    {
        return $this->useCanonical;
    }
}