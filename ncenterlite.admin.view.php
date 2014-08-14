<?php
class ncenterliteAdminView extends ncenterlite
{
	function init()
	{
		$this->setTemplatePath($this->module_path.'tpl');
		$this->setTemplateFile(str_replace('dispNcenterliteAdmin', '', $this->act));
	}

	function dispNcenterliteAdminConfig()
	{
		$oModuleModel = &getModel('module');
		$oNcenterliteModel = &getModel('ncenterlite');
		$oLayoutModel = getModel('layout');

		$config = $oNcenterliteModel->getConfig();
		Context::set('config', $config);

		$layout_list = $oLayoutModel->getLayoutList();
		Context::set('layout_list', $layout_list);

		$mobile_layout_list = $oLayoutModel->getLayoutList(0, 'M');
		Context::set('mlayout_list', $mobile_layout_list);

		$skin_list = $oModuleModel->getSkins($this->module_path);
		Context::set('skin_list', $skin_list);

		$mskin_list = $oModuleModel->getSkins($this->module_path, "m.skins");
		Context::set('mskin_list', $mskin_list);

		if(!$skin_list[$config->skin]) $config->skin = 'default';
		Context::set('colorset_list', $skin_list[$config->skin]->colorset);

		if(!$mskin_list[$config->mskin]) $config->mskin = 'default';
		Context::set('mcolorset_list', $mskin_list[$config->mskin]->colorset);

		$security = new Security();
		$security->encodeHTML('config..');
		$security->encodeHTML('skin_list..title');
		$security->encodeHTML('colorset_list..name','colorset_list..title');

		$mid_list = $oModuleModel->getMidList(null, array('module_srl', 'mid', 'browser_title', 'module'));

		Context::set('mid_list', $mid_list);

	}

	function dispNcenterliteAdminList()
	{
		$oMemberModel = getModel('member');

		$args = new stdClass;
		$args->page = Context::get('page');
		$args->list_count = '20';
		$args->page_count = '10';
		$output = executeQuery('ncenterlite.getAdminNotifyList', $args);

		Context::set('total_count', $output->page_navigation->total_count);
		Context::set('total_page', $output->page_navigation->total_page);
		Context::set('page', $output->page);
		Context::set('ncenterlite_list', $output->data);
		Context::set('page_navigation', $output->page_navigation);

		$this->setTemplateFile('ncenter_list');
	}

}
