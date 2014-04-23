<?php namespace CmdZ\SpamCanner\Filters;

class StatusOfPreviousComment extends FilterAbstract
{
    protected $currentCommentEmail;
    protected $previousCommentEmail;
    protected $previousCommentFlag;
    protected $increase;
    protected $decrease;
    protected $spamFlag;

    public function __construct(
      $increase,
      $decrease,
      $currentCommentEmail,
      $previousCommentEmail,
      $spamFlag,
      $previousCommentFlag
    ) {
        $this->currentCommentEmail  = $currentCommentEmail;
        $this->decrease             = $decrease;
        $this->spamFlag             = $spamFlag;
        $this->increase             = $increase;
        $this->previousCommentEmail = $previousCommentEmail;
        $this->previousCommentFlag  = $previousCommentFlag;
    }

    protected function calcScore()
    {
        if ($this->increase <= 0) return 0;
        if ($this->currentCommentEmail != $this->previousCommentEmail) return 0;
        if ($this->previousCommentFlag == $this->spamFlag) return $this->increase;
        if ($this->previousCommentFlag != $this->spamFlag) return -$this->decrease;
        return 0;
    }
}
