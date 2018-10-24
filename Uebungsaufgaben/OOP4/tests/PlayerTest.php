<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers Player
 */
class PlayerTest extends TestCase
{
    /** @var Player */
    private $player;
    /** @var StandardOutLogger| PHPUnit_Framework_MockObject_MockObject */
    private $logger;
    /** @var Card | PHPUnit_Framework_MockObject_MockObject $card */
    private $card;
    /** @var Color | PHPUnit_Framework_MockObject_MockObject $color */
    private $color;

    protected function setUp()
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->color = $this->createMock(Color::class);
        $this->player = new Player('Jonathan', $this->logger);
        $this->card = $this->createMock(Card::class);
    }

    public function testGetName()
    {
        $this->assertSame('Jonathan', $this->player->getName());
    }

    public function testAddToCards()
    {
        $this->player->addToCards($this->card);
        $givenCard = $this->player->getCards();
        $this->assertEquals($this->card, $givenCard[0]);
    }

    public function testGetCards()
    {
        $cardArray = array($this->card);
        $this->player->addToCards($this->card);
        $this->assertEquals($cardArray, $this->player->getCards());
    }

    public function testHasWonTrue()
    {
        $this->player->addToCards($this->card);
        $this->card->method('isTurned')->willReturn(true);
        $this->assertEquals(true, $this->player->hasWon());
    }

    public function testHasWonFalse()
    {
        $this->player->addToCards($this->card);
        $this->card->method('isTurned')->willReturn(false);
        $this->assertEquals(false, $this->player->hasWon());
    }

    public function testMakeTurn()
    {
        $this->card->method('getColor')->willReturn($this->color);
        $this->card->method('__toString')->willReturn(' green Card ');
//        $this->logger
//            ->expects($this->exactly(2))
//            ->method('log')
//            ->withConsecutive(
//                ['Jonathan has rolled the color Green'],
//                ['Jonathan has won the game']
//            );
        $this->logger
            ->expects($this->exactly(2))
            ->method('log')
            ->withConsecutive(
                ['Jonathan has rolled the color Green'],
                [$this->player->getName() . ': My ' . $this->card . ' is still active']
            );


        $dice = $this->createMock(Dice::class);
        $dice->method('roll')->willReturn($this->color);
        $this->color
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('Green');
        $this->card->method('isTurned')->willReturn(false);
        $this->player->addToCards($this->card);
        $this->player->makeTurn($dice);
        $this->assertEquals(false, $this->player->hasWon());
    }
}
