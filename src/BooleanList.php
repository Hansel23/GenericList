<?php
namespace Hansel23\GenericLists;

/**
 * Class BooleanList
 *
 * @package Hansel23\GenericLists
 */
final class BooleanList	extends GenericList
{
	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		parent::__construct( gettype( true ) );
	}
}