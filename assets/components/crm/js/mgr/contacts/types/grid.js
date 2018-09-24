crm.grid.ContactsTypes = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'crm-contacts-types';
    }

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/contacts/types/getlist',
            sort: 'rank',
            dir: 'asc'
        },
        stateful: true,
        stateId: config.id,
        ddGroup: 'crm-contacts-types',
        ddAction: 'mgr/contacts/types/sort',
        enableDragDrop: true,
        multi_select: true,
    });
    crm.grid.ContactsTypes.superclass.constructor.call(this, config);
};
Ext.extend(crm.grid.ContactsTypes, crm.grid.Default, {

    getFields: function () {
        return [
            'id', 'name', 'active', 'description', 'rank', 'actions'
        ];
    },

    getColumns: function () {
        return [
            {header: _('crm_id'), dataIndex: 'id', width: 20},
            {header: _('crm_name'), dataIndex: 'name', width: 75},
            {header: _('crm_active'), dataIndex: 'active', width: 75, renderer: crm.utils.renderBoolean},
            {header: _('crm_description'), dataIndex: 'description', width: 75},
            {
                header: _('crm_actions'),
                dataIndex: 'actions',
                id: 'actions',
                width: 50,
                renderer: crm.utils.renderActions
            }
        ];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i> ' + _('crm_btn_create'),
            handler: this.createContactTypes,
            scope: this
        }, '->', this.getSearchField()];
    },

    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateContactsTypes(grid, e, row);
            },
        };
    },

    contactTypesAction: function (method) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: crm.config['connector_url'],
            params: {
                action: 'mgr/contacts/types/multyple',
                method: method,
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        //noinspection JSUnresolvedFunction
                        this.refresh();
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(_('error'), response.message);
                    }, scope: this
                },
            }
        })
    },

    createContactTypes: function (btn, e) {
        var w = Ext.getCmp('crm-window-contactstypes-create');
        if (w) {
            w.hide().getEl().remove();
        }

        w = MODx.load({
            xtype: 'crm-window-contactstypes-create',
            id: 'crm-window-contactstypes-create',
            record: this.menu.record,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.fp.getForm().reset();
        w.fp.getForm().setValues({
            active: true,
        });
        w.show(e.target);
    },

    updateContactsTypes: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }

        var w = Ext.getCmp('crm-window-contactstypes-update');
        if (w) {
            w.close();
        }
        w = MODx.load({
            xtype: 'crm-window-contactstypes-update',
            id: 'crm-window-contactstypes-update',
            record: this.menu.record,
            title: this.menu.record['name'],
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.fp.getForm().reset();
        w.fp.getForm().setValues(this.menu.record);
        w.show(e.target);
    },
    enableContactsTypes: function () {
        this.contactTypesAction('enable');
    },

    disableContactsTypes: function () {
        this.contactTypesAction('disable');
    },

    removeContactsTypes: function () {
        var ids = this._getSelectedIds();

        Ext.MessageBox.confirm(
            _('crm_menu_remove_title'),
            ids.length > 1
                ? _('crm_menu_remove_multiple_confirm')
                : _('crm_menu_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.contactTypesAction('remove');
                }
            }, this
        );
    },
});
Ext.reg('crm-contacts-types', crm.grid.ContactsTypes);