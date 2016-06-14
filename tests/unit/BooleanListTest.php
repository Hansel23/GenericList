<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\BooleanList;

class BooleanListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ 1, 1.0, 0, 0.0, 'true', 'false', new \stdClass(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$boolList = new BooleanList();
		$boolList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ true, false ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$boolList = new BooleanList();
		$boolList->add( $item );

		$this->assertNotEquals( -1, $boolList->indexOf( $item ) );
	}

	public function ValidBoolArrayProvider()
	{
		return [
			[ [ false, true, false, false ], [  true, true, false ] ],
		];
	}

	/**
	 * @dataProvider ValidBoolArrayProvider
	 */
	public function testCreatingNumericListFromArray( array $boolArray )
	{
		$stringList = BooleanList::fromArray( $boolArray );

		$this->assertEquals( count( $boolArray ), $stringList->count() );
		$this->assertEquals( $boolArray, $stringList->toArray() );
	}

	public function InvalidArrayProvider()
	{
		return [
			[ [ 1, false ], [ true, 0 ], [ [ ] ] ],
		];
	}

	/**
	 * @dataProvider InvalidArrayProvider
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfCreatingFromInvalidArrayThrowsException( array $invalidArray )
	{
		BooleanList::fromArray( $invalidArray );
	}
}