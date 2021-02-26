<?php
/**
 * Plausible plugin for Craft CMS 3.x
 *
 * @link      https://shorn.co.uk
 * @copyright Copyright (c) 2021 Sean Hill
 */

namespace shornuk\plausible\widgets;

use shornuk\plausible\Plausible;
use shornuk\plausible\services\PlausibleService;
use shornuk\plausible\assetbundles\widgets\overview\OverviewAsset;

use Craft;
use craft\base\Widget;

/**
 * Overview Widget
 *
 * @author    Sean Hill
 * @package   Plausible
 * @since     1.0.0
 */
class Overview extends Widget
{

    // Public Properties
    // =========================================================================

    public $timePeriod = '6mo';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('plausible', 'Overview');
    }

    /**
     * @inheritdoc
     */
    public static function icon()
    {
        return Craft::getAlias("@shornuk/plausible/assetbundles/widgets/overview/dist/img/Plausible-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    public function getTitle(): string
    {
        if (!isset($title)) {
            $title = Craft::t('plausible', 'Overview');
        }
        $timePeriod = $this->timePeriod;

        if ($timePeriod) {
            $title = Craft::t('app', 'Overview - {timePeriod}', [
                'timePeriod' => Craft::t('plausible', Plausible::$plugin->plausible->timeLabelize($timePeriod)),
            ]);
        }
        return $title;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'plausible/_components/widgets/Overview/settings',
            [
                'widget' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        Craft::$app->getView()->registerAssetBundle(OverviewAsset::class);

        $results = Plausible::$plugin->plausible->getOverview($this->timePeriod);

        return Craft::$app->getView()->renderTemplate(
            'plausible/_components/widgets/Overview/body',
            [
                'results' => $results
            ]
        );
    }
}