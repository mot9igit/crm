<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/crm/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/crm')) {
            $cache->deleteTree(
                $dev . 'assets/components/crm/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/crm/', $dev . 'assets/components/crm');
        }
        if (!is_link($dev . 'core/components/crm')) {
            $cache->deleteTree(
                $dev . 'core/components/crm/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/crm/', $dev . 'core/components/crm');
        }
    }
}

return true;