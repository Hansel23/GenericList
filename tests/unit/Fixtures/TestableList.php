<?php
namespace Hansel23\GenericLists\Tests\Unit\Fixtures;

use Hansel23\GenericLists\AbstractObjectList;

/**
 * Class TestableList
 *
 * @package Hansel23\GenericLists\Tests\Unit\Fixtures
 */
final class TestableList extends AbstractObjectList
{
	public function getItemType()
	{
		return Testable::class;
	}
}