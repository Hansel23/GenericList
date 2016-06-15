<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\StringList;
use Hansel23\GenericLists\Tests\Unit\Fixtures\Stringable;
use Hansel23\GenericLists\Tests\Unit\Fixtures\TestType;
use Hansel23\GenericLists\Tests\Unit\Fixtures\TestableList;

class AbstractObjectListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ 1, 1.0, true, false, new \stdClass(), new Stringable(), [ ], 'string' ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$stringList = new TestableList();
		$stringList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ new TestType( 'true' ), new TestType( 1 ), new TestType( 1.0 ), new TestType( false ) ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$stringList = new TestableList();
		$stringList->add( $item );

		$this->assertNotEquals( -1, $stringList->indexOf( $item ) );
	}

	public function ValidStringArrayProvider()
	{
		return [
			[ [ new TestType( 'true' ), new TestType( 1 ) ], [ new TestType( 1.0 ), new TestType( false ) ] ],
		];
	}

	/**
	 * @dataProvider ValidStringArrayProvider
	 */
	public function testCreatingStringListFromArray( array $stringArray )
	{
		$stringList = TestableList::fromArray( $stringArray );

		$this->assertEquals( count( $stringArray ), $stringList->count() );
		$this->assertEquals( $stringArray, $stringList->toArray() );
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
		TestableList::fromArray( $invalidArray );
	}
}