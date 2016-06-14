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
			[ 1, 0, 10000, -324234, PHP_INT_MAX ],
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
	
	public function ValidIntegerArrayProvider()
	{
		return [
			[ [ 1, -1, 100, 999999 ], [ PHP_INT_MAX, 1, -1 ] ],
		];
	}

	/**
	 * @dataProvider ValidIntegerArrayProvider
	 */
	public function testCreatingNumericListFromArray( array $integerArray )
	{
		$stringList = IntegerList::fromArray( $integerArray );

		$this->assertEquals( count( $integerArray ), $stringList->count() );
		$this->assertEquals( $integerArray, $stringList->toArray() );
	}

	public function InvalidArrayProvider()
	{
		return [
			[ [ 1, false ], [ true, 0 ], [ 1, 1.0 ], [ [ ] ] ],
		];
	}

	/**
	 * @dataProvider InvalidArrayProvider
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfCreatingFromInvalidArrayThrowsException( array $invalidArray )
	{
		IntegerList::fromArray( $invalidArray );
	}
}