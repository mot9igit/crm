<?php

class crmContactsTypesMultipleProcessor extends modProcessor
{


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$method = $this->getProperty('method', false)) {
            return $this->failure();
        }
        $ids = json_decode($this->getProperty('ids'), true);
        if (empty($ids)) {
            return $this->success();
        }

        /** @var crm $crm */
        $crm = $this->modx->getService('crm');

        foreach ($ids as $id) {
            /** @var modProcessorResponse $response */
            $response = $crm->runProcessor('mgr/contacts/types/' . $method, array('id' => $id));
            if ($response->isError()) {
                return $response->getResponse();
            }
        }

        return $this->success();
    }

}

return 'crmContactsTypesMultipleProcessor';