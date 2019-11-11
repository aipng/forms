<?php

declare(strict_types = 1);

namespace AipNg\Tests\Forms\Fixtures;

final class DummyClass
{

	/** @var int */
	private $id;

	/** @var string */
	private $title;


	public function __construct(int $id, string $title)
	{
		$this->id = $id;
		$this->title = $title;
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getTitle(): string
	{
		return $this->title;
	}

}
