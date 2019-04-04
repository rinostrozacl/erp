<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Familia;
use Illuminate\Http\Request;

/**
 * Class DashboardController.
 */
class ComboController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function getFamiliaByLinea($id)
    {
        $familias = Familia::where('linea_id',$id)->get();

        return $familias->toJson();
    }

}


