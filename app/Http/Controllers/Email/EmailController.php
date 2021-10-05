<?php

namespace App\Http\Controllers\Email;
use App\Http\Controllers\Controller;

use App\Mail\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


use Auth;
use DB;
use URL;
use Redirect; 


class EmailController extends Controller
{

	public function envia_comprobante()
	{	
		//$xmail = mail::findOrFail("leo_bertolotti@yahoo.com.ar");
		 $xmail = "leo_bertolotti@yahoo.com.ar";
		 $xid = "1";
		 $xndoc = "25583697";
		 
		Mail::to($xmail)->send(new Reminder($xmail,$xid,$xndoc));


	}

}