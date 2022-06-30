<?php

namespace Fereron\CategoryTree\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Fereron\CategoryTree\MenuBuilder;

class MenuItemFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return resolve(MenuBuilder::class)->authorize(request()) ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return MenuBuilder::getRulesFromMenuLinkable($this->get('class'));
    }

    public function getValues()
    {
        $keys = ['enabled', 'value', 'menu_id'];
        foreach ($this->all() as $key => $value) {
            if (Str::startsWith($key, 'data->')) $keys[] = $key;
        }
        return $this->only($keys);
    }
}
