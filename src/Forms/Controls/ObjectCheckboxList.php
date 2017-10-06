<?php

declare(strict_types = 1);

namespace AipNg\Forms\Controls;

use AipNg\Forms\InvalidArgumentException;
use Nette\Forms\Controls\CheckboxList;

class ObjectCheckboxList extends CheckboxList
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
	 * @param mixed $value
	 *
	 * @return static
	 *
	 * @throws \AipNg\Forms\InvalidArgumentException
	 */
	public function setValue($value)
	{
		try {
			if (!$value) {
				parent::setValue($value);
			} elseif (is_object($value)) {
				$this->throwExceptionWhenNotInRange($value);

				parent::setValue($this->getObjectKey($value));
			} elseif (is_array($value)) {
				$objectIds = [];
				foreach ($value as $object) {
					$this->throwExceptionWhenNotInRange($object);

					$objectIds[] = $this->getObjectKey($object);
				}

				parent::setValue($objectIds);
			} else {
				throw new InvalidArgumentException('Given value out of allowed set.');
			}
		} catch (\Nette\InvalidArgumentException $e) {
			throw new InvalidArgumentException('Given value out of allowed set.', 0, $e);
		}

		return $this;
	}


	/**
	 * @return mixed[]
	 */
	public function getValue(): array
	{
		return array_map(function ($itemKey) {
			return $this->objects[$itemKey];
		}, parent::getValue());
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
