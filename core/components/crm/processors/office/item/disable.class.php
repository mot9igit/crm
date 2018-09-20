<?php

class crmOfficeItemDisableProcessor extends modObjectProcessor
{
    public $objectType = 'crmItem';
    public $classKey = 'crmItem';
    public $languageTopics = ['crm'];
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('crm_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var crmItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('crm_item_err_nf'));
            }

            $object->set('active', false);
            $object->save();
        }

        return $this->success();
    }

}

return 'crmOfficeItemDisableProcessor';
