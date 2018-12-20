<?php

// phpcs:ignoreFile -- errors in PHP 7.2+ because of missing object|null type hints

declare(strict_types = 1);

namespace AipNg\Forms\Controls;

use AipNg\Forms\InvalidArgumentException;
use Nette\Forms\Controls\CheckboxList;

class ObjectCheckboxList extends CheckboxList
{

	/** @var callable */
	private $itemMapper;

	/** @var object[] */
	private $objectItems = [];


	/**
	 * @param string $label
	 * @param object[] $items
	 * @param callable $itemMapper transforms given item into array, format: itemKey (int|string) => itemLabel (string)
	 */
	public function __construct(string $label, array $items, callable $itemMapper)
	{
		$this->itemMapper = $itemMapper;

		$parentItems = [];

		foreach ($items as $item) {
			$itemKey = $this->getItemKey($item);
			$parentItems[$itemKey] = $this->getItemLabel($item);
			$this->objectItems[$itemKey] = $item;
		}

		parent::__construct($label, $parentItems);
	}


	/**
	 * @param object|object[]|null $value
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

				parent::setValue($this->getItemKey($value));
			} elseif (is_array($value)) {
				$objectIds = [];
				foreach ($value as $object) {
					$this->throwExceptionWhenNotInRange($object);

					$objectIds[] = $this->getItemKey($object);
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
	 * @return object[]
	 */
	public function getValue(): array
	{
		return array_map(function ($itemKey) {
			return $this->objectItems[$itemKey];
		}, parent::getValue());
	}


	/**
	 * @param object $item
	 *
	 * @return int|string
	 */
	private function getItemKey($item)
	{
		$itemPair = call_user_func($this->itemMapper, $item);

		if (!is_array($itemPair)) {
			throw new InvalidArgumentException(sprintf(
				'Item mapper should map given item to an <int|string, string> array, \'%s\' given!',
				is_object($itemPair) ? 'object' : gettype($itemPair)
			));
		}

		$itemKey = key($itemPair);

		if (!(is_int($itemKey) || is_string($itemKey))) {
			throw new InvalidArgumentException('Unable to get item key. Check item mapper function, please!');
		}

		return $itemKey;
	}


	/**
	 * @param object $object
	 *
	 * @return string
	 */
	private function getItemLabel($object): string
	{
		$pair = call_user_func($this->itemMapper, $object);

		return current($pair);
	}


	/**
	 * @param object $object
	 *
	 * @throws \AipNg\Forms\InvalidArgumentException
	 */
	private function throwExceptionWhenNotInRange($object): void
	{
		if (!in_array($object, $this->objectItems, true)) {
			throw new InvalidArgumentException('Given value out of allowed set.');
		}
	}

}
