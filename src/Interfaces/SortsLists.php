<?php
namespace Hansel23\GenericLists\Interfaces;

/**
 * Interface SortsLists
 *
 * @package Hansel23\GenericLists\Interfaces
 */
interface SortsLists
{
	/**
	 * @param $object1
	 * @param $object2
	 *
	 * @return int ( -1, 0, 1 )
	 */
	public function compare( $object1, $object2 );
} 