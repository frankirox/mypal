<?php

namespace common\db;

/**
 * @inheritdoc
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /** @var string */
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';

    /*public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }*/

    /**
     * Returns TRUE if model support multilingual behavior.
     * @return bool
     * @internal param ActiveRecord $model
     */
    public function isMultilingual()
    {
        return ($this->getBehavior('multilingual') !== null);
    }

    /**
     * Get active query
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * Formats all model errors into a single string
     * @return string
     */
    public function formatErrors()
    {
        $result = '';
        foreach ($this->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors) . " ";
        }
        return $result;
    }


}
