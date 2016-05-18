<?php

namespace App\Transformers;

class UserTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'        => $item['id'],
            'username'  => $item['username'],
            'email'     => $item['email'],
        ];
    }
}