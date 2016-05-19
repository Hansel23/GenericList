<?php
namespace Hansel23\GenericLists;

/**
 * Class IntegerList
 *
 * @package Hansel23\GenericLists
 */
final class IntegerList	extends GenericList
{
	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		parent::__construct( gettype( 2 ) );
	}
}