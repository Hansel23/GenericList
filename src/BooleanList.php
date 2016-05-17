<?php
namespace Hansel23\GenericList;

/**
 * Class BooleanList
 *
 * @package Hansel23\GenericList
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