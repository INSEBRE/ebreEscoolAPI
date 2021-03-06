<?php

namespace App\Transformers;

abstract class Transformer
{
    public function transformCollection($items)
    {
        return array_map([$this, 'transform'],
            $items->toArray()
        );
    }

    abstract public function transform($item);
}
