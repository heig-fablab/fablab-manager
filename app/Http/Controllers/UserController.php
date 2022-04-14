<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
  /*public function logout(Request $request)//Called when the user wants to disconnect
  {
    return redirect("shibboleth-logout");
  }//return : route to shibboleth logout handler

  public function updateSettings(Request $request)//Called when a user has changed some settings
  {//input : {fields : [{name : the name of the column (e.g "notify_email_status"), value : the new boolean value}]}
    $user = $request->user();
    $fields = $request->fields;
    foreach($fields as $field){
      $user[$field["name"]] = $field["value"];
    }
    $user->notify_email_updated_at = now();
    $user->save();
    
    return $user;
  }//return : the user*/
}
