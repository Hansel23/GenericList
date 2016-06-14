<?php
namespace Hansel23\GenericLists;

use ArrayAccess;
use Hansel23\GenericLists\Exceptions\InvalidIndexException;
use Hansel23\GenericLists\Exceptions\InvalidTypeException;
use Hansel23\GenericLists\Interfaces\FindsItems;
use Hansel23\GenericLists\Interfaces\ListsItems;
use Hansel23\GenericLists\Interfaces\SortsLists;

/**
 * Class AbstractList
 *
 * @package Hansel23\GenericLists
 */
abstract class AbstractList implements ListsItems, ArrayAccess
{
	/**
	 * @var array
	 */
	private $items = [ ];

	/**
	 * @var int
	 */
	private $currentPosition = 0;

	/**
	 * @var int
	 */
	private $itemCount = 0;

	/**
	 * @param $item
	 *
	 * @return bool
	 */
	abstract protected function isItemValid( $item );

	/**
	 * @param ListsItems $list
	 *
	 * @return bool
	 */
	abstract protected function isValidList( ListsItems $list );

	/**
	 * @param $item
	 *
	 * @return $this
	 */
	public function add( $item )
	{
		$this->validateItemType( $item );

		$this->items[ $this->itemCount++ ] = $item;

		return $this;
	}

	/**
	 * @param ListsItems $list
	 *
	 * @return $this
	 */
	public function addAll( ListsItems $list )
	{
		$this->validateListType( $list );

		foreach ( $list as $element )
		{
			$this->add( $element );
		}

		return $this;
	}

	/**
	 * @param ListsItems $list
	 *
	 * @return $this
	 */
	public function merge( ListsItems $list )
	{
		$this->validateListType( $list );

		foreach ( $list as $listIndex => $listItem )
		{
			$this->items[ $listIndex ] = $listItem;
		}

		$this->itemCount = count( $this->items );

		return $this;
	}

	/**
	 * @param $item
	 *
	 * @return $this
	 */
	public function remove( $item )
	{
		$this->validateItemType( $item );

		foreach ( $this->items as $currentIndex => $currentItem )
		{
			if ( $this->itemsEquals( $currentItem, $item ) )
			{
				$this->removeByIndex( $currentIndex );

				break;
			}
		}

		return $this;
	}

	/**
	 * @param ListsItems $list
	 *
	 * @return $this
	 */
	public function removeAll( ListsItems $list )
	{
		$this->validateListType( $list );

		foreach ( $list as $listIndex => $listItem )
		{
			$this->remove( $listItem );
		}

		return $this;
	}

	/**
	 * @param ListsItems $list
	 *
	 * @return $this
	 */
	public function removeAllExcept( ListsItems $list )
	{
		$this->validateListType( $list );

		foreach ( $this->items as $currentIndex => $currentItem )
		{
			if ( !$list->contains( $currentItem ) )
			{
				$this->removeByIndexWithoutReindexing( $currentIndex );
			}
		}

		$this->reIndex();

		return $this;
	}

	/**
	 * @param $index
	 *
	 * @return $this
	 * @throws InvalidIndexException
	 */
	public function removeByIndex( $index )
	{
		$this->removeByIndexWithoutReindexing( $index );

		$this->reIndex();

		return $this;
	}

	/**
	 * @param $item
	 *
	 * @return bool
	 */
	public function contains( $item )
	{
		$this->validateItemType( $item );

		foreach ( $this->items as $currentIndex => $currentItem )
		{
			if ( $this->itemsEquals( $currentItem, $item ) )
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $item
	 *
	 * @return int
	 */
	public function indexOf( $item )
	{
		$this->validateItemType( $item );

		foreach ( $this->items as $currentIndex => $currentItem )
		{
			if ( $this->itemsEquals( $currentItem, $item ) )
			{
				return $currentIndex;
			}
		}

		return -1;
	}

	/**
	 * @param $item
	 *
	 * @return int
	 */
	public function lastIndexOf( $item )
	{
		$this->validateItemType( $item );

		for ( $currentIndex = $this->count() - 1; $currentIndex >= 0; $currentIndex-- )
		{
			if ( $this->itemsEquals( $this->items[ $currentIndex ], $item ) )
			{
				return $currentIndex;
			}
		}

		return -1;
	}

	/**
	 * @param $index
	 * @param $item
	 *
	 * @throws InvalidIndexException
	 */
	public function set( $index, $item )
	{
		$this->validateIndex( $index );

		$this->items[ $index ] = $item;
	}

	/**
	 * @param $index
	 *
	 * @return mixed
	 * @throws InvalidIndexException
	 */
	public function get( $index )
	{
		$this->validateIndex( $index );

		return $this->items[ $index ];
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return $this->items;
	}

	/**
	 * @return void
	 */
	public function reverse()
	{
		$this->items = array_reverse( $this->items );
	}

	/**
	 * @return $this
	 */
	public function clear()
	{
		$this->items = [ ];

		$this->itemCount = 0;

		$this->currentPosition = 0;

		return $this;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return $this->itemCount;
	}

	/**
	 * @return bool|mixed
	 */
	public function current()
	{
		if ( isset($this->items[ $this->currentPosition ]) )
		{
			return $this->items[ $this->currentPosition ];
		}

		return false;
	}

	/**
	 * @return void
	 */
	public function next()
	{
		++$this->currentPosition;
	}

	/**
	 * @return mixed
	 */
	public function key()
	{
		return $this->currentPosition;
	}

	/**
	 * @return bool
	 */
	public function valid()
	{
		return isset($this->items[ $this->currentPosition ]);
	}

	/**
	 * @return void
	 */
	public function rewind()
	{
		$this->currentPosition = 0;
	}

	/**
	 * @param SortsLists $sorter
	 *
	 * @return $this
	 */
	public function sortBy( SortsLists $sorter )
	{
		usort( $this->items, [ $sorter, 'compare' ] );

		return $this;
	}

	/**
	 * @param FindsItems $filter
	 *
	 * @return null|$item
	 */
	public function find( FindsItems $filter )
	{
		foreach ( $this->items as $item )
		{
			if ( $filter->isValid( $item ) )
			{
				return $item;
			}
		}

		return null;
	}

	/**
	 * @param FindsItems $filter
	 *
	 * @return ListsItems
	 */
	public function findAll( FindsItems $filter )
	{
		$foundItems = clone $this;
		$foundItems->clear();

		foreach ( $this->items as $item )
		{
			if ( $filter->isValid( $item ) )
			{
				$foundItems->add( $item );
			}
		}

		return $foundItems;
	}

	/**
	 * @param FindsItems $filter
	 *
	 * @return null
	 */
	public function findLast( FindsItems $filter )
	{
		for ( $i = $this->itemCount - 1; $i >= 0; $i-- )
		{
			if ( $filter->isValid( $this->items[ $i ] ) )
			{
				return $this->items[ $i ];
			}
		}

		return null;
	}

	/**
	 * @param $item
	 *
	 * @return string
	 */
	protected function getType( $item )
	{
		return is_object( $item ) ? get_class( $item ) : gettype( $item );
	}

	/**
	 * @param $item
	 *
	 * @throws InvalidTypeException
	 */
	protected function validateItemType( $item )
	{
		if ( !$this->isItemValid( $item ) ) 
		{
			throw new InvalidTypeException(
				sprintf( 
					'Item of type %s expected, item of type %s given', 	$this->getItemType(), $this->getType( $item ) 
				)
			);
		}
	}

	/**
	 * @param $list
	 *
	 * @throws InvalidTypeException
	 */
	protected function validateListType( ListsItems $list )
	{
		if ( !$this->isValidList( $list ) )
		{
			throw new InvalidTypeException
			(
				sprintf
				(
					'List with items of type %s expected, list with items of type %s given',
					$this->getItemType(),
					$list->getItemType()
				)
			);
		}
	}

	/**
	 * @param $index
	 *
	 * @throws InvalidIndexException
	 */
	protected function validateIndex( $index )
	{
		if ( !is_int( $index ) || $index < 0 || $index >= $this->count() )
		{
			throw new InvalidIndexException( sprintf( 'Index %s does not exist in the list', $index ) );
		}
	}

	/**
	 * @param $item1
	 * @param $item2
	 *
	 * @return bool
	 *
	 * use md5( serialize ( ) ) instead of spl_object_hash, because hashing true equals false, which is not wanted
	 */
	protected function itemsEquals( $item1, $item2 )
	{
		return md5( serialize( $item1 ) ) == md5( serialize( $item2 ) );
	}

	/**
	 * @param mixed $offset
	 *
	 * @return bool
	 */
	public function offsetExists( $offset )
	{
		return isset($this->items[ $offset ]);
	}

	/**
	 * @param mixed $offset
	 *
	 * @return mixed
	 */
	public function offsetGet( $offset )
	{
		return $this->get( $offset );
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function offsetSet( $offset, $value )
	{
		$this->set( $offset, $value );

		return $this;
	}

	/**
	 * @param mixed $offset
	 */
	public function offsetUnset( $offset )
	{
		$this->removeByIndex( $offset );
	}

	private function reIndex()
	{
		$this->items = array_values( $this->items );
	}

	/**
	 * @param $index
	 *
	 * @return $this
	 * @throws InvalidIndexException
	 */
	private function removeByIndexWithoutReindexing( $index )
	{
		$this->validateIndex( $index );

		unset($this->items[ $index ]);

		$this->itemCount--;

		return $this;
	}
}