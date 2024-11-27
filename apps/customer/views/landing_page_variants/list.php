<?php declare(strict_types=1);
if (!defined('MW_PATH')) {
    exit('No direct script access allowed');
}

/**
 * This file is part of the MailWizz EMA application.
 *
 * @package MailWizz EMA
 * @author MailWizz Development Team <support@mailwizz.com>
 * @link https://www.mailwizz.com/
 * @copyright MailWizz EMA (https://www.mailwizz.com)
 * @license https://www.mailwizz.com/license/
 * @since 2.3.0
 */

/** @var Controller $controller */
$controller = controller();

/** @var string $pageHeading */
$pageHeading = (string)$controller->getData('pageHeading');

/** @var LandingPage $page */
$page = $controller->getData('page');

/** @var LandingPageRevisionVariant[] $activeVariants */
$activeVariants = $controller->getData('activeVariants');

/** @var LandingPageRevisionVariant[] $inactiveVariants */
$inactiveVariants = $controller->getData('inactiveVariants');

/**
 * This hook gives a chance to prepend content or to replace the default view content with a custom content.
 * Please note that from inside the action callback you can access all the controller view
 * variables via {@CAttributeCollection $collection->controller->getData()}
 * In case the content is replaced, make sure to set {@CAttributeCollection $collection->add('renderContent', false)}
 * in order to stop rendering the default content.
 * @since 1.3.3.1
 */
hooks()->doAction('before_view_file_content', $viewCollection = new CAttributeCollection([
    'controller'    => $controller,
    'renderContent' => true,
]));

// and render if allowed
if ($viewCollection->itemAt('renderContent')) {
    $controller->widget('customer.components.web.widgets.landing-pages.LandingPageVariantsListWidget', [
        'title'    => t('landing_pages', 'Active variants'),
        'page'     => $page,
        'variants' => $activeVariants,
    ]);

    $controller->widget('customer.components.web.widgets.landing-pages.LandingPageVariantsListWidget', [
        'title'    => t('landing_pages', 'Inactive variants'),
        'page'     => $page,
        'variants' => $inactiveVariants,
    ]);
}
/**
 * This hook gives a chance to append content after the view file default content.
 * Please note that from inside the action callback you can access all the controller view
 * variables via {@CAttributeCollection $collection->controller->getData()}
 * @since 1.3.3.1
 */
hooks()->doAction('after_view_file_content', new CAttributeCollection([
    'controller'      => $controller,
    'renderedContent' => $viewCollection->itemAt('renderContent'),
]));