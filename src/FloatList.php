<?php
namespace Hansel23\GenericLists;

/**
 * Class FloatList
 *
 * @package Hansel23\GenericLists
 */
final class FloatList extends GenericList
{
	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		parent::__construct( gettype( 1.0 ) );
	}
}