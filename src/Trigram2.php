<?php

namespace Codiliateur\TextSimilarity;

use Codiliateur\TextSimilarity\WordTrigramIterator;

class Trigram2
{
    /**
     * @param string $text1
     * @param string $text2
     * @return float
     */
    public static function similarity(string $sentence1, string $sentence2)
    {

        $trigrams1 = self::getSentenceTrigrams($sentence1);
        $trigrams2 = self::getSentenceTrigrams($sentence2);

        $matched = 0;
        $notMatched = 0;

        foreach ($trigrams2 as $trigram => $weight) {
            if (!isset($trigrams1[$trigram])) {
                $notMatched += $weight;
            } elseif ($trigrams1[$trigram] >= $weight) {
                $matched += $weight;
                $trigrams1[$trigram] -= $weight;
            } else {
                $notMatched += ($matched - $trigrams1[$trigram]);
                $matched += $trigrams1[$trigram];
                $trigrams1[$trigram] = 0;
            }
        }

        foreach ($trigrams1 as $trigram => $weight) {
            if ($weight > 0) {
                $notMatched += $weight;
            }
        }

        return round($matched / ($matched + $notMatched), 6);
    }

    /**
     * @param string $sentence
     * @return string[]
     */
    public static function getSentenceWords(string $sentence)
    {
        return explode(' ', trim($sentence));
    }

    /**
     * @param string $sentence
     * @return array
     */
    public static function getSentenceTrigrams(string $sentence)
    {
        $trigrams = [];
        foreach (self::getSentenceWords($sentence) as $word) {
            $trigramIterator = new WordTrigramIterator($word);
            foreach ($trigramIterator as $trigram) {
                $trigrams[$trigram] = ($trigrams[$trigram] ?? 0) + 1;
            }
        }

        return $trigrams;
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
