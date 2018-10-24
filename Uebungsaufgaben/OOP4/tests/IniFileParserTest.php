<?php


use PHPUnit\Framework\TestCase;

/** @covers IniFileParser */
class IniFileParserTest extends TestCase
{
    /** @var IniFileParser */
    private $iniFileParser;

    protected function setUp()
    {
        $this->iniFileParser = new IniFileParser('TestConfiguration.ini');
    }

    public function testParse()
    {
        $arrayTest = array(
            'test' => 'test'
        );
        $this->assertEquals($arrayTest, $this->iniFileParser->parse()['test']);

    }

}
