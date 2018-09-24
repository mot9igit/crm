<?php
/**
 * Created by PhpStorm.
 * User: Артем
 * Date: 23.09.2018
 * Time: 13:14
 */

class crmContactsTypesGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'crmContactType';
    public $classKey = 'crmContactType';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
            ]);
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('crm_contacts_types_update'),
            //'multiple' => $this->modx->lexicon('crm_items_update'),
            'action' => 'updateContactsTypes',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('crm_contacts_types_enable'),
                'multiple' => $this->modx->lexicon('crm_contacts_types_enable'),
                'action' => 'enableContactsTypes',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('crm_contacts_types_disable'),
                'multiple' => $this->modx->lexicon('crm_contacts_types_disable'),
                'action' => 'disableContactsTypes',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('crm_contacts_types_remove'),
            'multiple' => $this->modx->lexicon('crm_contacts_types_remove'),
            'action' => 'removeContactsTypes',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'crmContactsTypesGetListProcessor';