<?php

namespace h4kuna\Iterators;

class ReverseArrayIterator implements \Iterator
{
	private $array;


	public function __construct(array $array)
	{
		$this->array = $array;
	}


	public function current()
	{
		return current($this->array);
	}


	public function next()
	{
		prev($this->array);
	}


	public function key()
	{
		return key($this->array);
	}


	public function valid()
	{
		return key($this->array) !== null;
	}


	public function rewind()
	{
		end($this->array);
	}

}
