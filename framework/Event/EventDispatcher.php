<?php

namespace Nstaeger\Framework\Event;

class EventDispatcher
{
    /**
     * The registered event listeners.
     *
     * @var array
     */
    private $listeners = [];

    /**
     * The sorted event listeners.
     *
     * @var array
     */
    private $sorted = [];

    /**
     * Fire an event and call the listeners.
     *
     * @param  string $event
     * @param  mixed  $payload
     * @return array of listener results
     */
    public function fire($event, $payload = [])
    {
        $responses = [];

        foreach ($this->getListeners($event) as $listener) {
            $responses[] = call_user_func_array($listener, $payload);
        }

        return $responses;
    }

    /**
     * Get all of the listeners for a given event name.
     *
     * @param  string $eventName
     * @return array
     */
    public function getListeners($eventName)
    {
        if (!isset($this->sorted[$eventName])) {
            $this->sortListeners($eventName);
        }

        return $this->sorted[$eventName];
    }

    /**
     * Register an event listener.
     *
     * @param string|string[] $events
     * @param callable        $listener
     * @param int             $priority
     */
    public function on($events, $listener, $priority = 0)
    {
        foreach ((array)$events as $event) {
            $this->listeners[$event][$priority][] = $listener;
        }
    }

    /**
     * Sort the listeners for a given event by priority.
     *
     * @param  string $eventName
     * @return array
     */
    protected function sortListeners($eventName)
    {
        $this->sorted[$eventName] = [];

        // If listeners exist for the given event, we will sort them by the priority
        // so that we can call them in the correct order. We will cache off these
        // sorted event listeners so we do not have to re-sort on every events.
        if (isset($this->listeners[$eventName])) {
            krsort($this->listeners[$eventName]);
            $this->sorted[$eventName] = call_user_func_array(
                'array_merge',
                $this->listeners[$eventName]
            );
        }
    }
}
