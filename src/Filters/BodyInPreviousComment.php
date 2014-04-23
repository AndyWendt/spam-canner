<?php namespace CmdZ\SpamCanner\Filters;

class BodyInPreviousComment extends FilterAbstract
{
    protected $currentCommentBody;
    protected $prevCommentBody;
    protected $increase;

    public function __construct($increase, $currentCommentBody, $prevCommentBody)
    {
        $this->currentCommentBody = $currentCommentBody;
        $this->increase           = $increase;
        $this->prevCommentBody    = $prevCommentBody;
    }

    protected function calcScore()
    {
        if ($this->increase <= 0) return 0;
        if ($this->currentCommentBody == $this->prevCommentBody) return $this->increase;
        return 0;
    }
}
