<?php
/**
 * Created by PhpStorm.
 * User: pdavila
 * Date: 30/05/16
 * Time: 12:10
 */

namespace App\Http\Requests;


class PeopleStoreRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'givenName' => 'required|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}