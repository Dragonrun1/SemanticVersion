<?php
/**
 * Contains VersionTest class.
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
namespace Dragonrun1\SemanticVersion\Tests;

use Dragonrun1\SemanticVersion\Version;

/**
 * Class VersionTest
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Version
     */
    public $testee;
    public function setup()
    {
        $this->testee = new Version();
    }
    public function testBumpVersionWithBumpEqualBuild()
    {
        $bump = 'build';
        $version = '0.0.1-1+1';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1+2';
        $this->assertEquals($expected, $result);
        $pre = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.2+2';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123+2';
        $this->assertEquals($expected, $result);
        $build = '1.2.3';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+1.2.3';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualBuildMajor()
    {
        $bump = 'build-major';
        $version = '0.0.1-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1+1.0.0';
        $this->assertEquals($expected, $result);
        $pre = '0.0.4';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.4+1.0.0';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123+1.0.0';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualBuildMinor()
    {
        $bump = 'build-minor';
        $version = '0.0.1-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1+0.2.0';
        $this->assertEquals($expected, $result);
        $pre = '0.0.4';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.4+0.2.0';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123+0.2.0';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualBuildPatch()
    {
        $bump = 'build-patch';
        $version = '0.0.1-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1+0.1.1';
        $this->assertEquals($expected, $result);
        $pre = '0.0.4';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.4+0.1.1';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123+0.1.1';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualMajor()
    {
        $bump = 'major';
        $version = '0.0.0-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '1.0.0';
        $this->assertEquals($expected, $result);
        $pre = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '1.0.0-0.0.2';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '1.0.0-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '1.0.0+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '1.0.0+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualMinor()
    {
        $bump = 'minor';
        $version = '0.0.0-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.1.0';
        $this->assertEquals($expected, $result);
        $pre = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.1.0-0.0.2';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.1.0-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.1.0+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.1.0+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualPatch()
    {
        $bump = 'patch';
        $version = '0.0.0-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1';
        $this->assertEquals($expected, $result);
        $pre = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.2';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualPre()
    {
        $bump = 'pre';
        $version = '0.0.1-1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1-2';
        $this->assertEquals($expected, $result);
        $pre = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.2';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-2+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-2+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualPreMajor()
    {
        $bump = 'pre-major';
        $version = '0.0.1-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1-1.0.0';
        $this->assertEquals($expected, $result);
        $pre = '0.0.4';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.4';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-1.0.0+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-1.0.0+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualPreMinor()
    {
        $bump = 'pre-minor';
        $version = '0.0.1-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1-0.1.0';
        $this->assertEquals($expected, $result);
        $pre = '0.0.4';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.4';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-0.1.0+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-0.1.0+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpEqualPrePatch()
    {
        $bump = 'pre-patch';
        $version = '0.0.1-0.0.1+0.1.0';
        $result = $this->testee->bumpVersion($version, $bump);
        $expected = '0.0.1-0.0.2';
        $this->assertEquals($expected, $result);
        $pre = '0.0.4';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-0.0.4';
        $this->assertEquals($expected, $result);
        $pre = '123';
        $result = $this->testee->bumpVersion($version, $bump, $pre);
        $expected = '0.0.1-123';
        $this->assertEquals($expected, $result);
        $build = '0.0.2';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-0.0.2+0.0.2';
        $this->assertEquals($expected, $result);
        $build = '123';
        $result = $this->testee->bumpVersion($version, $bump, null, $build);
        $expected = '0.0.1-0.0.2+123';
        $this->assertEquals($expected, $result);
    }
    public function testBumpVersionWithBumpInvalidValueThrowsDomainException()
    {
        $this->setExpectedException(
            '\DomainException',
            'Unknown bump value dump'
        );
        $bump = 'dump';
        $version = '0.0.0-0.0.1+0.1.0';
        $this->testee->bumpVersion($version, $bump);
    }
    public function testBumpVersionWithInvalidBumpArgumentTypeThrowsInvalidArgumentException(
    )
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            'Bump MUST be a string given integer'
        );
        $bump = 1;
        $version = '0.0.0-0.0.1+0.1.0';
        $this->testee->bumpVersion($version, $bump);
    }
    public function testBumpVersionWithInvalidNewBuildArgumentTypeThrowsInvalidArgumentException(
    )
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            'New build MUST be a string or integer given array'
        );
        $bump = 'patch';
        $version = '0.0.0-0.0.1+0.1.0';
        $build = array();
        $this->testee->bumpVersion($version, $bump, null, $build);
    }
    public function testBumpVersionWithInvalidNewPreArgumentTypeThrowsInvalidArgumentException(
    )
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            'New pre-release MUST be a string or integer given array'
        );
        $bump = 'patch';
        $version = '0.0.0-0.0.1+0.1.0';
        $pre = array();
        $this->testee->bumpVersion($version, $bump, $pre);
    }
    public function testBumpVersionWithInvalidVersionArgumentTypeThrowsInvalidArgumentException(
    )
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            'Version MUST be a string given integer'
        );
        $bump = 'patch';
        $version = 0;
        $this->testee->bumpVersion($version, $bump);
    }
    public function testBumpVersionWithInvalidVersionValueThrowsDomainException(
    )
    {
        $this->setExpectedException(
            '\DomainException',
            'Version string given was not valid'
        );
        $bump = 'patch';
        $version = '0';
        $this->testee->bumpVersion($version, $bump);
    }
    public function testIsValidVersionWithBadValuesReturnsFalse()
    {
        $version = '';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '1.0.*';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '1.0.0+1+1';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '1.0';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '.0.0';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '1..0';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '1.0.';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
        $version = '1.0.a';
        $result = $this->testee->isValidVersion($version);
        $this->assertFalse($result);
    }
    public function testIsValidVersionWithGoodValuesReturnsTrue()
    {
        $version = '1.0.0';
        $result = $this->testee->isValidVersion($version);
        $this->assertTrue($result);
        $version = '0.2.0-1';
        $result = $this->testee->isValidVersion($version);
        $this->assertTrue($result);
        $version = '0.0.3+1';
        $result = $this->testee->isValidVersion($version);
        $this->assertTrue($result);
        $version = '1.0.0-2+3';
        $result = $this->testee->isValidVersion($version);
        $this->assertTrue($result);
    }
}
