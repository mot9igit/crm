crm.window.CreateContactsTypes = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('crm_delivery'),
        width: 600,
        baseParams: {
            action: 'mgr/contacts/types/create',
        },
    });
    crm.window.CreateContactsTypes.superclass.constructor.call(this, config);
};
Ext.extend(crm.window.CreateContactsTypes, crm.window.Default, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id'
        }, {
            xtype: 'textfield',
            fieldLabel: _('crm_name'),
            name: 'name',
            anchor: '99%',
            id: config.id + '-name'

        }, {
            xtype: 'textarea',
            fieldLabel: _('crm_description'),
            name: 'description',
            anchor: '99%',
            id: config.id + '-description'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('crm_active'),
            hideLabel: true,
            name: 'active',
            id: config.id + '-active'
        }];
    },
});
Ext.reg('crm-window-contactstypes-create', crm.window.CreateContactsTypes);


crm.window.UpdateContactTypes = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/contacts/types/update',
        },
        bodyCssClass: 'tabs',
    });
    crm.window.UpdateContactTypes.superclass.constructor.call(this, config);
};
Ext.extend(crm.window.UpdateContactTypes, crm.window.CreateContactsTypes, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id'
        }, {
            xtype: 'textfield',
            fieldLabel: _('crm_name'),
            name: 'name',
            anchor: '99%',
            id: config.id + '-name'

        }, {
            xtype: 'textarea',
            fieldLabel: _('crm_description'),
            name: 'description',
            anchor: '99%',
            id: config.id + '-description'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('crm_active'),
            hideLabel: true,
            name: 'active',
            id: config.id + '-active'
        }];
    },

});
Ext.reg('crm-window-contactstypes-update', crm.window.UpdateContactTypes);