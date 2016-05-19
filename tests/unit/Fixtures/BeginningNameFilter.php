<?php
namespace Hansel23\GenericLists\Tests\Unit\Fixtures;

use Hansel23\GenericLists\Interfaces\FindsItems;

/**
 * Class BeginningNameFilter
 *
 * @package Hansel23\GenericLists\Tests\Unit\Fixtures
 */
class BeginningNameFilter implements FindsItems
{
	private $beginningOfTheName;

	public function __construct( $beginningOfTheName )
	{
		$this->beginningOfTheName = $beginningOfTheName;
	}

	public function isValid( $object )
	{
		return ( preg_match( '!^' . $this->beginningOfTheName . '!', $object->getName() ) );
	}
}
