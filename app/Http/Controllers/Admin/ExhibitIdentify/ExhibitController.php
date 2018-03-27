<?php

namespace App\Http\Controllers\Admin\ExhibitIdentify;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseAdminController;

class ExhibitController extends BaseAdminController
{
    public function apply(){
        return view('admin.exhibitidentify.apply');
    }
}
