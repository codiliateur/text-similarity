<?php

namespace Codiliateur\TextSimilarity;

use Codiliateur\TextSimilarity\WordTrigramIterator;

class Trigram
{
    /**
     * @param string $text1
     * @param string $text2
     * @return float
     */
    public static function similarity(string $text1, string $text2)
    {

        $trigrams1 = self::getSentenceTrigrams(self::normalizeSentence($text1));
        $trigrams2 = self::getSentenceTrigrams(self::normalizeSentence($text2));

        $matchesCount = count(array_intersect($trigrams1, $trigrams2));
        $trigramsCount = count(array_unique(array_values(array_merge($trigrams1, $trigrams2))));

        return round($matchesCount / $trigramsCount, 6);
    }

    /**
     * @param string $text
     * @return array
     */
    public static function getSentenceTrigrams(string $text)
    {
        $trigrams= [];
        foreach (explode(' ', $text) as $word) {
            if (mb_strlen($word) > 0) {
                $trigrams = array_merge($trigrams, array_diff(self::getWordTrigrams($word), $trigrams));
            }
        }

        return $trigrams;
    }

    /**
     * @param string $text
     * @return array
     */
    public static function getWordTrigrams(string $text): array
    {
        $trigrams = [];
        $trigramIterator = new WordTrigramIterator($text);
        foreach ($trigramIterator as $trigram) {
            $trigrams[$trigram] = null;
        }

        return array_keys($trigrams);
    }

    /**
     * @param string $sentence
     * @return string
     */
    public static function normalizeSentence(string $sentence): string
    {
        $sentence = trim(mb_strtolower($sentence));
        $sentence = preg_replace('/[{~`\.,:;\!?@#$%^&*()_\-+=\\\|{}\[\]\"\'\/<>\s]/mu',' ',$sentence);
        $sentence = preg_replace('/^ +| +$|( ) +/mu', ' ', $sentence);

        return trim($sentence);
    }
}
