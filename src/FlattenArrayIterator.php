<?php declare(strict_types=1);

namespace h4kuna\Iterators;

/**
 * @use new \RecursiveIteratorIterator(new FlattenArrayIterator($data));
 */
class FlattenArrayIterator implements \RecursiveIterator
{
	private array $data;

	private array $keys = [];

	private string $delimiter;


	public function __construct(array $data, string $delimiter = '-')
	{
		$this->data = $data;
		$this->delimiter = $delimiter;
	}


	public function current()
	{
		return current($this->data);
	}


	public function next()
	{
		next($this->data);
	}


	public function key()
	{
		return implode($this->delimiter, $this->keys);
	}


	public function valid()
	{
		$key = key($this->data);
		if ($key === null) {
			return false;
		}
		$lastKey = (int) array_key_last($this->keys);
		$this->keys[$lastKey] = $key;

		return isset($this->data[$key]);
	}


	public function rewind(): void
	{
		reset($this->data);
		$this->keys[] = '';
	}


	public function hasChildren(): bool
	{
		return is_array($this->current());
	}


	public function getChildren()
	{
		$child = new static($this->current(), $this->delimiter);
		$child->addKeys($this->keys);

		return $child;
	}


	protected function addKeys(array $keys): void
	{
		$this->keys = $keys;
	}

}
