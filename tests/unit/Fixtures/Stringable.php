<?php
namespace Hansel23\GenericLists\Tests\Unit\Fixtures;

/**
 * Class Stringable
 *
 * @package Hansel23\GenericLists\Tests\Unit\Fixtures
 */
class Stringable
{
	public function __toString()
	{
		return 'Not a real string';
	}
}