<?php
namespace Hansel23\GenericList;

/**
 * Class IntegerList
 *
 * @package Hansel23\GenericList
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