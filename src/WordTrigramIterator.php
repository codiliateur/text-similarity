<?php

namespace Codiliateur\TextSimilarity;

use Iterator;

class WordTrigramIterator implements Iterator
{
    /**
     * @var int
     */
    private int $position = 0;

    /**
     * @var int
     */
    private $maxPosition = 0;

    /**
     * @var string
     */
    protected $word;

    /**
     * @param string $word
     */
    public function __construct(string $word)
    {
        $this->word = $this->prepareWord($word);
        $this->position = 0;
        $this->maxPosition = mb_strlen($word);
    }

    /**
     * @param string $word
     * @return string
     */
    protected function prepareWord(string $word): string
    {
        return '  ' . $word . ' ';
    }

    /**
     * @param $position
     * @return string
     */
    protected function getTrigram(int $position)
    {
        return mb_substr($this->word, $position, 3);
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->getTrigram($this->position);
    }

    /**
     * @return void
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * @return mixed
     */
    public function key(): mixed
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return ($this->position >= 0) && ($this->position <= $this->maxPosition);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }
}
