<?php

namespace Ubrize\SalesLv;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;
use Ubrize\SalesLv\Exceptions\CouldNotSendNotification;

class SalesLvChannel
{
    /**
     * @var SalesLvApi
     */
    protected $sales;

    /**
     * SalesLvChannel constructor
     *
     * @param SalesLvApi $sales
     */
    public function __construct(SalesLvApi $sales)
    {
        $this->sales = $sales;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return void
     * @throws GuzzleException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!($to = $this->getRecipient($notifiable, $notification))) {
            return;
        }

        $message = $notification->{'toSalesLv'}($notifiable);

        if (is_string($message)) {
            $message = new SalesLvMessage($message);
        }

        $this->sendMessage($to, $message);
    }

    /**
     * Gets phone number from the given notifiable.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return string|null
     */
    protected function getRecipient($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('SalesLv', $notification);

        if ($to === null || $to === false || $to === '') {
            return null;
        }

        return $to;
    }

    /**
     * @param string $recipient
     * @param SalesLvMessage $message
     * @throws GuzzleException
     */
    protected function sendMessage(string $recipient, SalesLvMessage $message)
    {
        if (mb_strlen($message->content) > 800) {
            throw CouldNotSendNotification::contentLengthLimitExceeded();
        }

        $params = [
            'Number' => $recipient,
            'Content' => $message->content,
        ];

        $this->sales->send($params);
    }
}
