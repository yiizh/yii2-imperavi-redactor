# yii2-imperavi-redactor
Imperavi Redactor WYSIWYG widget (OEM-licensed for Yii).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiizh/yii2-imperavi-redactor
```

or add

```
"yiizh/yii2-imperavi-redactor": "*"
```

to the require section of your `composer.json` file.

Usage
-----

```php
<?= yiizh\redactor\Redactor::widget(['name' => 'attributeName']) ?>
```

Configuring the Imperavi Redactor options should be done using the clientOptions attribute:

```php
<?= yiizh\redactor\Redactor::widget(['name' => 'attributeName', 'clientOptions' => ['lang' => \Yii::$app->language]]) ?>
```

If you want to use the Imperavi Redactor widget in an ActiveForm, it can be done like this:

```php
<?= $form->field($model,'attributeName')->widget(Redactor::className(),['clientOptions' =>  ['lang' => \Yii::$app->language]]) ?>
```
