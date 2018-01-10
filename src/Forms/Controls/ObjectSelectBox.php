<?php

declare(strict_types = 1);

namespace AipNg\Forms\Controls;

use AipNg\Forms\InvalidArgumentException;
use Nette\Forms\Controls\SelectBox;

final class ObjectSelectBox extends SelectBox
{

	/** @var callable */
	private $pairCallback;

	/** @var mixed[] */
	private $objects = [];


	/**
	 * @param string $label
	 * @param mixed[] $items
	 * @param callable $callback transforms given item into string[] format: key (int|string) => label (string)
	 */
	public function __construct(string $label, array $items, callable $callback)
	{
		$this->pairCallback = $callback;

		$parentItems = [];

		foreach ($items as $item) {
			$itemKey = $this->getObjectKey($item);
			$parentItems[$itemKey] = $this->getObjectLabel($item);
			$this->objects[$itemKey] = $item;
		}

		parent::__construct($label, $parentItems);
	}


	/**
	 * @param object|null $value
	 *
	 * @return static
	 */
	public function setValue($value)
	{
		try {
			if (!$value) {
				parent::setValue($value);
			} elseif (is_object($value)) {
				$this->throwExceptionWhenNotInRange($value);

				parent::setValue($this->getObjectKey($value));
			} else {
				throw new InvalidArgumentException('Given value out of allowed set.');
			}
		} catch (\Nette\InvalidArgumentException $e) {
			throw new InvalidArgumentException('Given value out of allowed set.', 0, $e);
		}

		return $this;
	}


	/**
	 * @inheritdoc
	 */
	public function getValue()
	{
		$scalarValue = parent::getValue();

		return array_key_exists($scalarValue, $this->objects)
			? $this->objects[$scalarValue]
			: null;
	}


	/**
	 * @param mixed $object
	 *
	 * @return int|string
	 */
	private function getObjectKey($object)
	{
		$pair = call_user_func($this->pairCallback, $object);

		return key($pair);
	}


	/**
	 * @param mixed $object
	 *
	 * @return string
	 */
	private function getObjectLabel($object): string
	{
		$pair = call_user_func($this->pairCallback, $object);

		return current($pair);
	}


	/**
	 * @param mixed $object
	 *
	 * @throws \AipNg\Forms\InvalidArgumentException
	 */
	private function throwExceptionWhenNotInRange($object): void
	{
		if (!in_array($object, $this->objects, true)) {
			throw new InvalidArgumentException('Given value out of allowed set.');
		}
	}

}
