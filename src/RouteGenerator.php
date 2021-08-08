<?php

namespace Test\RouteGenerator;

use Exception;

class RouteGenerator
{

    protected $startingPoint;

    protected array $tickets;

    protected array $mappedTickets = [];

    protected array $sortedTickets = [];

    protected $visitedSourcesMap = [];

    public function __construct(array $tickets, $startingPoint)
    {
        $foundKey = false;

        try {

            foreach ($tickets as $key => $ticket) {
                if (!($ticket instanceof Ticket))
                    throw new Exception("Invalid Ticket at position" . $key);

                $source = $ticket->getSource();
                $destination = $ticket->getDestination();

                $this->visitedSourcesMap[$source] = false;
                $this->visitedSourcesMap[$destination] = false;

                if ($source == $startingPoint) {
                    $foundKey = true;
                    $this->startingPoint = $source;
                }

                if (!isset($this->mappedTickets[$source])) {
                    $this->mappedTickets[$source] = [];
                }
                $this->mappedTickets[$source][$destination] =  $ticket;
            }

            if (!$foundKey) {
                throw new Exception("Starting location wrongly specified, " . $startingPoint . " not found in the tickets array");
            }

            $this->tickets = $tickets;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getRoute()
    {

        if (!count($this->sortedTickets)) {
            $tracebacks = [];
            $this->generateRoute($this->startingPoint, [], $tracebacks);
        }
        return $this->sortedTickets;
    }

    protected function generateRoute(string $startingPoint, array $currentPath, array &$tracebacks)
    {

        if (isset($this->mappedTickets[$startingPoint]) && count($this->mappedTickets[$startingPoint]) > 1 && !in_array($startingPoint, $tracebacks)) {
            $tracebacks[] = $startingPoint;
        }

        if (isset($this->mappedTickets[$startingPoint])) {
            $ticketsLeft = false;
            foreach ($this->mappedTickets[$startingPoint] as $destination => &$ticket) {
                if (in_array($destination, $tracebacks)) {
                    $tracebacks = array_slice($tracebacks, 0, array_search($destination, $tracebacks) + 1);
                }
                if (!$ticket->isUsed()) {
                    $ticketsLeft = true;
                    $ticket->use();
                    $currentPath[] = $ticket;
                    $this->generateRoute($destination, $currentPath, $tracebacks);
                    array_pop($currentPath);
                }
            }
            try {
                if (!$ticketsLeft && count($this->sortedTickets) && count($tracebacks) > 1)
                    throw new Exception("There are 2 or more terminal nodes in the provided configuration");
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        try {
            if (count($this->sortedTickets) && !isset($this->mappedTickets[$startingPoint]))
                throw new Exception("There are 2 or more terminal nodes in the provided configuration");
            if (!isset($this->mappedTickets[$startingPoint]))
                $this->sortedTickets = $currentPath;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
