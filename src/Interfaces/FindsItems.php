<?php
namespace Hansel23\GenericLists\Interfaces;

/**
 * Interface FindsItems
 *
 * @package Hansel23\GenericLists\Interfaces
 */
interface FindsItems
{
	/**
	 * @param $object
	 *
	 * @return bool
	 */
	public function isValid( $object );
} 