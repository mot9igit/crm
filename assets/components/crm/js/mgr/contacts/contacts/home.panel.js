crm.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('crm') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('crm_contacts_items'),
                layout: 'anchor',
                items: [{
                    html: _('crm_contacts_intro_msg'),
                    cls: 'panel-desc'
                }, {
                    xtype: 'crm-contacts-grid-items',
                    cls: 'main-wrapper'
                }]
            },{
                title: _('crm_contacts_types'),
                layout: 'anchor',
                items: [{
                    html: _('crm_contacts_types_intro'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'crm-contacts-types',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    crm.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(crm.panel.Home, MODx.Panel);
Ext.reg('crm-panel-home', crm.panel.Home);
