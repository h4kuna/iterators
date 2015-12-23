<?php

namespace h4kuna\Iterators;

/**
 * @author Milan Matějček
 */
class ArrayRound
{

	/** @var Iterator */
	private $data;

	/**
	 * @param array|\ArrayIterator $data
	 * @throws \RuntimeException
	 */
	public function __construct($data)
	{
		if (is_array($data)) {
			$data = new \ArrayIterator($data);
		} elseif (!$data instanceof \Iterator) {
			throw new \RuntimeException('Input must be instance of interface Iterator or basic array.');
		}
		$this->data = $data;
		$this->rewind();
	}

	public function item()
	{
		$this->valid();
		$value = $this->data->current();
		$this->next();
		return $value;
	}

	public function current()
	{
		return $this->data->current();
	}

	public function key()
	{
		return $this->data->key();
	}

	public function rewind()
	{
		$this->data->rewind();
	}

	private function next()
	{
		$this->data->next();
	}

	private function valid()
	{
		if (!$this->data->valid()) {
			$this->rewind();
		}
		return TRUE;
	}

}
