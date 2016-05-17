<?php
namespace Hansel23\GenericList\Interfaces;

/**
 * Interface FindsItems
 *
 * @package Hansel23\GenericList\Interfaces
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