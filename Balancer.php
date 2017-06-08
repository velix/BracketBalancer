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
//    accepts a string to be checked for balanced brackets
    public function isBalanced($input_string) {
//        split into characters and for each
        foreach (str_split($input_string) as $char){
//            check if current character is opening or closing bracket
            if ($this->isOpeningBracket($char)) {
//                if it's opening, push to stack with the expectation to be removed when a matching closing bracket is found
                $this->addToStack($char);
            } elseif ($this->isClosingBracket($char)) {
//                if it's closing, check stack
//                if it's empty, we have never before encountered any opening bracket, and so the string's brackets are unbalanced
                if ($this->stack->isEmpty()) return false;

//                pop last bracket pushed into stack. We expect it to be the matching opening bracket.
//                If the last inserted bracket is not the matching opening bracket to the current closing one,
//                we know that the string is unbalanced since balanced brackets come in succession.
                $last_opening_bracket = $this->stack->pop();
                if (!$this->isMatchingBracketPair($last_opening_bracket, $char)) {
                    return false;
                }
            } else {
                continue;
            }
        }
//        After running through the string, we check the stack
//        If it's empty it means two things:
//        either all added brackets were removed because matching found brackets were found
//        or no brackets were ever pushed, because non were present in the string
        return $this->stackEmptyAfterWork();
    }
}
