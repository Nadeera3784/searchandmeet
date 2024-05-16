<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $leads = Lead::with('agent');

        if($request->has('date'))
        {
            $leads = $leads->whereDate('created_at', $request->get('date'));
//            dd($leads->get());
        }

        if($request->has('keyword'))
        {
            $leads = $leads->where('person_name', 'like',  '%'.$request->get('keyword').'%')
                            ->orWhere('email', 'like',  '%'.$request->get('keyword').'%')
                            ->orWhere('business_name', 'like',  '%'.$request->get('keyword').'%');
        }
//        dd($leads->get());
        $leads = $leads->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('agent.leads.index', get_defined_vars());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $lead)
    {
        return view('agent.leads.show', get_defined_vars());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lead)
    {
        if ($lead->delete()) {
            return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
        }

        return back()->with('error', 'Something went wrong!');
    }
}
