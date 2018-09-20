crm.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'crm-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: false,
            hideMode: 'offsets',
            items: [{
                title: _('crm_items'),
                layout: 'anchor',
                items: [{
                    html: _('crm_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'crm-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    crm.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(crm.panel.Home, MODx.Panel);
Ext.reg('crm-panel-home', crm.panel.Home);
