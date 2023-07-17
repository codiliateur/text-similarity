# text-similarity

This package provides Trigram algorithm based functions for phrase similarity identification.

## Class Codiliateur\TextSimilarity\Trigram

Implementation of classic trigram algorithm.

    use Codiliateur\TextSimilarity\Trigram;

    Trigram::similarity('one two tree', 'tree two one')  // 1.0
    Trigram::similarity('one two', 'one two two one')  // 1.0
    Trigram::similarity('6 cat eat 6 mouse', 'cat eat 6 mouse')  // 1.0
    Trigram::similarity('one two', 'tree two one')  // 0.615385

## Class Codiliateur\TextSimilarity\TrigramPlus

Customized implementation of trigram algorithm with counting repeats matched trigram.

    use Codiliateur\TextSimilarity\TrigramPlus;

    TrigramPlus::similarity('one two tree', 'tree two one')  // 1.0
    TrigramPlus::similarity('one two', 'one two two one')  // 0.285714
    Trigram::similarity('6 cat eat 6 mouse', 'cat eat 6 mouse')  // 0.888889
    TrigramPlus::similarity('one two', 'tree two one')  // 0.666667

