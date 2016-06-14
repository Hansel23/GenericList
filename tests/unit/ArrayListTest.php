<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\ArrayList;
use Hansel23\GenericLists\Tests\Unit\Fixtures\Stringable;

class ArrayListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ 1, 1.0, true, false, new \stdClass(), new Stringable(), 'string' ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$stringList = new ArrayList();
		$stringList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ [ 'true' ],  [ [ '1' ] ], [ '1.0', '2.0', '3.0' ], [ ['false'], ['true'] ] ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$stringList = new ArrayList();
		$stringList->add( $item );

		$this->assertNotEquals( -1, $stringList->indexOf( $item ) );
	}

	public function ValidStringArrayProvider()
	{
		return [
			[ [ ['here', 'is', 'a', 'testarray' ], [ '1', 2.0, 3 ] ], [ ['I like some'], ['more tests'] ] ],
		];
	}

	/**
	 * @dataProvider ValidStringArrayProvider
	 */
	public function testCreatingStringListFromArray( array $subArrays )
	{
		$stringList = ArrayList::fromArray( $subArrays );

		$this->assertEquals( count( $subArrays ), $stringList->count() );
		$this->assertEquals( $subArrays, $stringList->toArray() );
	}

	public function InvalidArrayProvider()
	{
		return [
			[ [ 1, false ], [ 'string', 'one more string', true ], [ [ ] ] ],
		];
	}

	/**
	 * @dataProvider InvalidArrayProvider
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfCreatingFromInvalidArrayThrowsException( array $invalidArray )
	{
		ArrayList::fromArray( $invalidArray );
	}
}