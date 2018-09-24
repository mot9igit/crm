<?php
/**
 * Class crmMainController
 */
abstract class crmMainController extends modExtraManagerController {
	/** @var crm $crm */
	public $crm;
	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('crm_core_path', null, $this->modx->getOption('core_path') . 'components/crm/');
		require_once $corePath . 'model/crm.class.php';
		$this->crm = new crm($this->modx);
		$this->addCss($this->crm->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->crm->config['jsUrl'] . 'mgr/crm.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			crm.config = ' . $this->modx->toJSON($this->crm->config) . ';
			crm.config.connector_url = "' . $this->crm->config['connectorUrl'] . '";
		});
		</script>');
		parent::initialize();
	}
	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('crm:default');
	}
	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}
/**
 * Class IndexManagerController
 */
class IndexManagerController extends crmMainController {
	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}