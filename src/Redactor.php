<?php
/**
 * @author Di Zhang <alex@extong.net>
 */

namespace yiizh\redactor;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Redactor extends InputWidget
{
    /**
     * @var array Redactor settings
     * @see https://imperavi.com/redactor/docs/settings/
     */
    public $clientOptions = [];

    public $languages = [
        'ar' => 'ar',
        'az' => 'az',
        'ba' => 'ba',
        'bg' => 'bg',
        'by' => 'by',
        'ca' => 'ca',
        'cs' => 'cs',
        'da' => 'da',
        'de' => 'de',
        'el' => 'el',
        'eo' => 'eo',
        'es' => 'es',
        'es-AR' => 'es_ar',
        'fa' => 'fa',
        'fi' => 'fi',
        'fr' => 'fr',
        'ge' => 'ge',
        'he' => 'he',
        'hr' => 'hr',
        'hu' => 'hu',
        'id' => 'id',
        'it' => 'it',
        'ja' => 'ja',
        'ko' => 'ko',
        'lt' => 'lt',
        'lv' => 'lv',
        'mk' => 'mk',
        'nl' => 'nl',
        'no-NB' => 'no_NB',
        'pl' => 'pl',
        'pt-BR' => 'pt_br',
        'pt-PT' => 'pt_pt',
        'ro' => 'ro',
        'ru' => 'ru',
        'sl' => 'sl',
        'sq' => 'sq',
        'sr-CIR' => 'sr-cir',
        'sr-LAT' => 'sr-lat',
        'sv' => 'sv',
        'th' => 'th',
        'tr' => 'tr',
        'ua' => 'ua',
        'vi' => 'vi',
        'zh-CN' => 'zh_cn',
        'zh-TW' => 'zh_tw',

    ];

    protected $plugins = [
        'clips',
        'counter',
        'definedlinks',
        'filemanager',
        'fontcolor',
        'fontfamily',
        'fontsize',
        'fullscreen',
        'imagemanager',
        'limiter',
        'table',
        'textdirection',
        'textexpander',
        'video'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if (!isset($this->clientOptions['lang'])) {
            $this->clientOptions['lang'] = ArrayHelper::getValue($this->languages, Yii::$app->language);
        }

        $this->registerClientOptions();
    }

    protected function registerClientOptions()
    {
        $view = $this->getView();
        $bundle = RedactorAsset::register($view);

        $lang = $this->clientOptions['lang'];
        if ($lang != null && is_file(Yii::getAlias($bundle->basePath, false) . '/lang/' . $lang . '.js')) {
            $view->registerJsFile($bundle->baseUrl . '/lang/' . $lang . '.js', ['depends' => [$bundle::className()]]);
        }

        if (isset($this->clientOptions['plugins']) && is_array($this->clientOptions['plugins'])) {
            foreach ($this->clientOptions['plugins'] as $plugin) {
                if (in_array($plugin, $this->plugins, true)) {
                    $view->registerJsFile($bundle->baseUrl . '/plugins/' . $plugin . '/' . $plugin . '.js',
                        ['depends' => [$bundle::className()]]);
                    if ($plugin == 'clips') {
                        $view->registerCssFile($bundle->baseUrl . '/plugins/' . $plugin . '/' . $plugin . '.css',
                            ['depends' => [$bundle::className()]]);
                    }
                }
            }
        }

        $clientOptions = Json::encode($this->clientOptions);

        $view->registerJs('jQuery(\'#' . $this->options['id'] . '\').redactor(' . $clientOptions . ');');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            return Html::textarea($this->name, $this->value, $this->options);
        }
    }
}