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

/**
 * Class Version
 *
 * @package Dragonrun1\SemanticVersion
 */
class Version
{
    /**
     * @param string $version
     * @param string $bump
     * @param null   $newPre
     * @param null   $newBuild
     *
     * @return string
     * @throws \InvalidArgumentException
     * @throws \DomainException
     */
    function bumpVersion(
        $version,
        $bump = 'patch',
        $newPre = null,
        $newBuild = null
    ) {
        if (!is_string($version)) {
            $mess = 'Version MUST be a string given ' . gettype($version);
            throw new \InvalidArgumentException($mess);
        }
        if (!is_string($bump)) {
            $mess = 'Bump MUST be a string given ' . gettype($bump);
            throw new \InvalidArgumentException($mess);
        }
        $keys = array('major', 'minor', 'patch', 'pre', 'build');
        $options = array_merge(
            $keys,
            array(
                'pre-major',
                'pre-minor',
                'pre-patch',
                'build-major',
                'build-minor',
                'build-patch'
            )
        );
        $bump = strtolower($bump);
        if (!in_array($bump, $options)) {
            $mess = 'Unknown bump value ' . $bump;
            throw new \DomainException($mess);
        }
        if (!is_string($newPre) && !is_int($newPre)
            && !is_null($newPre)
        ) {
            $mess = 'New pre-release MUST be a string or integer given '
                . gettype($newPre);
            throw new \InvalidArgumentException($mess);
        }
        if (!is_string($newBuild) && !is_int($newBuild)
            && !is_null(
                $newBuild
            )
        ) {
            $mess = 'New build MUST be a string or integer given '
                . gettype($newBuild);
            throw new \InvalidArgumentException($mess);
        }
        if (!$this->isValidVersion($version)) {
            $mess = 'Version string given was not valid';
            throw new \DomainException($mess);
        }
        $build = '';
        $pre = '';
        if (false !== strpos($version, '+')) {
            list($version, $build) = explode('+', $version);
        }
        if (false !== strpos($version, '-')) {
            list($version, $pre) = explode('-', $version);
        }
        $version = explode('.', $version);
        $version[] = $pre;
        $version[] = $build;
        $version = array_combine($keys, $version);
        switch ($bump) {
            case 'major':
                $toBump = (int)$version[$bump] + 1;
                $version[$bump] = $toBump;
                $version['minor'] = 0;
                $version['patch'] = 0;
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : '';
                break;
            case 'minor':
                $toBump = (int)$version[$bump] + 1;
                $version[$bump] = $toBump;
                $version['patch'] = 0;
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : '';
                break;
            case 'patch':
                $toBump = (int)$version[$bump] + 1;
                $version[$bump] = $toBump;
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : '';
                break;
            case 'pre':
                $toBump = (int)$version['pre'] + 1;
                $version['pre'] = $newPre ? : $toBump;
                $version['build'] = $newBuild ? : '';
                break;
            case 'pre-major':
                $toBump = $this->bumpVersion($version['pre'], 'major');
                $version['pre'] = $newPre ? : $toBump;
                $version['build'] = $newBuild ? : '';
                break;
            case 'pre-minor':
                $toBump = $this->bumpVersion($version['pre'], 'minor');
                $version['pre'] = $newPre ? : $toBump;
                $version['build'] = $newBuild ? : '';
                break;
            case 'pre-patch':
                $toBump = $this->bumpVersion($version['pre'], 'patch');
                $version['pre'] = $newPre ? : $toBump;
                $version['build'] = $newBuild ? : '';
                break;
            case 'build':
                $toBump = (int)$version['build'] + 1;
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : $toBump;
                break;
            case 'build-major':
                $toBump = $this->bumpVersion($version['build'], 'major');
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : $toBump;
                break;
            case 'build-minor':
                $toBump = $this->bumpVersion($version['build'], 'minor');
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : $toBump;
                break;
            case 'build-patch':
                $toBump = $this->bumpVersion($version['build'], 'patch');
                $version['pre'] = $newPre ? : '';
                $version['build'] = $newBuild ? : $toBump;
                break;
        }
        $result =
            $version['major'] . '.' . $version['minor'] . '.'
            . $version['patch'];
        $result .= $version['pre'] ? '-' . $version['pre'] : '';
        $result .= $version['build'] ? '+' . $version['build'] : '';
        return $result;
    }
    /**
     * @param $value
     *
     * @return bool
     */
    public function isValidVersion($value)
    {
        $identifier =
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $identifierGroup = $identifier . '.';
        $domain = $identifier . '.+';
        $numberOnly = '9876543210';
        $value = trim($value);
        // Empty semantic version.
        if (empty($value)) {
            return false;
        }
        // Version given contained these illegal character(s).
        $check = str_replace(str_split($domain), '', $value);
        if ($check != '') {
            return false;
        }
        $check = strlen(str_replace(str_split($identifierGroup), '', $value));
        // Found multiple "+" build separators.
        if ($check > 1) {
            return false;
        }
        if ($check) {
            list($value, $build) = explode('+', $value);
        }
        unset($build);
        $pos = strpos($value, '-');
        if (false !== $pos) {
            $value = substr($value, 0, $pos);
        }
        $check = str_replace(str_split($numberOnly), '', $value);
        // Missing one or more "." separators in version.
        if ($check != '..') {
            return false;
        }
        $version = explode('.', $value);
        $check = array_search('', $version);
        // Missing one or more of the version numbers.
        if ($check !== false) {
            return false;
        }
        return true;
    }
}
