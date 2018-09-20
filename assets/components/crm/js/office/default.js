Ext.onReady(function () {
    crm.config.connector_url = OfficeConfig.actionUrl;

    var grid = new crm.panel.Home();
    grid.render('office-crm-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});