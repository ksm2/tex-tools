<?php /** File containing test LogParserTest */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\Log\LogParser;
use CornyPhoenix\Tex\Log\Log;

/**
 * Tests log parsing.
 *
 * @package CornyPhoenix\Tex\Tests
 * @date 05.09.14
 * @author moellers
 */
class LogParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests if the parser works correctly for accurate compilations.
     *
     * @test
     */
    public function testParsingAccurateLog()
    {
        $log = file_get_contents(__DIR__ . '/../../data/noErrors.txt');
        $parser = new LogParser($log);
        $log = $parser->parse();

        $this->assertInstanceOf(Log::class, $log, 'Parser returned invalid result');
        $this->assertEmpty($log->getErrors(), 'Parser should not have detected errors');
        $this->assertEmpty($log->getWarnings(), 'Parser should not have detected warnings');
        $this->assertEmpty($log->getBadBoxes(), 'Parser should not have detected bad boxes');
        $this->assertEmpty($log->getAllMessages(), 'Parser should not have detected any messages');
    }

    /**
     * Tests if the parser works correctly for bad boxes.
     *
     * @test
     */
    public function testParsingBadHorizontalBoxLog()
    {
        $log = file_get_contents(__DIR__ . '/../../data/badBox.txt');
        $parser = new LogParser($log);
        $log = $parser->parse();

        $this->assertInstanceOf(Log::class, $log, 'Parser returned invalid result');
        $this->assertEmpty($log->getErrors(), 'Parser should not have detected errors');
        $this->assertEmpty($log->getWarnings(), 'Parser should not have detected warnings');
        $this->assertCount(2, $log->getBadBoxes(), 'Parser should have detected 2 bad boxes');

        $badBox1 = $log->getBadBoxes()[0];
        $this->assertEquals('Bad Box', $badBox1->getMessage(), 'Wrong bad box content');
        $this->assertEquals('Badness 10000 underfull horizontal box.', $badBox1->getContent(), 'Wrong bad box message');
        $this->assertEquals(6, $badBox1->getLine(), 'Wrong bad box line');
        $this->assertEquals('./data/test.tex', $badBox1->getFilename(), 'Wrong bad box filename');

        $badBox2 = $log->getBadBoxes()[1];
        $this->assertEquals('Bad Box', $badBox2->getMessage(), 'Wrong bad box content');
        $this->assertEquals('17.62482pt too wide overfull horizontal box.', $badBox2->getContent(), 'Wrong bad box message');
        $this->assertEquals(6, $badBox2->getLine(), 'Wrong bad box line');
        $this->assertEquals('./data/test.tex', $badBox2->getFilename(), 'Wrong bad box filename');
    }

    /**
     * Tests if the parser works correctly for undefined control sequences.
     *
     * @test
     */
    public function testParsingUndefinedControlSequenceErrors()
    {
        $log = file_get_contents(__DIR__ . '/../../data/errorUndefControlSeq.txt');
        $parser = new LogParser($log);
        $log = $parser->parse();

        $this->assertInstanceOf(Log::class, $log, 'Parser returned invalid result');
        $this->assertEmpty($log->getBadBoxes(), 'Parser should not have detected bad boxes');
        $this->assertEmpty($log->getWarnings(), 'Parser should not have detected warnings');
        $this->assertCount(1, $log->getErrors(), 'Parser should not have detected 1 error');
        $this->assertCount(1, $log->getAllMessages(), 'Parser should only have detected 1 message');

        $error = $log->getErrors()[0];
        $this->assertEquals('Undefined control sequence', $error->getMessage(), 'Wrong error message');
        $this->assertEquals(6, $error->getLine(), 'Wrong error line');
        $this->assertEquals('./data/test.tex', $error->getFilename(), 'Wrong error filename');
        $this->assertStringEndsWith('\tableofcotnetns', $error->getContent(), 'Wrong error content');
    }

    /**
     * Tests if the parser works correctly for warnings.
     *
     * @test
     */
    public function testParsingWarnings()
    {
        $log = file_get_contents(__DIR__ . '/../../data/warning.txt');
        $parser = new LogParser($log);
        $log = $parser->parse();

        $this->assertInstanceOf(Log::class, $log, 'Parser returned invalid result');
        $this->assertEmpty($log->getBadBoxes(), 'Parser should not have detected bad boxes');
        $this->assertEmpty($log->getErrors(), 'Parser should not have detected errors');
        $this->assertCount(3, $log->getWarnings(), 'Parser should have detected 3 warnings');
        $this->assertCount(3, $log->getAllMessages(), 'Parser should only have detected 3 messages');

        $warning = $log->getWarnings()[0];
        $this->assertEquals('Font', $warning->getMessage(), 'Wrong warning message');
        $this->assertEquals(6, $warning->getLine(), 'Wrong warning line');
        $this->assertEquals('./data/test.tex', $warning->getFilename(), 'Wrong warning filename');
        $this->assertEquals('Font shape `OT1/cmr/bx/sc\' undefined', $warning->getContent(), 'Wrong warning content');

        $warning = $log->getWarnings()[1];
        $this->assertEquals('Font', $warning->getMessage(), 'Wrong warning message');
        $this->assertEquals(6, $warning->getLine(), 'Wrong warning line');
        $this->assertEquals('./data/test.tex', $warning->getFilename(), 'Wrong warning filename');
        $this->assertEquals('Font shape `OT1/cmss/bx/it\' undefined', $warning->getContent(), 'Wrong content');

        $warning = $log->getWarnings()[2];
        $this->assertEquals('Font', $warning->getMessage(), 'Wrong warning message');
        $this->assertNull($warning->getLine(), 'Wrong warning line');
        $this->assertEquals('./data/test.tex', $warning->getFilename(), 'Wrong warning filename');
        $this->assertEquals('Some font shapes were not available, defaults substituted.', $warning->getContent());
    }
}
