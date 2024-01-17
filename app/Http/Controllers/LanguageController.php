<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Config;

class LanguageController extends Controller
{
	public function switchlang($locale)
	{	
		App::setLocale($locale);
		$locale = App::currentLocale();
        session()->put('locale', $locale);
        return Redirect::back();
	}
}


