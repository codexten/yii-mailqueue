<?php
/**
 * Created by PhpStorm.
 * User: bijith
 * Date: 10/13/18
 * Time: 3:38 PM
 */

namespace codexten\yii\mailqueue\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%mail_queue}}".
 *
 * @property string $subject
 * @property integer $created_at
 * @property integer $attempts
 * @property integer $last_attempt_time
 * @property integer $sent_time
 * @property string $time_to_send
 * @property string $swift_message
 */
class MailQueue extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mail_queue}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['last_attempt_time'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'attempts', 'last_attempt_time', 'sent_time'], 'integer'],
            [['time_to_send', 'swift_message'], 'required'],
            [['subject'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'created_at' => Yii::t('app', 'Created At'),
            'attempts' => Yii::t('app', 'Attempts'),
            'last_attempt_time' => Yii::t('app', 'Last Attempt Time'),
            'sent_time' => Yii::t('app', 'Sent Time'),
            'time_to_send' => Yii::t('app', 'Time To Send'),
            'swift_message' => Yii::t('app', 'Swift Message'),
            'subject' => Yii::t('app', 'Subject'),
        ];
    }

    public function toMessage()
    {
        return unserialize(base64_decode($this->swift_message));
    }
}