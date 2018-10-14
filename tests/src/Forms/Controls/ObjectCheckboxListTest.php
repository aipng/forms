<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms\Controls;

use AipNg\Forms\Controls\ObjectCheckboxList;
use AipNg\Forms\InvalidArgumentException;
use Nette\Application\UI\Form;
use PHPUnit\Framework\TestCase;

final class ObjectCheckboxListTest extends TestCase
{

	/** @var \AipNg\Forms\Controls\ObjectCheckboxList */
	private $list;

	/** @var \AipNg\Tests\Forms\Controls\DummyClass */
	private $dummy1;

	/** @var \AipNg\Tests\Forms\Controls\DummyClass */
	private $dummy2;

	/** @var \AipNg\Tests\Forms\Controls\DummyClass */
	private $dummy3;


	protected function setUp(): void
	{
		parent::setUp();

		$this->dummy1 = new DummyClass(1, 'value 1');
		$this->dummy2 = new DummyClass(2, 'value 2');
		$this->dummy3 = new DummyClass(3, 'value 3');

		$this->list = new ObjectCheckboxList('myList', [
			$this->dummy1,
			$this->dummy2,
			$this->dummy3,
		], function (DummyClass $object) {
			return [
				$object->getId() => $object->getTitle(),
			];
		});
	}


	public function testRender(): void
	{
		$form = new Form;
		$form->addComponent($this->list, 'objectList');

		$html = '<label><input type="checkbox" name="objectList[]" value="1">value 1</label><br>';
		$html .= '<label><input type="checkbox" name="objectList[]" value="2">value 2</label><br>';
		$html .= '<label><input type="checkbox" name="objectList[]" value="3">value 3</label>';

		$this->assertSame($html, (string) $this->list->getControl());
	}


	public function testSetEmptyValue(): void
	{
		$this->list->setDefaultValue([]);

		$this->assertSame([], $this->list->getValue());

		$this->list->setDefaultValue(null);

		$this->assertSame([], $this->list->getValue());
	}


	public function testAcceptObjectAsDefaultValue(): void
	{
		$this->list->setDefaultValue($this->dummy2);

		$this->assertSame([$this->dummy2], $this->list->getValue());
	}


	public function testAcceptArrayOfObjectAsDefaultValue(): void
	{
		$this->list->setDefaultValue([$this->dummy1, $this->dummy3]);

		$this->assertSame([$this->dummy1, $this->dummy3], $this->list->getValue());
	}


	public function testSetDefaultValue(): void
	{
		$this->list->setDefaultValue([$this->dummy2, $this->dummy3]);

		$this->assertSame([$this->dummy2, $this->dummy3], $this->list->getValue());
	}


	public function testValue(): void
	{
		$this->list->setValue([$this->dummy2, $this->dummy3]);

		$this->assertSame([$this->dummy2, $this->dummy3], $this->list->getValue());
	}


	/**
	 * @param mixed $value
	 *
	 * @dataProvider getInvalidInputValues
	 */
	public function testThrowExceptionOnInvalidValues($value): void
	{
		$this->expectException(InvalidArgumentException::class);

		$this->list->setDefaultValue($value);
	}


	/**
	 * @return mixed[]
	 */
	public function getInvalidInputValues(): array
	{
		return [
			[2],
			[new DummyClass(1, 'different object')],
			[new DummyClass(4, 'dummy 4')],
			[
				[$this->dummy1, new DummyClass(1, 'different object')],
			],
		];
	}


	public function testThrowExceptionOnInvalidItemMapper(): void
	{
		$this->expectException(InvalidArgumentException::class);

		$this->list = new ObjectCheckboxList('myList', [
			$this->dummy1,
			$this->dummy2,
			$this->dummy3,
		], function (DummyClass $object) {
			return $object->getId();
		});
	}

}
