<?php

declare(strict_types = 1);

namespace AipNg\Latte\Macro;

use Latte\CompileException;
use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

final class InputDescriptionMacro extends MacroSet
{

	public static function register(Compiler $compiler): InputDescriptionMacro
	{
		$me = new static($compiler);
		$me->addMacro('inputDescription', [$me, 'macroInputDescription']);

		return $me;
	}


	public function macroInputDescription(MacroNode $node, PhpWriter $writer): string
	{
		if ($node->modifiers) {
			throw new CompileException('Modifiers are not allowed in ' . $node->getNotation());
		}

		$name = $node->tokenizer->fetchWord();
		$node->replaced = true;

		if (!$name) {
			return $writer->write('echo %escape($_input->getOption(\'description\'));');
		}

		if ($name[0] === '$') {
			return $writer->write(
				'$_input = is_object(%0.word) ? %0.word : end($this->global->formsStack)[%0.word]; echo %escape($_input->getOption(\'description\'));',
				$name
			);
		}

		return $writer->write('echo %escape(end($this->global->formsStack)[%0.word]->getOption(\'description\'));', $name);
	}

}
