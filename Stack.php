<?php

namespace h4kuna;

/**
 * Description of Stack LIFO
 *
 * @author Milan Matějček
 */
class Stack extends \ArrayIterator {

    public function pop() {
        $this->seek($this->count() - 1);
        $key = $this->key();
        $val = $this->current();
        $this->offsetUnset($key);
        return array($key, $val);
    }

}
