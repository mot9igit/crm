<?php

class crmContactsRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'crmContacts';
    public $classKey = 'crmContacts';
    public $languageTopics = ['crm'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }
        $id = $this->getProperty('id');
        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            if(!empty($id)) {
                if (!$object = $this->modx->getObject($this->classKey, $id)) {
                    return $this->failure($this->modx->lexicon('crm_item_err_nf'));
                }
                $object->remove();
            }else{
                return $this->failure($this->modx->lexicon('crm_item_err_ns'));
            }
        }

        foreach ($ids as $id) {
            /** @var crmItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('crm_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'crmContactsRemoveProcessor';