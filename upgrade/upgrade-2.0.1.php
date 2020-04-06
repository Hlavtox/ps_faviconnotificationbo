<?php
/**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param Ps_faviconnotificationbo $module
 *
 * @return bool
 */
function upgrade_module_2_0_1($module)
{
    $result = true;

    // Remove our ModuleAdminControllers from SEO & URLs page
    foreach ($module->adminControllers as $controller) {
        $metaId = Db::getInstance()->getValue('
            SELECT id_meta
            FROM `' . _DB_PREFIX_ . 'meta`
            WHERE page="' . pSQL('module-' . $module->name . '-' . $controller) . '"'
        );

        if ($metaId) {
            $result = $result && Db::getInstance()->delete(
                    'meta_lang',
                    'id_meta = ' . (int) $metaId
                );
            $result = $result && Db::getInstance()->delete(
                    'meta',
                    'id_meta = ' . (int) $metaId
                );
        }
    }

    return $result;
}
