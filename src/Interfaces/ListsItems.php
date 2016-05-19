<?php
namespace Hansel23\GenericLists\Interfaces;

use Iterator, Countable;

/**
 * Interface ListsItems
 *
 * @package Hansel23\GenericLists\Interfaces
 */
interface ListsItems extends Iterator, Countable
{
	/**
	 * @param $item
	 */
	public function add( $item );
	/**
	 * @param ListsItems $list
	 */
	public function addAll( ListsItems $list );
	/**
	 * @param ListsItems $list
	 */
	public function merge( ListsItems $list );
	/**
	 * @param $item
	 */
	public function remove( $item );
	/**
	 * @param $index
	 */
	public function removeByIndex( $index );
	/**
	 * @param ListsItems $list
	 */
	public function removeAll( ListsItems $list );
	/**
	 * @param ListsItems $list
	 */
	public function removeAllExcept( ListsItems $list );
	/**
	 * @param $item
	 *
	 * @return bool
	 */
	public function contains( $item );
	/**
	 * @param $item
	 *
	 * @return int
	 */
	public function indexOf( $item );
	/**
	 * @param $item
	 *
	 * @return int
	 */
	public function lastIndexOf( $item );
	/**
	 * @param $index
	 * @param $item
	 */
	public function set( $index, $item );
	/**
	 * @param $index
	 *
	 * @return mixed
	 */
	public function get( $index );
	/**
	 * @return array
	 */
	public function toArray();
	/**
	 * @return void
	 */
	public function reverse();
	/**
	 * @return void
	 */
	public function clear();
	/**
	 * @param SortsLists $sorter
	 */
	public function sortBy( SortsLists $sorter );
	/**
	 * @param FindsItems $filter
	 *
	 * @return ListsItems
	 */
	public function find( FindsItems $filter );
	/**
	 * @param FindsItems $filter
	 *
	 * @return ListsItems
	 */
	public function findLast( FindsItems $filter );
	/**
	 * @param FindsItems $filter
	 *
	 * @return ListsItems
	 */
	public function findAll( FindsItems $filter );
	/**
	 * @return string
	 */
	public function getItemType();
}