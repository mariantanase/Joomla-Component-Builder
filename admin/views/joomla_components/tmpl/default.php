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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', '.multipleJoomlacomponentsfiltercompanyname', null, array('placeholder_text_multiple' => '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_COMPANY_NAME') . ' -'));
JHtml::_('formbehavior.chosen', '.multipleJoomlacomponentsfilterauthor', null, array('placeholder_text_multiple' => '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_AUTHOR') . ' -'));
JHtml::_('formbehavior.chosen', '.multipleAccessLevels', null, array('placeholder_text_multiple' => '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_ACCESS') . ' -'));
JHtml::_('formbehavior.chosen', 'select');
if ($this->saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_componentbuilder&task=joomla_components.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'joomla_componentList', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=joomla_components'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif; ?>
<?php
	// Add the trash helper layout
	echo JLayoutHelper::render('trashhelper', $this);
	// Add the searchtools
	echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
?>
<?php if (empty($this->items)): ?>
	<div class="alert alert-no-items">
		<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
<?php else : ?>
	<table class="table table-striped" id="joomla_componentList">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<?php // Load the batch processing form. ?>
	<?php if ($this->canCreate && $this->canEdit) : ?>
		<?php echo JHtml::_(
			'bootstrap.renderModal',
			'collapseModal',
			array(
				'title' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS_BATCH_OPTIONS'),
				'footer' => $this->loadTemplate('batch_footer')
			),
			$this->loadTemplate('batch_body')
		); ?>
	<?php endif; ?>
	<input type="hidden" name="boxchecked" value="0" />
	</div>
<?php endif; ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<script type="text/javascript">
// joomla_components footer script

// waiting spinner
var outerDiv = jQuery('body');
jQuery('<div id="loading"></div>')
	.css("background", "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat")
	.css("top", outerDiv.position().top - jQuery(window).scrollTop())
	.css("left", outerDiv.position().left - jQuery(window).scrollLeft())
	.css("width", outerDiv.width())
	.css("height", outerDiv.height())
	.css("position", "fixed")
	.css("opacity", "0.80")
	.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
	.css("filter", "alpha(opacity = 80)")
	.css("display", "none")
	.appendTo(outerDiv);
// when the clone button is clicked
jQuery('#toolbar').on('click',"button.button-save-copy", function(e){
	if (document.adminForm.boxchecked.value != 0){
		jQuery('#loading').show();
	}
});
// when the backup button is clicked
jQuery('#toolbar').on('click',"button.button-archive", function(e){
	if (document.adminForm.boxchecked.value != 0){
		jQuery('#loading').show();
	}
});
// when the export button is clicked
jQuery('#toolbar').on('click',"button.button-download", function(e){
	if (document.adminForm.boxchecked.value != 0){
		jQuery('#loading').show();
	}
});
// when the expand button is clicked
jQuery('#toolbar').on('click',"button.button-expand-2", function(e){
	jQuery('#loading').show();
});
</script>
