<?php

namespace Host2x\Support\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;
use XF\Util\Random;

class Ticket extends Repository
{
    public function randomTicketId($length = 8)
    {
        $string = strtoupper(Random::getRandomString($length+10));
        $string = str_replace(array('-', '_'), array('', ''), $string);

        if (strlen($string) < $length) {
            return $this->randomTicketId($length);
        }

        $string = substr($string, 0, $length);
        $existing = $this->em->findOne('Host2x\Support:Ticket', ['ticket_id' => $string]);
        if ($existing) {
            return $this->randomTicketId($length);
        }

        return $string;
    }
}