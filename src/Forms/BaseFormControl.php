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


	public function beforeRender(): void
	{
	}


	public function render(): void
	{
		$this->getTemplate()->setFile($this->getTemplateFile());
		$this->beforeRender();
		$this->getTemplate()->render();
	}


	protected function getTemplateFile(): string
	{
		$reflection = new \ReflectionClass($this);
		$formFileName = $reflection->getFileName();

		if (!$formFileName) {
			throw new InvalidArgumentException('Unable to get form file name!');
		}

		return sprintf(
			'%s%s%s.latte',
			dirname($formFileName),
			DIRECTORY_SEPARATOR,
			$reflection->getShortName()
		);
	}

}
