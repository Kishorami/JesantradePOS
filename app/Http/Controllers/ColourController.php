<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

class ColourController extends Controller
{
	public function index()
	{
		$coloursinfo = DB::table('colours')
                        ->where('id',1)
                        ->first();
        $navC = $coloursinfo->nav_code;
        $sideC = $coloursinfo->colour_code;
		return view('colours',compact('navC','sideC'));
	}

	public function SideColour(Request $request)
	{
		$coloursinfo = DB::table('colours')
                        ->where('id',1)
                        ->first();

        $colour ="#343a40";
        if (!empty($request->sidecolour)) {
        	$colour =$request->sidecolour;
        }

		$data = array();
    	$data['colour_code'] = $colour;
    	$data['nav_code'] = $coloursinfo->nav_code;
    	

		$side = DB::table('colours')->where('id',1)->update($data);
		// if ($side) {
		// 	return redirect()->route('colours');
		// }
		$navC = $coloursinfo->nav_code;
        $sideC = $coloursinfo->colour_code;
		return view('colours',compact('navC','sideC'));
	}

	public function NavColour(Request $request)
	{
		$coloursinfo = DB::table('colours')
                        ->where('id',1)
                        ->first();

		$colour ="#f4f6f9";
        if (!empty($request->navcolour)) {
        	$colour =$request->navcolour;
        }

		$data = array();
    	$data['colour_code'] = $coloursinfo->colour_code;
    	$data['nav_code'] = $colour;
    	

		$side = DB::table('colours')->where('id',1)->update($data);
		// if ($side) {
		// 	return redirect()->route('colours');
		// }
		$navC = $coloursinfo->nav_code;
        $sideC = $coloursinfo->colour_code;
		return view('colours',compact('navC','sideC'));
	}
    
}
