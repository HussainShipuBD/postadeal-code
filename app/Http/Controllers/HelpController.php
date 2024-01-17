<?php


namespace App\Http\Controllers;


use App\Models\Help;
use Illuminate\Http\Request;


class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($helpId)
    {
            $helpdetail = Help::find($helpId);

        return view('helps.help',['helpdetail' => $helpdetail]);
    }


   

}


