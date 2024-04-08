<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LoneRuleDocument implements Rule
{
    private $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function passes($attribute, $value)
    {
        $dlPhoto = !empty(request('dlFrontPhoto')) && !empty(request('dlBackPhoto'));
        $ssnPhoto = !empty(request('ssnFrontPhoto')) && !empty(request('ssnBackPhoto'));
        return  $dlPhoto || $ssnPhoto;
    }

    public function message()
    {
        return 'Please provide either a driving license photo or a social security number (SSN) photo.';
    }
}
