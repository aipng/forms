<?php

declare(strict_types = 1);

namespace AipNg\Forms;

use Nette\Application\UI\Control;

abstract class BaseFormControl extends Control
{

	/**
	 * @param mixed[] $defaults
	 *
	 * @throws \AipNg\Forms\MethodNotImplementedException
	 */
	public function setDefaults(array $defaults): void
	{
		if (!method_exists($this, 'createComponentForm')) {
			throw new MethodNotImplementedException(__METHOD__);
		}

		/** @var \Nette\Application\UI\Form $componentForm */
		$componentForm = $this->getComponent('form');

		$componentForm->setDefaults($defaults);
	}


	public function render(): void
	{
		$this->template->setFile($this->getTemplateFile());
		$this->template->render();
	}


	protected function getTemplateFile(): string
	{
		$reflection = new \ReflectionClass($this);

		return sprintf(
			'%s%s%s.latte',
			dirname($reflection->getFileName()),
			DIRECTORY_SEPARATOR,
			$reflection->getShortName()
		);
	}

}
