<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\IntegerList;

class IntegerListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ '1', 1.0, '0', 0.0, 'string', true, false, new \stdClass(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$integerList = new IntegerList();
		$integerList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ 1, 0, 10000, -324234 ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$integerList = new IntegerList();
		$integerList->add( $item );

		$this->assertNotEquals( -1, $integerList->indexOf( $item ) );
	}
}