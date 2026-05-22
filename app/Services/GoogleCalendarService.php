<?php

namespace App\Services;

use App\Models\EventRequest;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarService
{
    /**
     * Create a Google Calendar event from an EventRequest
     *
     * @param EventRequest $request
     * @return string The Google Calendar Event ID
     * @throws \Exception
     */
    public function createEventFromRequest(EventRequest $request): string
    {
        $event = new Event;

        $event->name = "Catering Cpata: {$request->nombre_completo}";
        $event->description = $this->buildDescription($request);
        $event->location = $request->direccion_evento;

        // Parse date and time
        $fecha = Carbon::parse($request->fecha_evento);
        $hora = Carbon::parse($request->hora_evento);
        
        $startDateTime = $fecha->copy()->setTime($hora->hour, $hora->minute, 0);
        // By default, assume event duration is 2 hours for catering delivery window
        $endDateTime = $startDateTime->copy()->addHours(2);

        $event->startDateTime = $startDateTime;
        $event->endDateTime = $endDateTime;

        $savedEvent = $event->save();

        return $savedEvent->id;
    }

    /**
     * Update an existing Google Calendar event
     *
     * @param EventRequest $request
     * @return void
     * @throws \Exception
     */
    public function updateEventFromRequest(EventRequest $request): void
    {
        if (!$request->google_calendar_event_id) {
            return;
        }

        $event = Event::find($request->google_calendar_event_id);
        
        if (!$event) {
            return;
        }

        $event->name = "Catering Cpata: {$request->nombre_completo}";
        $event->description = $this->buildDescription($request);
        $event->location = $request->direccion_evento;

        $fecha = Carbon::parse($request->fecha_evento);
        $hora = Carbon::parse($request->hora_evento);
        
        $startDateTime = $fecha->copy()->setTime($hora->hour, $hora->minute, 0);
        $endDateTime = $startDateTime->copy()->addHours(2);

        $event->startDateTime = $startDateTime;
        $event->endDateTime = $endDateTime;

        $event->save();
    }

    /**
     * Delete an event from Google Calendar
     *
     * @param string $eventId
     * @return void
     */
    public function deleteEvent(string $eventId): void
    {
        try {
            $event = Event::find($eventId);
            if ($event) {
                $event->delete();
            }
        } catch (\Exception $e) {
            // Ignore if already deleted
        }
    }

    /**
     * Check if an event exists in Google Calendar
     *
     * @param string $eventId
     * @return bool
     */
    public function eventExists(string $eventId): bool
    {
        try {
            $event = Event::find($eventId);
            if (!$event || $event->googleEvent->status === 'cancelled') {
                return false;
            }
            return true;
        } catch (\Google\Service\Exception $e) {
            if ($e->getCode() == 404) {
                return false;
            }
            throw $e;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sync all local events with Google Calendar to check for deletions
     */
    public function syncAllEvents(): void
    {
        $localEvents = EventRequest::whereNotNull('google_calendar_event_id')->get();
        if ($localEvents->isEmpty()) {
            return;
        }

        // Fetch events from Google Calendar (past month to next 2 years)
        $googleEvents = Event::get(Carbon::now()->subMonths(1), Carbon::now()->addYears(2));
        
        $activeGoogleIds = [];
        foreach ($googleEvents as $gEvent) {
            if ($gEvent->googleEvent->status !== 'cancelled') {
                $activeGoogleIds[] = $gEvent->id;
            }
        }

        foreach ($localEvents as $localEvent) {
            if (!in_array($localEvent->google_calendar_event_id, $activeGoogleIds)) {
                $localEvent->update([
                    'google_calendar_event_id' => null,
                    'estado' => \App\Enums\EventRequestStatus::PendienteSeña,
                ]);
            }
        }
    }

    /**
     * Build the description for the calendar event
     */
    private function buildDescription(EventRequest $request): string
    {
        $desc = "📍 *Detalles del Pedido*\n\n";
        $desc .= "👤 Cliente: {$request->nombre_completo}\n";
        $desc .= "📞 Teléfono: {$request->telefono}\n";
        $desc .= "✉️ Email: {$request->email}\n";
        $desc .= "👥 Invitados: {$request->cantidad_invitados}\n\n";
        
        if ($request->product) {
            $desc .= "🍽️ *Producto*: {$request->product->name}\n";
            if ($request->variant) {
                $desc .= "   Variante: {$request->variant->label}\n";
            }
        }

        if ($request->observaciones_cliente) {
            $desc .= "\n💬 *Observaciones del cliente*:\n{$request->observaciones_cliente}\n";
        }

        if ($request->observaciones_admin) {
            $desc .= "\n🔒 *Notas internas*:\n{$request->observaciones_admin}\n";
        }

        return $desc;
    }
}
