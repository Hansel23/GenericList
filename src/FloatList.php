<?php
namespace Hansel23\GenericList;

/**
 * Class FloatList
 *
 * @package Hansel23\GenericList
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