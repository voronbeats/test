<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace yii\validators;

use Yii;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\JsExpression;

/**
 * NumberValidator validates that the attribute value is a number.
 *
 * The format of the number must match the regular expression specified in [[integerPattern]] or [[numberPattern]].
 * Optionally, you may configure the [[max]] and [[min]] properties to ensure the number
 * is within certain range.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class NumberValidator extends Validator
{
    /**
     * @var bool whether to allow array type attribute. Defaults to false.
     * @since 2.0.42
     */
    public $allowArray = false;
    /**
     * @var bool whether the attribute value can only be an integer. Defaults to false.
     */
    public $integerOnly = false;
    /**
     * @var int|float|null upper limit of the number. Defaults to null, meaning no upper limit.
     * @see tooBig for the customized message used when the number is too big.
     */
    public $max;
    /**
     * @var int|float|null lower limit of the number. Defaults to null, meaning no lower limit.
     * @see tooSmall for the customized message used when the number is too small.
     */
    public $min;
    /**
     * @var string user-defined error message used when the value is bigger than [[max]].
     */
    public $tooBig;
    /**
     * @var string user-defined error message used when the value is smaller than [[min]].
     */
    public $tooSmall;
    /**
     * @var string the regular expression for matching integers.
     */
    public $integerPattern = '/^[+-]?\d+$/';
    /**
     * @var string the regular expression for matching numbers. It defaults to a pattern
     * that matches floating numbers with optional exponential part (e.g. -1.23e-10).
     */
    public $numberPattern = '/^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$/';


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = $this->integerOnly ? Yii::t('yii', '{attribute} должен быть числом.')
                : Yii::t('yii', '{attribute} must be a number.');
        }
        if ($this->min !== null && $this->tooSmall === null) {
            $this->tooSmall = Yii::t('yii', '{attribute} must be no less than {min}.');
        }
        if ($this->max !== null && $this->tooBig === null) {
            $this->tooBig = Yii::t('yii', '{attribute} must be no greater than {max}.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (is_array($value) && !$this->allowArray) {
            $this->addError($model, $attribute, $this->message);
            return;
        }
        $values = !is_array($value) ? [$value] : $value;
        foreach ($values as $value) {
            if ($this->isNotNumber($value)) {
                $this->addError($model, $attribute, $this->message);
                return;
            }
            $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;

            if (!preg_match($pattern, StringHelper::normalizeNumber($value))) {
                $this->addError($model, $attribute, $this->message);
            }
            if ($this->min !== null && $value < $this->min) {
                $this->addError($model, $attribute, $this->tooSmall, ['min' => $this->min]);
            }
            if ($this->max !== null && $value > $this->max) {
                $this->addError($model, $attribute, $this->tooBig, ['max' => $this->max]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validateValue($value)
    {
        if (is_array($value) && !$this->allowArray) {
            return [$this->message, []];
        }
        $values = !is_array($value) ? [$value] : $value;
        foreach ($values as $sample) {
            if ($this->isNotNumber($sample)) {
                return [$this->message, []];
            }
            $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;
            if (!preg_match($pattern, StringHelper::normalizeNumber($sample))) {
                return [$this->message, []];
            } elseif ($this->min !== null && $sample < $this->min) {
                return [$this->tooSmall, ['min' => $this->min]];
            } elseif ($this->max !== null && $sample > $this->max) {
                return [$this->tooBig, ['max' => $this->max]];
            }
        }

        return null;
    }

    /**
     * @param mixed $value the data value to be checked.
     */
    private function isNotNumber($value)
    {
        return is_array($value)
            || is_bool($value)
            || (is_object($value) && !method_exists($value, '__toString'))
            || (!is_object($value) && !is_scalar($value) && $value !== null);
    }

    /**
     * {@inheritdoc}
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        ValidationAsset::register($view);
        $options = $this->getClientOptions($model, $attribute);

        return 'yii.validation.number(value, messages, ' . Json::htmlEncode($options) . ');';
    }

    /**
     * {@inheritdoc}
     */
    public function getClientOptions($model, $attribute)
    {
        $label = $model->getAttributeLabel($attribute);

        $options = [
            'pattern' => new JsExpression($this->integerOnly ? $this->integerPattern : $this->numberPattern),
            'message' => $this->formatMessage($this->message, [
                'attribute' => $label,
            ]),
        ];

        if ($this->min !== null) {
            // ensure numeric value to make javascript comparison equal to PHP comparison
            // https://github.com/yiisoft/yii2/issues/3118
            $options['min'] = is_string($this->min) ? (float) $this->min : $this->min;
            $options['tooSmall'] = $this->formatMessage($this->tooSmall, [
                'attribute' => $label,
                'min' => $this->min,
            ]);
        }
        if ($this->max !== null) {
            // ensure numeric value to make javascript comparison equal to PHP comparison
            // https://github.com/yiisoft/yii2/issues/3118
            $options['max'] = is_string($this->max) ? (float) $this->max : $this->max;
            $options['tooBig'] = $this->formatMessage($this->tooBig, [
                'attribute' => $label,
                'max' => $this->max,
            ]);
        }
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        return $options;
    }
}
