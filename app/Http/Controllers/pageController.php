<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class pageController extends Controller {

	public function page($view) {
		return view($view);
	}

	

}

?>
