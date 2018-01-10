<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms\Controls;

require __DIR__ . '/../../bootstrap.php';

use AipNg\Forms\Controls\ObjectSelectBox;
use AipNg\Forms\InvalidArgumentException;
use Nette\Forms\Form;
use Tester\Assert;
use Tester\TestCase;

final class ObjectSelectBoxTest extends TestCase
{

	/** @var \AipNg\Forms\Controls\ObjectSelectBox */
	private $selectBox;

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

		$this->selectBox = new ObjectSelectBox('myList', [
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
		$form->addComponent($this->selectBox, 'objectList');

		$html = '<select name="objectList" id="frm-objectList">';
		$html .= '<option value="1">value 1</option>';
		$html .= '<option value="2">value 2</option>';
		$html .= '<option value="3">value 3</option>';
		$html .= '</select>';

		Assert::same($html, (string) $this->selectBox->getControl());
	}


	public function testValue(): void
	{
		$this->selectBox->setValue($this->dummy2);

		Assert::same($this->dummy2, $this->selectBox->getValue());
	}


	public function testSetEmptyValue(): void
	{
		$this->selectBox->setDefaultValue(null);

		Assert::same(null, $this->selectBox->getValue());
	}


	public function testAcceptObjectAsDefaultValue(): void
	{
		$this->selectBox->setDefaultValue($this->dummy2);

		Assert::same($this->dummy2, $this->selectBox->getValue());
	}


	/**
	 * @param mixed $value
	 *
	 * @dataProvider getInvalidInputValues
	 */
	public function testThrowExceptionOnInvalidValues($value): void
	{
		Assert::exception(function () use ($value): void {
			$this->selectBox->setDefaultValue($value);
		}, InvalidArgumentException::class);
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
		];
	}

}


(new ObjectSelectBoxTest)->run();
