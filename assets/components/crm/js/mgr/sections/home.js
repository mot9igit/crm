crm.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'crm-panel-home',
            renderTo: 'crm-panel-home-div'
        }]
    });
    crm.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(crm.page.Home, MODx.Component);
Ext.reg('crm-page-home', crm.page.Home);