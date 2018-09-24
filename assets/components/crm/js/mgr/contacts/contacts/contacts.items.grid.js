crm.grid.ContactItems = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'crm-contacts-grid-items'
        ,url: crm.config.connector_url
        ,baseParams: {
            action: 'mgr/item/getlist'
        }
        ,fields: ['id','name','comment']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [
            {header: _('id'),dataIndex: 'id',width: 70}
            ,{header: _('name'),dataIndex: 'name',width: 200}
            ,{header: _('description'),dataIndex: 'comment',width: 250}
        ]
        ,tbar: [{
            text: '<i class="icon icon-plus"></i> ' + _('crm_btn_create')
            ,handler: this.createContact
            ,scope: this
        }]
        ,listeners: {
            rowDblClick: function(grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateContact(grid, e, row);
            }
        }
    });
    crm.grid.ContactItems.superclass.constructor.call(this,config);
};
Ext.extend(crm.grid.ContactItems,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('crm_item_update')
            ,handler: this.updateContact
        });
        m.push('-');
        m.push({
            text: _('crm_item_remove')
            ,handler: this.removeContact
        });
        this.addContextMenuItem(m);
    }

    ,createContact: function(btn,e) {
        if (!this.windows.createContact) {
            this.windows.createContact = MODx.load({
                xtype: 'crm-window-contact-create'
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.createContact.fp.getForm().reset();
        this.windows.createContact.show(e.target);
    }

    ,updateContact: function(btn,e,row) {
        if (typeof(row) != 'undefined') {this.menu.record = row.data;}
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: crm.config.connector_url
            ,params: {
                action: 'mgr/item/get'
                ,id: id
            }
            ,listeners: {
                success: {fn:function(r) {
                        if (!this.windows.updateContact) {
                            this.windows.updateContact = MODx.load({
                                xtype: 'crm-window-contact-update'
                                ,record: r
                                ,listeners: {
                                    'success': {fn:function() { this.refresh(); },scope:this}
                                }
                            });
                        }
                        this.windows.updateContact.fp.getForm().reset();
                        this.windows.updateContact.fp.getForm().setValues(r.object);
                        this.windows.updateContact.show(e.target);
                    },scope:this}
            }
        });
    }

    ,removeContact: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('crm_item_remove')
            ,text: _('crm_item_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/item/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
});
Ext.reg('crm-contacts-grid-items',crm.grid.ContactItems);




crm.window.CreateContact = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('crm_item_create')
        ,id: this.ident
        ,height: 200
        ,width: 475
        ,url: crm.config.connector_url
        ,action: 'mgr/item/create'
        ,fields: [
            {
                xtype: 'textfield',
                fieldLabel: _('name'),
                name: 'name',
                id: 'crm-'+this.ident+'-name',
                anchor: '99%'
            },{
                xtype: 'textarea',
                fieldLabel: _('description'),
                name: 'comment',
                id: 'crm-'+this.ident+'-description',
                height: 150,
                anchor: '99%'
            },{
                xtype: 'crm-combo-contacts-types',
                id: config.id + '-contacts-types',
                fieldLabel: _('crm_contacts_types'),
                emptyText: _('crm_contacts_types'),
                name: 'type',
                addall: true,
                listeners: {
                    select: {
                        fn: function () {
                            this.fireEvent('change')
                        }, scope: this
                    }
                }
            }
        ]
        ,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
    });
    crm.window.CreateContact.superclass.constructor.call(this,config);
};
Ext.extend(crm.window.CreateContact,MODx.Window);
Ext.reg('crm-window-contact-create',crm.window.CreateContact);


crm.window.UpdateContact = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('crm_item_update')
        ,id: this.ident
        ,height: 200
        ,width: 475
        ,url: crm.config.connector_url
        ,action: 'mgr/item/update'
        ,fields: [
            {
                xtype: 'hidden',
                name: 'id',
                id: 'crm-'+this.ident+'-id'
            },{
                xtype: 'textfield',
                fieldLabel: _('name'),
                name: 'name',
                id: 'crm-'+this.ident+'-name',
                anchor: '99%'
            },{
                xtype: 'textarea',
                fieldLabel: _('description'),
                name: 'comment',
                id: 'crm-'+this.ident+'-description',
                height: 150,
                anchor: '99%'
            },{
                xtype: 'crm-combo-contacts-types',
                id: config.id + '-contacts-types-update',
                fieldLabel: _('crm_contacts_types'),
                emptyText: _('crm_contacts_types'),
                name: 'type',
                addall: true,
                listeners: {
                    select: {
                        fn: function () {
                            this.fireEvent('change')
                        }, scope: this
                    }
                }
            }
        ]
        ,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
    });
    crm.window.UpdateContact.superclass.constructor.call(this,config);
};
Ext.extend(crm.window.UpdateContact,MODx.Window);
Ext.reg('crm-window-contact-update',crm.window.UpdateContact);