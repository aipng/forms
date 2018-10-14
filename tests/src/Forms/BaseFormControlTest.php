<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms;

use AipNg\Forms\BaseFormControl;
use AipNg\Forms\MethodNotImplementedException;
use Nette\Application\UI\Form;
use PHPUnit\Framework\TestCase;

final class BaseFormControlTest extends TestCase
{

	public function testThrowExceptionWhenSetDefaultsNotImplemented(): void
	{
		$form = new class() extends BaseFormControl
		{

		};

		$this->expectException(MethodNotImplementedException::class);

		$form->setDefaults([]);
	}


	public function testSetDefaults(): void
	{
		$value = 'test value';

		$form = new class() extends BaseFormControl
		{

			protected function createComponentForm(): Form
			{
				$form = new Form;
				$form->addText('field');

				return $form;
			}

		};

		$form->setDefaults([
			'field' => $value,
		]);

		/** @var \Nette\Application\UI\Form $componentForm */
		$componentForm = $form->getComponent('form');

		$this->assertSame($value, $componentForm->getValues()['field']);
	}

}
