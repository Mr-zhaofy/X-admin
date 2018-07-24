<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class AdminRolePower extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_role_power';
    }


}
