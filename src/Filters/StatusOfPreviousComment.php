<?php namespace CmdZ\SpamCanner\Filters;

class StatusOfPreviousComment extends FilterAbstract
{
    protected $currentCommentEmail;
    protected $previousCommentEmail;
    protected $currentCommentFlag;
    protected $previousCommentFlag;
    protected $increase;
    protected $decrease;
    protected $flag;

    public function __construct(
        $currentCommentEmail,
        $decrease,
        $flag,
        $increase,
        $previousCommentEmail,
        $previousCommentFlag
    ) {
        $this->currentCommentEmail  = $currentCommentEmail;
        $this->decrease             = $decrease;
        $this->flag                 = $flag;
        $this->increase             = $increase;
        $this->previousCommentEmail = $previousCommentEmail;
        $this->previousCommentFlag  = $previousCommentFlag;
    }

    protected function calcScore()
    {
        if ($this->increase <= 0) return 0;
        if ($this->currentCommentEmail != $this->previousCommentEmail) return 0;
        if ($this->previousCommentFlag == $this->flag) return $this->increase;
        if ($this->previousCommentFlag != $this->flag) return -$this->decrease;
        return 0;
    }
}
