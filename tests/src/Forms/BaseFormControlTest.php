<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms;

use AipNg\Forms\MethodNotImplementedException;
use AipNg\Tests\Forms\TestForms\CompleteForm;
use AipNg\Tests\Forms\TestForms\IncompleteForm;
use Nette\Application\UI\Presenter;
use PHPUnit\Framework\TestCase;

final class BaseFormControlTest extends TestCase
{

	public function testThrowExceptionWhenSetDefaultsNotImplemented(): void
	{
		$form = new IncompleteForm;

		$this->expectException(MethodNotImplementedException::class);

		$form->setDefaults([]);
	}


	public function testSetDefaults(): void
	{
		$value = 'test value';

		$form = new CompleteForm;

		$presenter = new class extends Presenter {

		};
		$presenter->addComponent($form, 'frm');

		$form->setDefaults([
			'field' => $value,
		]);

		$subForm = $form->getComponent('form');

		/** @var mixed[] $values */
		$values = $subForm->getValues();

		$this->assertSame($value, $values['field']);
	}

}
