<?php

declare(strict_types = 1);

namespace AipNg\Latte\Node;

use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

/**
 * {inputDescription ...}
 */
final class InputDescriptionNode extends StatementNode
{

	public ExpressionNode $name;


	public static function create(Tag $tag): self
	{
		$tag->outputMode = $tag::OutputKeepIndentation;
		$tag->expectArguments();

		$node = new self;
		$node->name = $tag->parser->parseUnquotedStringOrExpression();

		return $node;
	}


	public function print(PrintContext $context): string
	{
		return $context->format(
			'echo %escape(Nette\Bridges\FormsLatte\Runtime::item(%node, $this->global)->getOption(\'description\')) %line;',
			$this->name,
			$this->position,
		);
	}


	public function &getIterator(): \Generator
	{
		yield $this->name;
	}

}
