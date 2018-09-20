var crm = function (config) {
    config = config || {};
    crm.superclass.constructor.call(this, config);
};
Ext.extend(crm, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('crm', crm);

crm = new crm();