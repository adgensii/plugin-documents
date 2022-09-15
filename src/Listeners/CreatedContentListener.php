<?php

namespace Botble\Documents\Listeners;

use Botble\Base\Events\CreatedContentEvent;
use Exception;
use Documents;

class CreatedContentListener
{
    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        try {
            Documents::saveDocumentsList($event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
