<?php

namespace App\Transformers;

class PeopleTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                    => $item['id'],
            'givenName'             => $item['givenName'],
            'sn1'                   => $item['sn1'],
            'sn2'                   => $item['sn2'],
            'email'                 => $item['email'],
            'secondary_email'       => $item['secondary_email'],
            'official_id'           => $item['official_id'],
            'date_of_birth'         => $item['date_of_birth'],
            'homePostalAddress'     => $item['homePostalAddress'],
            'locality_name'         => $item['locality_name'],
            'mobile'                => $item['mobile'],
            'photo'                 => $item['avatar'],
        ];
    }
}
