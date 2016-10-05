<?php

namespace App;


trait Tokenable
{
    public function token()
    {
        return $this->morphOne(Token::class, 'tokenable');
    }
}