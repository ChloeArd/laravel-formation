<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // autoriser une personne a inserer un nouvel article
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() // se sont les regles de validation
    {
        return [
            'title' => $this->method() == "POST" ?
            ['required', 'max:20', 'unique:articles,title'] :
            ['required', 'max:20', Rule::unique('articles', 'title')->ignore($this->article)], // Ignore l'article pour qu'on puisse modifier et changer ce qui est unique sur cet article
            'content' => ['required'],
            'category' => ['sometimes', 'nullable', 'exists:categories,id']
        ];
    }


    // Change le nom du champ titre par exemple lors d'une erreur "Le champ super titre est obligatoire."
//    public function attributes()
//    {
//        return [
//            'title' => 'Le super titre'
//        ];
//    }
    // Customiser les messages d'erreur
//    public function messages()
//    {
//        return[
//            'title.required' => "Et le titre ?",
//            'content.required' => "T'as pas oublié un truc ?"
//        ]
//    }
}
