<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policy;

class PolicyController extends Controller
{

    public function index($type)
    {

        $policy = Policy::where('name', $type)->first();
        if(empty($policy)){
            $policy=new Policy();
            $policy->name=$type;
            $policy->save();
        }
        return view('policies.index', compact('policy'));
    }

    //updates the policy pages
    public function store(Request $request){
        $policy = Policy::where('name', $request->name)->first();
        $policy->name = $request->name;
        $policy->content = $request->content;
        $policy->save();

        flash($request->name.' updated successfully');
        return back();
    }
}
