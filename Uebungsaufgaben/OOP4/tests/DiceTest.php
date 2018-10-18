<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers Dice
 */
class DiceTest extends TestCase
{
    /** @var Configuration | PHPUnit_Framework_MockObject_MockObject */
    private $configuration;
    /** @var Dice */
    private $dice;

    protected function setUp()
    {
        $this->configuration = $this->createMock(Configuration::class);
        $this->dice = new Dice($this->configuration);
    }

    public function testRoll()
    {
        $color = $this->createMock(Color::class);
        $colorArray[] = $color;
        $this->configuration->method('getConfPossibleColors')->willReturn($colorArray);
        $this->assertEquals($color, $this->dice->roll());
    }

}
