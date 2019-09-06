<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms\TestForms;

use AipNg\Forms\BaseFormControl;
use Nette\Application\UI\Form;

final class CompleteForm extends BaseFormControl
{

	protected function createComponentForm(): Form
	{
		$form = new Form;
		$form->addText('field');

		return $form;
	}

}
