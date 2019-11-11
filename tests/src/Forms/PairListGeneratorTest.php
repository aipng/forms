<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms;

use AipNg\Forms\PairListGenerator;
use AipNg\Tests\Forms\Fixtures\DummyClass;
use PHPUnit\Framework\TestCase;

final class PairListGeneratorTest extends TestCase
{

	public function testGenerateIndexedList(): void
	{
		$x = new DummyClass(100, 'title');

		$list = PairListGenerator::generate(
			[$x],
			function (DummyClass $class): array {
				return [
					$class->getId() => $class->getTitle(),
				];
			}
		);

		$this->assertCount(1, $list);
		$this->assertArrayHasKey($x->getId(), $list);
		$this->assertSame($x->getTitle(), $list[$x->getId()]);
	}

}
