<?php
/**
 * Contains Version class.
 *
 * PHP version 5.3
 *
 * LICENSE:
 * This file is part of SemanticVersion
 * Copyright (C) 2014 Michael Cummings
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General
 * Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * You should be able to find a copy of this license in the LICENSE.md file. A copy of the GNU GPL should also be
 * available in the GNU-GPL.md file.
 *
 * @copyright 2014 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @author    Michael Cummings <mgcummings@yahoo.com>
 */
namespace Dragonrun1\SemanticVersion;

use Dragonrun1\SemanticVersion\Constants as SVC;

/**
 * Class Version
 *
 * @package Dragonrun1\SemanticVersion
 */
class Version
{
    /**
     * @param $version
     */
    public function __construct($version = '0.0.0')
    {
        $this->parseFullVersion($version);
    }
    /**
     * @return string
     */
    public function __toString()
    {
        $version = $this->major . '.' . $this->minor . '.' . $this->patch;
        $version .= ($this->pre == '') ? '' : '-' . $this->pre;
        $version .= ($this->build == '') ? '' : '+' . $this->build;
        return $version;
    }
    /**
     * @return self
     */
    public function bumpBuild()
    {
        $this->setBuild(++$this->build);
        return $this;
    }
    /**
     * @param string $bump
     *
     * @return self
     * @throws \InvalidArgumentException
     * @throws \DomainException
     */
    function bumpFullVersion(
        $bump = SVC::PATCH
    ) {
        $bump = strtolower((string)$bump);
        switch ($bump) {
            case SVC::MAJOR:
                $this->bumpMajor();
                break;
            case SVC::MINOR:
                $this->bumpMinor();
                break;
            case SVC::PATCH:
                $this->bumpPatch();
                break;
            case SVC::PRE:
                $this->bumpPre();
                break;
            case SVC::PRE_MAJOR:
                $this->bumpSemanticPre(SVC::MAJOR);
                break;
            case SVC::PRE_MINOR:
                $this->bumpSemanticPre(SVC::MINOR);
                break;
            case SVC::PRE_PATCH:
                $this->bumpSemanticPre(SVC::PATCH);
                break;
            case SVC::BUILD:
                $this->bumpBuild();
                break;
            case SVC::BUILD_MAJOR:
                $this->bumpSemanticBuild(SVC::MAJOR);
                break;
            case SVC::BUILD_MINOR:
                $this->bumpSemanticBuild(SVC::MINOR);
                break;
            case SVC::BUILD_PATCH:
                $this->bumpSemanticBuild(SVC::PATCH);
                break;
            default:
                $mess = 'Unknown bump value ' . $bump;
                throw new \DomainException($mess);
        }
        return $this;
    }
    /**
     * @return self
     */
    public function bumpMajor()
    {
        $this->setMajor(++$this->major)
             ->setMinor('0')
             ->setPatch('0')
             ->setPre('')
             ->setBuild('');
        return $this;
    }
    /**
     * @return self
     */
    public function bumpMinor()
    {
        $this->setMinor(++$this->minor)
             ->setPatch('0')
             ->setPre('')
             ->setBuild('');
        return $this;
    }
    /**
     * @return self
     */
    public function bumpPatch()
    {
        $this->setPatch(++$this->patch)
             ->setPre('')
             ->setBuild('');
        return $this;
    }
    /**
     * @return self
     */
    public function bumpPre()
    {
        $this->setPre(++$this->pre);
        return $this;
    }
    /**
     * @param string $bump
     *
     * @return self
     * @throws \DomainException
     */
    public function bumpSemanticBuild($bump)
    {
        $bump = strtolower((string)$bump);
        $class = __CLASS__;
        /**
         * @var Version $build
         */
        $build = new $class($this->build);
        switch ($bump) {
            case SVC::MAJOR:
                $build->bumpMajor();
                break;
            case SVC::MINOR:
                $build->bumpMinor();
                break;
            case SVC::PATCH:
                $build->bumpPatch();
                break;
            default:
                $mess = 'Unknown bump value ' . $bump;
                throw new \DomainException($mess);
        }
        $this->setBuild($build);
        return $this;
    }
    /**
     * @param string $bump
     *
     * @return self
     * @throws \DomainException
     */
    public function bumpSemanticPre($bump)
    {
        $bump = strtolower((string)$bump);
        $class = __CLASS__;
        /**
         * @var Version $pre
         */
        $pre = new $class($this->pre);
        switch ($bump) {
            case SVC::MAJOR:
                $pre->bumpMajor();
                break;
            case SVC::MINOR:
                $pre->bumpMinor();
                break;
            case SVC::PATCH:
                $pre->bumpPatch();
                break;
            default:
                $mess = 'Unknown bump value ' . $bump;
                throw new \DomainException($mess);
        }
        $this->setPre($pre);
        return $this;
    }
    /**
     * @return string
     */
    public function getBuild()
    {
        return $this->build;
    }
    /**
     * @return mixed
     */
    public function getMajor()
    {
        return $this->major;
    }
    /**
     * @return string
     */
    public function getMinor()
    {
        return $this->minor;
    }
    /**
     * @return string
     */
    public function getPatch()
    {
        return $this->patch;
    }
    /**
     * @return string
     */
    public function getPre()
    {
        return $this->pre;
    }
    /**
     * @return string
     */
    public function getPreRelease()
    {
        return $this->getPre();
    }
    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->major . '.' . $this->minor . '.' . $this->patch;
    }
    /**
     * @param $version
     *
     * @return bool
     */
    public function isValid($version)
    {
        $last = substr($version, -1);
        if ($last == '-' || $last == '+') {
            return false;
        }
        $offset = strpos($version, '+');
        if (false !== $offset) {
            $build = substr($version, ($offset + 1));
            $version = substr($version, 0, $offset);
            if (!$this->isValidBuild($build)) {
                return false;
            }
        }
        $offset = strpos($version, '-');
        if (false !== $offset) {
            $pre = substr($version, ($offset + 1));
            $version = substr($version, 0, $offset);
            if (!$this->isValidPre($pre)) {
                return false;
            }
        }
        if (!$this->isValidVersion($version)) {
            return false;
        }
        return true;
    }
    /**
     * @param string $build
     *
     * @return bool
     */
    public function isValidBuild($build)
    {
        $buildRE = '/^([0-9a-zA-Z]+((\.|\-)[0-9a-zA-Z]+)*)?$/';
        if (preg_match($buildRE, $build) != 1) {
            return false;
        }
        return true;
    }
    /**
     * @param string $pre
     *
     * @return bool
     */
    public function isValidPre($pre)
    {
        $preRE =
            '/^((0|[1-9a-zA-Z][0-9a-zA-Z]*)((\.|\-)(0|[1-9a-zA-Z][0-9a-zA-Z]*))*)?$/';
        if (preg_match($preRE, $pre) != 1) {
            return false;
        }
        return true;
    }
    /**
     * @param string $version
     *
     * @return bool
     */
    public function isValidVersion($version)
    {
        $versionRE = '/^(0|[1-9][0-9]*)\.(0|[1-9][0-9]*)\.(0|[1-9][0-9]*)$/';
        if (preg_match($versionRE, $version) != 1) {
            return false;
        }
        return true;
    }
    /**
     * @param string $version
     *
     * @return self
     */
    public function parseFullVersion($version)
    {
        $build = '';
        $offset = strpos($version, '+');
        if (false !== $offset) {
            $build = substr($version, ($offset + 1));
            $version = substr($version, 0, $offset);
        }
        $this->setBuild($build);
        $pre = '';
        $offset = strpos($version, '-');
        if (false !== $offset) {
            $pre = substr($version, ($offset + 1));
            $version = substr($version, 0, $offset);
        }
        $this->setPre($pre);
        $this->setVersion($version);
        return $this;
    }
    /**
     * @return self
     */
    public function resetFullVersion()
    {
        $this->major = $this->minor = $this->patch = '0';
        $this->pre = $this->build = '';
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws \DomainException
     * @return self
     */
    public function setBuild($value)
    {
        $value = (string)$value;
        if (!$this->isValidBuild($value)) {
            $mess = 'Given invalid build value: ' . $value;
            throw new \DomainException($mess);
        }
        $this->build = $value;
        return $this;
    }
    /**
     * @param mixed $value
     *
     * @throws \DomainException
     * @return self
     */
    public function setMajor($value)
    {
        $value = (string)$value;
        $re = '/^(0|[1-9][0-9]*)$/';
        if (preg_match($re, $value) != 1) {
            $mess = 'Given invalid major value: ' . $value;
            throw new \DomainException($mess);
        }
        $this->major = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws \DomainException
     * @return self
     */
    public function setMinor($value)
    {
        $value = (string)$value;
        $re = '/^(0|[1-9][0-9]*)$/';
        if (preg_match($re, $value) != 1) {
            $mess = 'Given invalid minor value: ' . $value;
            throw new \DomainException($mess);
        }
        $this->minor = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws \DomainException
     * @return self
     */
    public function setPatch($value)
    {
        $value = (string)$value;
        $re = '/^(0|[1-9][0-9]*)$/';
        if (preg_match($re, $value) != 1) {
            $mess = 'Given invalid patch value: ' . $value;
            throw new \DomainException($mess);
        }
        $this->patch = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws \DomainException
     * @return self
     */
    public function setPre($value)
    {
        $value = (string)$value;
        if (!$this->isValidPre($value)) {
            $mess = 'Given invalid pre-release value: ' . $value;
            throw new \DomainException($mess);
        }
        $this->pre = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws \DomainException
     * @return self
     */
    public function setPreRelease($value)
    {
        return $this->setPre($value);
    }
    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     * @throws \DomainException
     * @return self
     */
    public function setVersion($value)
    {
        $value = (string)$value;
        if (!$this->isValidVersion($value)) {
            $mess = 'Given invalid version value: ' . $value;
            throw new \DomainException($mess);
        }
        list($this->major, $this->minor, $this->patch) = explode('.', $value);
        return $this;
    }
    /**
     * @var string
     */
    private $build;
    /**
     * @var string
     */
    private $major;
    /**
     * @var string
     */
    private $minor;
    /**
     * @var string
     */
    private $patch;
    /**
     * @var string
     */
    private $pre;
}
