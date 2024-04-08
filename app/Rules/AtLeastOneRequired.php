<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastOneRequired implements Rule
{
    private $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function passes($attribute, $value)
    {
        $pixKeyFilled = !empty(request('pixKey'));
        $allThreeFilled = !empty(request('cardNumber')) && !empty(request('printedName')) && !empty(request('date'));

        return $pixKeyFilled || $allThreeFilled;
    }

    public function message()
    {
        return 'Either the Pix Key or all three of the specified fields are required.';
    }
}
