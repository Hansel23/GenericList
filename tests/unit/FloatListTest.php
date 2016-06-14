<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\FloatList;

class FloatListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ '1.0', 1, '0.0', 0, 'string', true, false, new \stdClass(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$floatList = new FloatList();
		$floatList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ 1.0, 0.0, 100.00, -324.234, 11.23 ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$floatList = new FloatList();
		$floatList->add( $item );

		$this->assertNotEquals( -1, $floatList->indexOf( $item ) );
	}

	public function ValidFloatArrayProvider()
	{
		return [
			[ [ 1.2, -1.0, 100.0, -999.999 ], [ 2.2, 1.0, -1.5 ] ],
		];
	}

	/**
	 * @dataProvider ValidFloatArrayProvider
	 */
	public function testCreatingNumericListFromArray( array $floatArray )
	{
		$stringList = FloatList::fromArray( $floatArray );

		$this->assertEquals( count( $floatArray ), $stringList->count() );
		$this->assertEquals( $floatArray, $stringList->toArray() );
	}

	public function InvalidArrayProvider()
	{
		return [
			[ [ 1.0, false ], [ true, 0.0 ], [ 1, 1.0 ], [ [ ] ] ],
		];
	}

	/**
	 * @dataProvider InvalidArrayProvider
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfCreatingFromInvalidArrayThrowsException( array $invalidArray )
	{
		FloatList::fromArray( $invalidArray );
	}
}