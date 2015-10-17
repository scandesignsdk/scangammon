<?php
namespace AppBundle\Service;

class EloService
{

    protected $_ratingA;
    protected $_ratingB;

    protected $_scoreA;
    protected $_scoreB;
    protected $_expectedA;
    protected $_expectedB;
    protected $_newRatingA;
    protected $_newRatingB;

    private $kfactor;

    public function __construct($kfactor = 16)
    {
        $this->kfactor = $kfactor;
    }

    /**
     * Costructor function which does all the maths and stores the results ready
     * for retrieval.
     *
     * @param int $ratingA Current rating of A
     * @param int $ratingB Current rating of B
     * @param int $scoreA Score of A
     * @param int $scoreB Score of B
     * @return array
     */
    public function calculate($ratingA, $ratingB, $scoreA, $scoreB)
    {
        $this->_ratingA = $ratingA;
        $this->_ratingB = $ratingB;
        $this->_scoreA = $scoreA;
        $this->_scoreB = $scoreB;
        $expectedScores = $this->_getExpectedScores($this->_ratingA, $this->_ratingB);
        $this->_expectedA = $expectedScores['a'];
        $this->_expectedB = $expectedScores['b'];
        $newRatings = $this->_getNewRatings($this->_ratingA, $this->_ratingB, $this->_expectedA, $this->_expectedB, $this->_scoreA, $this->_scoreB);
        $this->_newRatingA = $newRatings['a'];
        $this->_newRatingB = $newRatings['b'];

        return [
            1 => $newRatings['a'],
            2 => $newRatings['b'],
        ];
    }

    /**
     * Protected & private functions begin here
     * @param $ratingA
     * @param $ratingB
     * @return array
     */
    protected function _getExpectedScores($ratingA, $ratingB)
    {
        $expectedScoreA = 1 / (1 + (pow(10, ($ratingB - $ratingA) / 400)));
        $expectedScoreB = 1 / (1 + (pow(10, ($ratingA - $ratingB) / 400)));
        return array(
            'a' => $expectedScoreA,
            'b' => $expectedScoreB
        );
    }

    protected function _getNewRatings($ratingA, $ratingB, $expectedA, $expectedB, $scoreA, $scoreB)
    {
        $newRatingA = $ratingA + ($this->kfactor * ($scoreA - $expectedA));
        $newRatingB = $ratingB + ($this->kfactor * ($scoreB - $expectedB));
        return array(
            'a' => $newRatingA,
            'b' => $newRatingB
        );
    }

}
