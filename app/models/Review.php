<?php

class Review extends Eloquent
{
    protected $fillable = array('author', 'body', 'score');

    /**
     * Many to one association.
     * 
     * @return void
     */
    public function title()
    {
       return $this->belongsTo('Title');
    }

    /**
     * Returns recent reviews.
     * 
     * @param  Illuminate\Database\Eloquent\Builder $query 
     * @return collection
     */
    public function scopeRecent($query)
    {
      return $query->orderBy('created_at', 'desc')->limit(6)->get();
    }
 
}

