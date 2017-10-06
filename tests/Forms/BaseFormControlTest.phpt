<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms;

require __DIR__ . '/../bootstrap.php';

use AipNg\Forms\BaseFormControl;
use AipNg\Forms\MethodNotImplementedException;
use Nette\Application\UI\Form;
use Tester\Assert;
use Tester\TestCase;

class BaseFormControlTest extends TestCase
{

	public function testThrowExceptionWhenSetDefaultsNotImplemented(): void
	{
		$form = new class() extends BaseFormControl
		{

		};

		Assert::exception(function () use ($form): void {
			$form->setDefaults([]);
		}, MethodNotImplementedException::class);
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

		Assert::same($value, $componentForm->getValues()['field']);
	}

}


(new BaseFormControlTest)->run();
