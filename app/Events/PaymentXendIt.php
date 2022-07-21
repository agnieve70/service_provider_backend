<?php

namespace App\Events;

use App\Models\Services;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

require '../vendor/autoload.php';
use Xendit\Xendit;

class PaymentXendIt
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user_id;
    public $service_id;
    public $latitude;
    public $longitude;

    public function __construct($user_id, $service_id, $latitude, $longitude)
    {
        //
        $this->user_id = $user_id;
        $this->service_id = $service_id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        Xendit::setApiKey('xnd_development_PHc4IFLMGAbblHa69gIqmqhuN2ydZHv0Fc9b0xBJYHiF6GzPpP4WMKoYhELZYU0');
        // $this->setPayment();
        // $this->getPayment('624a585ae5bb0741c597c1c1');
    }
    public function getPayment($id)
    {
        $invoiceInfo = \Xendit\Invoice::retrieve($id);
        var_dump(json_encode($invoiceInfo));
    }

    public function setPayout()
    {
        $params = [
            'external_id' => '1234123sdf',
            'amount' => 23000,
            'email'=> 'agnieve70@gmail.com'
          ];
        
          $createPayout = \Xendit\Payouts::create($params);
        var_dump(json_encode($createPayout));
    }

    public function setPayment(){
        
        $user_info = User::where('id', $this->user_id)->first();
        $service_info = Services::where('id', $this->service_id)->first();
      
        $str_rnd = Str::random(8);

        logger($user_info);
        logger($service_info);
        // logger($role_info);
        // logger($merchant_company);
        // logger($merchant_info);

        $transaction = new Transaction();
        $transaction->client = $this->user_id;
        $transaction->service_id = $this->service_id;
        $transaction->latitude = $this->latitude;
        $transaction->longtitude = $this->longitude;
        $transaction->transaction_no = $str_rnd;
        $transaction->status = 'Pending';
        $transaction->save();


        $params = [
            'external_id' => $str_rnd,
            'amount' => 495,
            'description' => 'Service Finder',
            'invoice_duration' => 86400,
            'customer' => [
                'given_names' => $user_info->firstname,
                'surname' => $user_info->lastname,
                'email' => $user_info->email,
                'contact' => $user_info->contact,
            ],
            'customer_notification_preference' => [
                'invoice_created' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ],
                'invoice_reminder' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ],
                'invoice_paid' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ],
                'invoice_expired' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ]
            ],
            'success_redirect_url' => 'http://localhost:8000/success',
            'failure_redirect_url' => 'http://localhost:8000/fail',
            'currency' => 'PHP',
            'items' => [
                [
                    'name' => 'Service Finder Fee',
                    'quantity' => 1,
                    'price' => $service_info->price,
                    'category' => 'Service Fee',
                    'url' => 'https://service-provider-pi.vercel.app/'
                ]
            ],
            'fees' => [
                [
                    'type' => 'Service Fee',
                    'value' => $service_info->price
                ]
            ]
        ];

        $createInvoice = \Xendit\Invoice::create($params);
        return($createInvoice);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
