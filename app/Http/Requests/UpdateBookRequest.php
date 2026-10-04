<?php 
 
namespace App\Http\Requests; 
 
use Illuminate\Foundation\Http\FormRequest; 
 
class UpdateBookRequest extends FormRequest 
{ 
    public function authorize(): bool 
    {
       return true; 
    } 
 
    public function rules(): array 
    { 
        return [ 
            'title' => ['required', 'string', 'max:255'], 
            'author' => ['required', 'string', 'max:150'], 
            'year' => ['required', 'integer', 'between:1900,2100'], 
        ]; 
    } 
} 