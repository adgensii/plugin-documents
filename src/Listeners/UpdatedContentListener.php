<?php

namespace Botble\Documents\Listeners;

use Botble\Base\Events\UpdatedContentEvent;
use Exception;
use Documents;

class UpdatedContentListener
{
    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            Documents::saveDocumentsList($event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
