<?php

class Episode extends Eloquent
{
	public function title()
    {
       return $this->belongsTo('Title');
    }

    public function season()
    {
       return $this->belongsTo('Season');
    }
}