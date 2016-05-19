<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\GenericList;
use Hansel23\GenericLists\Tests\Unit\Fixtures\ByNameSorter;
use Hansel23\GenericLists\Tests\Unit\Fixtures\BeginningNameFilter;
use Hansel23\GenericLists\Tests\Unit\Fixtures\Testable;
use Hansel23\GenericLists\Tests\Unit\Fixtures\TestType;

/**
 * Class BaseListTest
 *
 * @package Tests
 */
class GenericListTest extends \Codeception\TestCase\Test
{
	public function testIfValidTypesCouldBeAdded()
	{
		$list = new GenericList( \stdClass::class );

		$count = 10;

		for( $i = 1; $i <= 10; $i++ )
		{
			$list->add( new \stdClass() );
		}

		$this->assertEquals( $count, $list->count() );
	}

	public function invalidTypes()
	{
		return [
			[
				false, null, true, 1, 'test', new TestType( 'test' )
			]
		];
	}

	/**
	 * @dataProvider invalidTypes
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfAddingInvalidTypesThrowsException( $invalidType )
	{
		$list = new GenericList( \stdClass::class );

		$list->add( $invalidType );
	}

	/**
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfAddingInvalidListThrowsException()
	{
		$list = new GenericList( \stdClass::class );

		$otherList = new GenericList( TestType::class );

		$list->addAll( $otherList );
	}

	public function validItems()
	{
		return [
			[
				Testable::class,
				[ new TestType( 1 ), new TestType( false ), new TestType( 'test' ) ],
				[ new TestType( 222 ), new TestType( true ), new TestType( 'abc' ) ]
			]
		];
	}

	/**
	 * @dataProvider validItems
	 */
	public function testIfListContainsItem( $itemType, array $validItems)
	{
		$list = new GenericList( $itemType );

		foreach( $validItems as $item )
		{
			$list->add( $item );
		}

		foreach( $validItems as $item )
		{
			$this->assertTrue( $list->contains( $item ) );
		}
	}

	/**
	 * @dataProvider validItems
	 */
	public function testIfListDoesNotContainItem( $itemType, array $validItems, array $otherValidItems )
	{
		$list = new GenericList( $itemType );

		foreach( $validItems as $item )
		{
			$list->add( $item );
		}

		$this->assertFalse( $list->contains( $otherValidItems[0] ) );
	}

	/**
	 * @dataProvider validItems
	 */
	public function testIfMergingOverridesOriginalList( $itemType, array $validItems, array $otherValidItems )
	{
		$list1 = new GenericList( $itemType );

		foreach( $validItems as $item )
		{
			$list1->add( $item );
		}

		$list2 = new GenericList( $itemType );
		foreach( $otherValidItems as $item )
		{
			$list2->add( $item );
		}

		$list1->merge( $list2 );
		$list2->rewind();

		$this->assertEquals( $list2, $list1 );
	}

	/**
	 * @dataProvider validItems
	 */
	public function testAddingAllAndRemovingAll( $itemType, array $validItems, array $otherValidItems )
	{
		$list1 = new GenericList( $itemType );

		foreach( $validItems as $item )
		{
			$list1->add( $item );
		}

		$originalList = clone $list1;

		$list2 = new GenericList( $itemType );
		foreach( $otherValidItems as $item )
		{
			$list2->add( $item );
		}

		$list1->addAll( $list2 );

		$this->assertEquals( count( $validItems ) + count( $otherValidItems ), $list1->count() );

		$list1->removeAll( $list2 );

		$this->assertEquals( $originalList, $list1 );
	}

	/**
	 * @dataProvider validItems
	 */
	public function testRemovingAllExcept( $itemType, array $validItems, array $otherValidItems )
	{
		$list1 = new GenericList( $itemType );

		foreach( $validItems as $item )
		{
			$list1->add( $item );
		}

		$list2 = new GenericList( $itemType );
		foreach( $otherValidItems as $item )
		{
			$list2->add( $item );
		}

		$list1->addAll( $list2 );

		$list1->removeAllExcept( $list2 );
		$list2->rewind();

		$this->assertEquals( $list2, $list1 );
	}
	
	public function testObjects()
	{
		return [
			[
				[	new TestType( 'test1' ), new TestType( 'test2' ),	new TestType( 'test3' ),
					new TestType( 'test1' ), new TestType( 'test2' ),	new TestType( 'test3' ) ]
			]
		];
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testIndexOfExistingItem( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$lookForIndex = rand( 0, 2 );

		$this->assertEquals( $lookForIndex, $list->indexOf( $testItems[ $lookForIndex ] ) );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testLastIndexOfExistingItem( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$lookForIndex = rand( 0, 2 );

		$this->assertEquals( $lookForIndex + 3, $list->lastIndexOf( $testItems[ $lookForIndex ] ) );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testIndexOfNonExistingItem( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$this->assertEquals( -1, $list->indexOf( new TestType( 'non existing item' ) ) );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testLastIndexOfNonExistingItem( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$this->assertEquals( -1, $list->lastIndexOf( new TestType( 'non existing item' ) ) );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testSettingAndGettingItemByIndex( array $testItems )
	{
		$updateItem = new TestType( 'test 123456789 test' );

		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}
		$lookForIndex = rand( 0, count( $testItems ) - 1 );

		$list->set( $lookForIndex, $updateItem );

		$this->assertEquals( $updateItem, $list->get( $lookForIndex ) );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testIfToArrayReturnsCorrectArray( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$this->assertEquals( $testItems, $list->toArray() );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testIfListHasNoItemAfterClearingIt( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$list->clear();

		$this->assertEquals( 0, $list->count() );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testIfCurrentReturnsFalseAfterTheEndOfTheList( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		for( $i = 0; $i < count( $testItems ) - 1; $i++ )
		{
			$list->next();
		}

		//Current now has last value, so we have do call next one more time
		$list->next();

		$this->assertFalse( $list->current() );
	}

	/**
	 * @dataProvider testObjects
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidIndexException
	 */
	public function testIfSettingInvalidIndexThrowsException( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$list->set( count( $testItems ) + 1, new TestType( 'invalid for invalid index' ) );
	}

	/**
	 * @dataProvider testObjects
	 */
	public function testIfArrayAccessMethodsAreWorkingProperly( array $testItems )
	{
		$list = new GenericList( TestType::class );
		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$updateItem = new TestType( 'test 123456789 test' );

		$list[2] = $updateItem;
		$this->assertEquals( $updateItem, $list[2] );

		unset($list[3]);
		$this->assertEquals( $testItems[4], $list->get( 3 ) );

		$this->assertTrue( isset( $list[1] ) );
	}

	public function testItemsToSort()
	{
		return [
			[
				[ new TestType( 'Anton' ), new TestType( 'Bar' )	, new TestType( 'B�r' ), new TestType( 'Camel' ),
					new TestType( 'camel' ), new TestType( '123' ), new TestType( '$Toll' ), new TestType( '!Abendessen' ),
					new TestType( 'Anton' ) ]
			]
		];
	}

	/**
	 * @dataProvider testItemsToSort
	 */
	public function testSortingListByNameAsc( array $testItemsToSort )
	{
		shuffle( $testItemsToSort );

		$sorter = new ByNameSorter( SORT_ASC );
		$list = new GenericList( TestType::class );

		foreach( $testItemsToSort as $testItem )
		{
			$list->add( $testItem );
		}

		$list->sortBy( $sorter );

		sort( $testItemsToSort );

		$this->assertEquals( $testItemsToSort, $list->toArray() );
	}

	/**
	 * @dataProvider testItemsToSort
	 */
	public function testSortingListByNameDesc( array $testItemsToSort )
	{
		shuffle( $testItemsToSort );

		$sorter = new ByNameSorter( SORT_DESC );
		$list = new GenericList( TestType::class );

		foreach( $testItemsToSort as $testItem )
		{
			$list->add( $testItem );
		}

		$list->sortBy( $sorter );

		rsort ( $testItemsToSort );

		$this->assertEquals( $testItemsToSort, $list->toArray() );
	}

	/**
	 * @dataProvider testItemsToSort
	 */
	public function testReversingList( array $testItems )
	{
		$list = new GenericList( TestType::class );

		foreach( $testItems as $testItem )
		{
			$list->add( $testItem );
		}

		$list->reverse();

		$testItems = array_reverse( $testItems );

		$this->assertEquals( $testItems, $list->toArray() );
	}

	public function filterableObjects()
	{
		return [
			[
				TestType::class,
				'Musik',
				[
					[ new TestType( 'Musikgenuss' ), true ],
					[ new TestType( 'Höre Musik gern' ), false ],
					[ new TestType( 'Höre Musik nicht gern' ), false ],
					[ new TestType( 'Musik höre ich gern' ), true ],
					[ new TestType( 'DAS ist Musik' ), false ],
					[ new TestType( 'Musikhörer' ), true ]
				]
			]
		];
	}

	/**
	 * @dataProvider filterableObjects
	 */
	public function testFindAllByBeginningName( $typeName, $beginningOfTheNameToFilter, array $testTypes )
	{
		$validTypes = [];

		$list = new GenericList( $typeName );
		foreach( $testTypes as $testType )
		{
			$list->add( $testType[0] );

			if( $testType[1] )
			{
				$validTypes[] = $testType[0];
			}
		}

		$foundItems = $list->findAll( new BeginningNameFilter( $beginningOfTheNameToFilter ) );

		$this->assertEquals( $validTypes, $foundItems->toArray() );
	}

	/**
	 * @dataProvider filterableObjects
	 */
	public function testFindByBeginningName( $typeName, $beginningOfTheNameToFilter, array $testTypes )
	{
		$validTypes = [];

		$list = new GenericList( $typeName );
		foreach( $testTypes as $testType )
		{
			$list->add( $testType[0] );

			if( $testType[1] )
			{
				$validTypes[] = $testType[0];
			}
		}

		$foundItem = $list->find( new BeginningNameFilter( $beginningOfTheNameToFilter ) );

		$this->assertEquals( $validTypes[0], $foundItem );
	}

	/**
	 * @dataProvider filterableObjects
	 */
	public function testFindLastByBeginningName( $typeName, $beginningOfTheNameToFilter, array $testTypes )
	{
		$validTypes = [];

		$list = new GenericList( $typeName );
		foreach( $testTypes as $testType )
		{
			$list->add( $testType[0] );

			if( $testType[1] )
			{
				$validTypes[] = $testType[0];
			}
		}

		$foundItem = $list->findLast( new BeginningNameFilter( $beginningOfTheNameToFilter ) );

		$this->assertEquals( $validTypes[ count( $validTypes ) - 1 ], $foundItem );
	}

	/**
	 * @dataProvider filterableObjects
	 */
	public function testIfFindWithoutAnyMatchReturnsNull( $typeName, $beginningOfTheNameToFilter, array $testTypes )
	{
		$list = new GenericList( $typeName );
		foreach( $testTypes as $testType )
		{
			$list->add( $testType[0] );
		}

		$this->assertNull( $list->find( new BeginningNameFilter( str_rot13( $beginningOfTheNameToFilter ) ) ) );
	}

	/**
	 * @dataProvider filterableObjects
	 */
	public function testIfFindLastWithoutAnyMatchReturnsNull( $typeName, $beginningOfTheNameToFilter, array $testTypes )
	{
		$list = new GenericList( $typeName );
		foreach( $testTypes as $testType )
		{
			$list->add( $testType[0] );
		}

		$this->assertNull( $list->findLast( new BeginningNameFilter( str_rot13( $beginningOfTheNameToFilter ) ) ) );
	}
}