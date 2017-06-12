<?php

namespace common\forms;

/**
 * Interface to implement functions to check owner rights.
 */
interface BaseTicketInterface
{

    /**
     * All tickets models extended from BaseTicketForm needs to have a save method
     */
    public function save();

}