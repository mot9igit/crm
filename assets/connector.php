<?php
/**
 * Created by PhpStorm.
 * User: Артем
 * Date: 22.09.2018
 * Time: 22:34
 */
// For debug
ini_set('display_errors', 1);
ini_set('error_reporting', -1);
// Load MODX config
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';
$corePath = $modx->getOption('crm_core_path', null, $modx->getOption('core_path') . 'components/crm/');
require_once $corePath . 'model/crm/crm.class.php';
$modx->crm = new crm($modx);
$modx->lexicon->load('crm:default');
/* handle request */
$path = $modx->getOption('processorsPath', $modx->crm->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));