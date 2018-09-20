<?php

/**
 * The home manager controller for crm.
 *
 */
class crmHomeManagerController extends modExtraManagerController
{
    /** @var crm $crm */
    public $crm;


    /**
     *
     */
    public function initialize()
    {
        $this->crm = $this->modx->getService('crm', 'crm', MODX_CORE_PATH . 'components/crm/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['crm:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('crm');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->crm->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/crm.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->crm->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        crm.config = ' . json_encode($this->crm->config) . ';
        crm.config.connector_url = "' . $this->crm->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "crm-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="crm-panel-home-div"></div>';

        return '';
    }
}