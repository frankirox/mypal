<?php

namespace common\forms;

use common\models\TicketBody;
use common\models\TicketHead;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
abstract class BaseTicketForm extends Model implements BaseTicketInterface
{

    public $topic;
    public $department_id;
    public $text;
    protected $_ticketHead;
    protected $_ticketBody;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // topic, department, text are required
            [['topic', 'department_id', 'text'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'topic' => Yii::t('miranda/support', 'Topic'),
            'department_id' => Yii::t('miranda/support', 'Department'),
            'text' => Yii::t('miranda/support', 'Message'),
        ];
    }

    protected function setTicketHead($object)
    {

        $this->_ticketHead = $object;

    }

    protected function setTicketBody($object)
    {

        $this->_ticketBody = $object;

    }

    protected function getTicketHead()
    {

        return $this->_ticketHead;

    }

    protected function getTicketBody()
    {

        return $this->_ticketBody;

    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}