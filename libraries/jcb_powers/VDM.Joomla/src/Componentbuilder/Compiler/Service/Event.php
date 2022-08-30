<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaThree\Event as J3Event;


/**
 * Event Service Provider
 * 
 * @since 3.2.0
 */
class Event implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(J3Event::class, 'J3.Event')
			->share('J3.Event', [$this, 'getJ3Event'], true);
	}

	/**
	 * Get the Joomla 3 Event
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  EventInterface
	 * @since 3.2.0
	 */
	public function getJ3Event(Container $container): EventInterface
	{
		return new J3Event();
	}
}

