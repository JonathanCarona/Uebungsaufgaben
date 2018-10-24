<?php


class Dice
{
    /** @var Color */
    private $color;
    /** @var Configuration  */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    public function roll(): Color
    {
        $possibleColors = $this->configuration->getPossibleColors();
        $intDiceColor = rand(0, count($possibleColors) - 1);
        $this->color = $possibleColors[$intDiceColor];
        return $this->color;
    }

}
