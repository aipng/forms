<?php

declare(strict_types = 1);

namespace AipNg\Forms;

final class PairListGenerator
{

	/**
	 * @param mixed[] $items
	 * @param callable $itemMapper
	 *
	 * @return string[]|array<string|int, string>
	 */
	public static function generate(iterable $items, callable $itemMapper): array
	{
		$list = [];

		foreach ($items as $item) {
			$itemPair = $itemMapper($item);

			if (!is_array($itemPair)) {
				throw new InvalidArgumentException('Given callable must return item pair (key => item name/title)!');
			}

			$list[key($itemPair)] = current($itemPair);
		}

		return $list;
	}

}
