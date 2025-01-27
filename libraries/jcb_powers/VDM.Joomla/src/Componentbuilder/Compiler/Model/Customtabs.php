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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Model Custom Tabs Class
 * 
 * @since 3.2.0
 */
class Customtabs
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Language
	 *
	 * @var    Language
	 * @since 3.2.0
	 **/
	protected Language $language;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null             $registry         The compiler registry object.
	 * @param Language|null             $language         The compiler Language object.
	 * @param Placeholder|null          $placeholder      The compiler placeholder object.
	 * @param Customcode|null           $customcode       The compiler customcode object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?Language $language = null, ?Placeholder $placeholder = null, ?Customcode $customcode = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->language = $language ?: Compiler::_('Language');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
	}

	/**
	 * Set custom tabs
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->customtabs = (isset($item->customtabs)
			&& JsonHelper::check($item->customtabs))
			? json_decode((string) $item->customtabs, true) : null;

		if (ArrayHelper::check($item->customtabs))
		{
			// get the name
			$name = $item->name_single_code;

			// setup custom tabs to global data sets
			$this->registry->set('builder.custom_tabs.' . $name,
				array_map(
					function ($tab) use (&$name) {

						// set the view name
						$tab['view'] = $name;

						// load the dynamic data
						$tab['html'] = $this->placeholder->update_(
							$this->customcode->update($tab['html'])
						);

						// set the tab name
						$tab['name'] = (isset($tab['name'])
							&& StringHelper::check(
								$tab['name']
							)) ? $tab['name'] : 'Tab';

						// set lang
						$tab['lang'] = $this->config->lang_prefix . '_'
							. StringHelper::safe(
								$tab['view'], 'U'
							) . '_' . StringHelper::safe(
								$tab['name'], 'U'
							);
						$this->language->set(
							'both', $tab['lang'], $tab['name']
						);

						// set code name
						$tab['code'] = StringHelper::safe(
							$tab['name']
						);

						// check if the permissions for the tab should be added
						$_tab = '';
						if (isset($tab['permission'])
							&& $tab['permission'] == 1)
						{
							$_tab = Indent::_(1);
						}

						// check if the php of the tab is set, if not load it now
						if (strpos((string) $tab['html'], 'bootstrap.addTab') === false
							&& strpos((string) $tab['html'], 'bootstrap.endTab')
							=== false)
						{
							// add the tab
							$tmp = PHP_EOL . $_tab . Indent::_(1)
								. "<?php echo JHtml::_('bootstrap.addTab', '"
								. $tab['view'] . "Tab', '" . $tab['code']
								. "', JT" . "ext::_('" . $tab['lang']
								. "', true)); ?>";
							$tmp .= PHP_EOL . $_tab . Indent::_(2)
								. '<div class="row-fluid form-horizontal-desktop">';
							$tmp .= PHP_EOL . $_tab . Indent::_(3)
								. '<div class="span12">';
							$tmp .= PHP_EOL . $_tab . Indent::_(4) . implode(
									PHP_EOL . $_tab . Indent::_(4),
									(array) explode(PHP_EOL, trim((string) $tab['html']))
								);
							$tmp .= PHP_EOL . $_tab . Indent::_(3) . '</div>';
							$tmp .= PHP_EOL . $_tab . Indent::_(2) . '</div>';
							$tmp .= PHP_EOL . $_tab . Indent::_(1)
								. "<?php echo JHtml::_('bootstrap.endTab'); ?>";

							// update html
							$tab['html'] = $tmp;
						}
						else
						{
							$tab['html'] = PHP_EOL . $_tab . Indent::_(1)
								. implode(
									PHP_EOL . $_tab . Indent::_(1),
									(array) explode(PHP_EOL, trim((string) $tab['html']))
								);
						}

						// add the permissions if needed
						if (isset($tab['permission'])
							&& $tab['permission'] == 1)
						{
							$tmp = PHP_EOL . Indent::_(1)
								. "<?php if (\$this->canDo->get('"
								. $tab['view'] . "." . $tab['code']
								. ".viewtab')) : ?>";
							$tmp .= $tab['html'];
							$tmp .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
							// update html
							$tab['html'] = $tmp;
							// set lang for permissions
							$tab['lang_permission']      = $tab['lang']
								. '_TAB_PERMISSION';
							$tab['lang_permission_desc'] = $tab['lang']
								. '_TAB_PERMISSION_DESC';
							$tab['lang_permission_title']
							                             = $this->placeholder->get('Views') . ' View '
								. $tab['name'] . ' Tab';
							$this->language->set(
								'both', $tab['lang_permission'],
								$tab['lang_permission_title']
							);
							$this->language->set(
								'both', $tab['lang_permission_desc'],
								'Allow the users in this group to view '
								. $tab['name'] . ' Tab of '
								. $this->placeholder->get('views')
							);
							// set the sort key
							$tab['sortKey']
								= StringHelper::safe(
								$tab['lang_permission_title']
							);
						}

						// return tab
						return $tab;

					}, array_values($item->customtabs)
				)
			);
		}

		unset($item->customtabs);
	}

}

