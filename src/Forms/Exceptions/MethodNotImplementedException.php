<?php

declare(strict_types = 1);

namespace AipNg\Forms;

final class MethodNotImplementedException extends \RuntimeException
{

	public function __construct(string $methodName, ?int $code = 0, ?\Throwable $previous = null)
	{
		parent::__construct(\sprintf(
			"Method '%s' is not implemented!",
			$methodName
		), $code, $previous);
	}

}
