<?php

namespace h4kuna\Iterators;

class RangeIterator implements \Iterator, \Countable, \ArrayAccess
{

	/** @var ListNode[] */
	private $array = [];

	/** @var mixed */
	private $from;

	/** @var mixed */
	private $to;

	/** @var mixed */
	private $counter;

	/** @var bool */
	private $nextEnd = FALSE;

	public function __construct($array)
	{
		$node = NULL;
		foreach ($array as $key => $value) {
			$this->array[$key] = $node = new ListNode($value, $key, $node);
		}
	}

	public function from($position)
	{
		$this->from = $position;
		return $this;
	}

	public function to($position)
	{
		$this->to = $position;
		return $this;
	}

	public function between($from, $to)
	{
		$this->from($from)->to($to);
		return $this;
	}

	public function reset()
	{
		$this->from(NULL)->to(NULL);
		return $this;
	}

	public function count()
	{
		return count($this->array);
	}

	public function current()
	{
		return $this->array[$this->counter]->value;
	}

	public function key()
	{
		return $this->counter;
	}

	public function next()
	{
		$this->setCounter($this->array[$this->counter]->getNext());
		return $this;
	}

	public function prev()
	{
		$this->setCounter($this->array[$this->counter]->getPrev());
		return $this;
	}

	/**
	 * Available only in iterator.
	 * @return bool
	 */
	public function isLast()
	{
		/* @var $val ListNode */
		$val = $this->array[$this->counter];
		return $val->getNext() === NULL || $this->to === $val->key;
	}

	/**
	 * Available only in iterator.
	 * @return bool
	 */
	public function isFirst()
	{
		/* @var $val ListNode */
		$val = $this->array[$this->counter];
		return $val->getPrev() === NULL || $this->from === $val->key;
	}

	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->array);
	}

	public function offsetGet($offset)
	{
		return $this->array[$offset]->value;
	}

	public function offsetSet($offset, $value)
	{
		if (!$this->offsetExists($offset)) {
			throw new \RuntimeException('You can\'t add new node.');
		}
		$this->array[$offset]->value = $value;
	}

	public function offsetUnset($offset)
	{
		throw new \RuntimeException('You can\'t remove node.');
	}

	public function rewind()
	{
		if ($this->from === NULL) {
			reset($this->array);
			$this->counter = key($this->array);
		} else {
			$this->counter = $this->from;
		}
		$this->nextEnd = FALSE;
		return $this;
	}

	public function valid()
	{
		return $this->counter !== NULL;
	}

	private function setCounter($val)
	{
		if ($val === NULL || $this->nextEnd) {
			$this->nextEnd = FALSE;
			$this->counter = NULL;
		} else {
			if ($val->key === $this->to) {
				$this->nextEnd = TRUE;
			}
			$this->counter = $val->key;
		}
	}

}

/**
 * @internal
 */
class ListNode
{

	/** @var self */
	private $next;

	/** @var self */
	private $prev;

	/** @var mixed */
	public $value;

	/** @var $key */
	public $key;

	public function __construct($value, $key, self $nodeList = NULL)
	{
		$this->value = $value;
		$this->key = $key;
		if ($nodeList) {
			$nodeList->setNext($this);
		}
	}

	public function getNext()
	{
		return $this->next;
	}

	public function getPrev()
	{
		return $this->prev;
	}

	private function setNext(self $nodeList)
	{
		$this->next = $nodeList;
		$nodeList->prev = $this;
	}

}
