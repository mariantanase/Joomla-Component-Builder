<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Content;


/**
 * Compiler Service Provider
 * 
 * @since 3.2.0
 */
class Compiler implements ServiceProviderInterface
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
		$container->alias(Config::class, 'Config')
			->share('Config', [$this, 'getConfig'], true);

		$container->alias(Registry::class, 'Registry')
			->share('Registry', [$this, 'getRegistry'], true);

		$container->alias(Content::class, 'Content')
			->share('Content', [$this, 'getContent'], true);
	}

	/**
	 * Get the Compiler Configurations
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since 3.2.0
	 */
	public function getConfig(Container $container): Config
	{
		return new Config();
	}

	/**
	 * Get the Compiler Registry
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Registry
	 * @since 3.2.0
	 */
	public function getRegistry(Container $container): Registry
	{
		return new Registry();
	}

	/**
	 * Get the Compiler Content
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Content
	 * @since 3.2.0
	 */
	public function getContent(Container $container): Content
	{
		return new Content();
	}

}

