<?php
/**
 * The home manager controller for Sendex.
 *
 */
class crmHomeManagerController extends crmMainController {
	/* @var crm $crm */
	public $crm;
	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}
	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('crm');
	}
	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
        $this->addCss($this->crm->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addCss($this->crm->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/misc/default.grid.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/misc/default.window.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/misc/crm.utils.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/misc/crm.combo.js');

        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/contacts/types/grid.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/contacts/types/window.js');
        //$this->addJavascript($this->crm->config['jsUrl'] . 'mgr/contacts/types/members.js');


	    $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/contacts/contacts/contacts.items.grid.js');
		$this->addJavascript($this->crm->config['jsUrl'] . 'mgr/contacts/contacts/home.panel.js');
		$this->addJavascript($this->crm->config['jsUrl'] . 'mgr/sections/home.js');		
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {			
			MODx.load({ xtype: "crm-page-home"});
		});
		</script>');
	}
	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->crm->config['templatesPath'] . 'home.tpl';
	}
}