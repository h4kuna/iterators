<?php

namespace h4kuna\Iterators;

/**
 * Convert hash to array and array to hash.
 * @author Milan Matějček
 */
class Base64Array extends \ArrayIterator
{

	/**
	 * @param array|string $array
	 * @throws \RuntimeException
	 */
	public function __construct($array)
	{
		if (is_string($array)) {
			$array = $this->decode($array);
		} elseif (!is_array($array)) {
			throw new \RuntimeException('Param must be array or string');
		}
		parent::__construct($array);
	}

	/**
	 * @param self $array
	 * @return string
	 */
	private function encode(self $array)
	{
		return base64_encode(serialize($array->getArrayCopy()));
	}

	/**
	 * @param string $s
	 * @return self
	 * @throws \RuntimeException
	 */
	private function decode($s)
	{
		$base = @unserialize(base64_decode($s));
		if (!$base) {
			throw new \RuntimeException('This is not valid base64 hash. ' . $s);
		}
		return $base;
	}

	/**
	 * Base 64 encoded string.
	 *  @return string
	 */
	public function hash()
	{
		return $this->encode($this);
	}

	public function __toString()
	{
		return $this->hash();
	}

}
