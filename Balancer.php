<?php


class Balancer {
    private $stack;
    private $changed_stack;

    private $brackets = array("(" => ")",
                            "[" => ']',
                            "{" => "}");

    public function __construct()
    {
        $this->stack = new SplStack();
        $this->changed_stack = false;
    }

    private function isOpeningBracket($candidate)
    {
        return in_array($candidate, array_keys($this->brackets));
    }

    private function isClosingBracket($candidate)
    {
        return in_array($candidate, array_values($this->brackets));
    }

    private function isMatchingBracketPair($opening_bracket, $closing_bracket)
    {
        return 0 === strcmp($this->brackets[$opening_bracket], $closing_bracket);
    }

    private function addToStack($candidate)
    {
        $this->stack->push($candidate);
        $this->changed_stack = true;
    }

    private function stackEmptyAfterWork()
    {
        if ($this->changed_stack)
            return $this->stack->isEmpty();
        else
            return false;

    }


    public function isBalanced($input_string) {
        foreach (str_split($input_string) as $char){
            if ($this->isOpeningBracket($char)) {
                $this->addToStack($char);
            } elseif ($this->isClosingBracket($char)) {
                if ($this->stack->isEmpty()) return false;

                $last_opening_bracket = $this->stack->pop();
                if (!$this->isMatchingBracketPair($last_opening_bracket, $char)) {
                    return false;
                }
            } else {
                continue;
            }
        }

        return $this->stackEmptyAfterWork();
    }
}
