<?php

namespace App\Widgets;

use App\Models\Participant;
use Arrilot\Widgets\AbstractWidget;

class CheckStatus extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'participant_id' => '',
        // 'valueOffer' => '',
    ];
    public $reloadTimeout = 3;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        $participant = Participant::findOrFail($this->config['participant_id']);
        // $offer = $participant->offer()->first();
        // $valueOffer = $offer->valueOffers()->where('will_get', '>', '0')->inRandomOrder()->first();
        return view('widgets.check_status', [
            'config' => $this->config,
            'participant' => $participant,
            // 'valueOffer' => $valueOffer,
            // 'offer' => $offer
        ]);
    }

    public function container()
    {

        return [
            'element'       => 'div',
            'attributes'    => ' class="col-lg-12"',
        ];
    }
}
