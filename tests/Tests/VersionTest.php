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
namespace SemanticVersion\Tests;

use SemanticVersion\Constants as SVC;
use SemanticVersion\Version;

/**
 * Class VersionTest
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Version
     */
    public $class;
    public function setup()
    {
        $this->class = new Version();
    }
    public function testBumpFullVersionThrowsDomainExceptionForInvalidBumpValue(
    )
    {
        $this->setExpectedException(
            '\DomainException',
            'Unknown bump value dump'
        );
        $bump = 'dump';
        $version = '0.0.1-0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
    }
    public function testBumpFullVersionWithBumpEqualBuild()
    {
        $bump = SVC::BUILD;
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+1';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+2';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.2';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.2+3';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+4';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualBuildMajor()
    {
        $bump = SVC::BUILD_MAJOR;
        $version = '0.0.1+0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+1.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+2.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.4';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.4+3.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+4.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+1.0.0';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualBuildMinor()
    {
        $bump = SVC::BUILD_MINOR;
        $version = '0.0.1+0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+0.1.0';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+0.2.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.4';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.4+0.3.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+0.4.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+0.1.0';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualBuildPatch()
    {
        $bump = SVC::BUILD_PATCH;
        $version = '0.0.1+0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+0.0.2';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1+0.0.3';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.4';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.4+0.0.4';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+0.0.5';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-123+0.0.3';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualMajor()
    {
        $bump = SVC::MAJOR;
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '1.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '2.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.4';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '3.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '4.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '5.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '234';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '6.0.0';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualMinor()
    {
        $bump = SVC::MINOR;
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.1.0';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.2.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.4';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.3.0';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.4.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.5.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '234';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.6.0';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualPatch()
    {
        $bump = SVC::PATCH;
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.2';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.3';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '0.0.4';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.4';
        $this->assertEquals($expected, (string)$this->class);
        $pre = '123';
        $this->class->setPre($pre)
                    ->bumpFullVersion($bump);
        $expected = '0.0.5';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.6';
        $this->assertEquals($expected, (string)$this->class);
        $build = '234';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.7';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualPre()
    {
        $bump = SVC::PRE;
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-1';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-2';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.2';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-3+0.0.2';
        $this->assertEquals($expected, (string)$this->class);
        $build = '123';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-4+123';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualPreMajor()
    {
        $bump = SVC::PRE_MAJOR;
        $version = '0.0.1-0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-1.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-2.0.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.4';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-3.0.0+0.0.4';
        $this->assertEquals($expected, (string)$this->class);
        $build = '123';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-4.0.0+123';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualPreMinor()
    {
        $bump = SVC::PRE_MINOR;
        $version = '0.0.1-0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-0.1.0';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-0.2.0';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.4';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.3.0+0.0.4';
        $this->assertEquals($expected, (string)$this->class);
        $build = '123';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.4.0+123';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpFullVersionWithBumpEqualPrePatch()
    {
        $bump = SVC::PRE_PATCH;
        $version = '0.0.1-0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.2';
        $this->assertEquals($expected, (string)$this->class);
        $this->class->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.3';
        $this->assertEquals($expected, (string)$this->class);
        $build = '0.0.4';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.4+0.0.4';
        $this->assertEquals($expected, (string)$this->class);
        $build = '123';
        $this->class->setBuild($build)
                    ->bumpFullVersion($bump);
        $expected = '0.0.1-0.0.5+123';
        $this->assertEquals($expected, (string)$this->class);
    }
    public function testBumpSemanticBuildThrowsDomainExceptionForUnknownBumpValue(
    )
    {
        $this->setExpectedException(
            '\DomainException',
            'Unknown bump value dump'
        );
        $bump = 'dump';
        $version = '0.0.1+0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpSemanticBuild($bump);
    }
    public function testBumpSemanticPreThrowsDomainExceptionForUnknownBumpValue(
    )
    {
        $this->setExpectedException(
            '\DomainException',
            'Unknown bump value dump'
        );
        $bump = 'dump';
        $version = '0.0.1-0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '0.0.1';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->class->bumpSemanticPre($bump);
    }
    public function testGetters()
    {
        $version = '0.1.2-3+4';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertEquals($expect, $this->class->getMajor());
        $expect = '1';
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $this->assertEquals($expect, $this->class->getMinor());
        $expect = '2';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $this->assertEquals($expect, $this->class->getPatch());
        $expect = '3';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertEquals($expect, $this->class->getPre());
        $this->assertEquals($expect, $this->class->getPreRelease());
        $expect = '4';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $this->assertEquals($expect, $this->class->getBuild());
        $expect = '0.1.2';
        $this->assertEquals($expect, $this->class->getVersion());
    }
    public function testIsValidWithBadBuildValuesReturnsFalse()
    {
        $version = '0.0.1+';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1+1.0.*';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1+.0.0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1+1..0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1+1.0.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1+a.b.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1++a.b.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
    }
    public function testIsValidWithBadPreValuesReturnsFalse()
    {
        $version = '0.0.1-';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1-1.0.*';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1-.0.0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1-1..0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1-1.0.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1-a.b.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '0.0.1--a.b.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
    }
    public function testIsValidWithBadVersionValuesReturnsFalse()
    {
        $version = '';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '1.0.*';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '1.0.0+1+1';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '1.0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '.0.0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '1..0';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '1.0.';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
        $version = '1.0.a';
        $result = $this->class->isValid($version);
        $this->assertFalse($result);
    }
    public function testIsValidWithGoodBuildValuesReturnsTrue()
    {
        $version = '0.2.0+1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '0.0.3+0.1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0+a.b';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0+a-b';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0+a-1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
    }
    public function testIsValidWithGoodPreValuesReturnsTrue()
    {
        $version = '0.2.0-1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '0.0.3-0.1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0-a.b';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0-a-b';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0-a-1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
    }
    public function testIsValidWithGoodVersionValuesReturnsTrue()
    {
        $version = '1.0.0';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '0.2.0-1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '0.0.3+1';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
        $version = '1.0.0-2+3';
        $result = $this->class->isValid($version);
        $this->assertTrue($result);
    }
    public function testParseFullVersion()
    {
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '1';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $version = '0.2.0-1.0.0';
        $this->class->parseFullVersion($version);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $expect = '2';
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '1.0.0';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $version = '3.0.0+1.0.0';
        $this->class->parseFullVersion($version);
        $expect = '3';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $expect = '0';
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '1.0.0';
        $this->assertAttributeEquals($expect, 'build', $this->class);
        $version = '4.4.4-2+3';
        $this->class->parseFullVersion($version);
        $expect = '4';
        $this->assertAttributeEquals($expect, 'major', $this->class);
        $this->assertAttributeEquals($expect, 'minor', $this->class);
        $this->assertAttributeEquals($expect, 'patch', $this->class);
        $expect = '2';
        $this->assertAttributeEquals($expect, 'pre', $this->class);
        $expect = '3';
        $this->assertAttributeEquals($expect, 'build', $this->class);
    }
    public function testSetBuildThrowsDomainExceptionForInvalidValue()
    {
        $value = 'dump<';
        $this->setExpectedException(
            '\DomainException',
            'Given invalid build value: ' . $value
        );
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->class->setBuild($value);
    }
    public function testSetMajorThrowsDomainExceptionForInvalidValue()
    {
        $value = 'dump';
        $this->setExpectedException(
            '\DomainException',
            'Given invalid major value: ' . $value
        );
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->class->setMajor($value);
    }
    public function testSetMinorThrowsDomainExceptionForInvalidValue()
    {
        $value = 'dump';
        $this->setExpectedException(
            '\DomainException',
            'Given invalid minor value: ' . $value
        );
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->class->setMinor($value);
    }
    public function testSetPatchThrowsDomainExceptionForInvalidValue()
    {
        $value = 'dump';
        $this->setExpectedException(
            '\DomainException',
            'Given invalid patch value: ' . $value
        );
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->class->setPatch($value);
    }
    public function testSetPreReleaseThrowsDomainExceptionForInvalidValue()
    {
        $value = 'dump<';
        $this->setExpectedException(
            '\DomainException',
            'Given invalid pre-release value: ' . $value
        );
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->class->setPreRelease($value);
    }
    public function testSetVersionThrowsDomainExceptionForInvalidValue()
    {
        $value = 'dump';
        $this->setExpectedException(
            '\DomainException',
            'Given invalid version value: ' . $value
        );
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->class->setVersion($value);
    }
    public function testToString()
    {
        $version = '0.0.1';
        $this->class->parseFullVersion($version);
        $this->assertEquals($version, (string)$this->class);
        $version = '0.2.0-1';
        $this->class->parseFullVersion($version);
        $this->assertEquals($version, (string)$this->class);
        $version = '3.0.0+2';
        $this->class->parseFullVersion($version);
        $this->assertEquals($version, (string)$this->class);
        $version = '5.0.0-2+3';
        $this->class->parseFullVersion($version);
        $this->assertEquals($version, (string)$this->class);
    }
}
