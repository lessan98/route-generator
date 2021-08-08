<?php

namespace Test\RouteGenerator;

use Exception;

class Ticket
{

    protected string $source;

    protected string $destination;

    protected int $type;

    protected string $extraMentions = '';

    protected bool $used = false;

    protected string $vehicleUID = '';

    public function __construct(string $source, string $destination, int $type, string $vehicleUID = '', string $extraMentions = '', bool $used = false)
    {
        try {
            if (!TicketType::isValid($type))
                throw new Exception("Invalid Ticket Type");
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $this->source = $source;
        $this->destination = $destination;
        $this->type = $type;
        $this->extraMentions = $extraMentions;
        $this->vehicleUID = $vehicleUID;
        $this->used = $used;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function use()
    {
        try {
            if ($this->used) {
                throw new Exception("Ticket from " . $this->source . " to " . $this->destination . " has already been used.");
            }
            $this->used = true;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function isUsed()
    {
        return $this->used;
    }

    public function __toString()
    {
        try {
            $text = 'Take the ';
            if ($this->vehicleUID) {
                $text .= $this->vehicleUID . ' ';
            }
            switch ($this->type) {
                case TicketType::Bus:
                    $text .= 'bus ';
                    break;
                case TicketType::Boat:
                    $text .= 'boat ';
                    break;
                case TicketType::Airplane:
                    $text .= 'airplane ';
                    break;
                case TicketType::Train:
                    $text .= 'train ';
                    break;
            }


            $text .= 'from ' . $this->source . ' to '. $this->destination;

            if($this->extraMentions){
                $text .= ' Extra Mentions: '. $this->extraMentions;
            }
            return (string) $text . PHP_EOL;
        } catch (Exception $exception) {
            return '';
        }
    }
}
