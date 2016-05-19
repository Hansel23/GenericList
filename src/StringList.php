<?php
namespace Hansel23\GenericLists;

/**
 * Class StringList
 *
 * @package Hansel23\GenericLists
 */
final class StringList extends GenericList
{
	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		parent::__construct( gettype('') );
	}

	/**
	 * @param array $strings
	 *
	 * @return static
	 */
	public static function fromArray( array $strings )
	{
		$list = new static();
		
		foreach( $strings as $oneString )
		{
			$list->add( $oneString );
		}
		
		return $list;
	}
}