crm.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    crm.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(crm.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('crm-combo-search', crm.combo.Search);
Ext.reg('crm-field-search', crm.combo.Search);

crm.combo.ContactsTypes = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'type',
        id: 'crm-combo-contact-type',
        hiddenName: 'type',
        displayField: 'name',
        valueField: 'id',
        fields: ['id', 'name'],
        pageSize: 10,
        emptyText: _('crm_combo_select_contact_type'),
        url: crm.config['connector_url'],
        baseParams: {
            action: 'mgr/contacts/types/getlist',
            combo: true,
            addall: config.addall || 0,
            order_id: config.order_id || 0
        },
        listeners: crm.combo.listeners_disable
    });
    crm.combo.ContactsTypes.superclass.constructor.call(this, config);
};
Ext.extend(crm.combo.ContactsTypes, MODx.combo.ComboBox);
Ext.reg('crm-combo-contacts-types', crm.combo.ContactsTypes);