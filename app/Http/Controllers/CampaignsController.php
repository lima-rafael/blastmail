<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function index()
    {
        
        $search = request()->get('search', null);
        $showTrash = request()->get('showTrash', false);

        return view('campaigns.index', [
            'campaigns' => Campaigns::query()
                ->when($showTrash, fn(Builder $query) => $query->withTrashed())
                // ->when($showTrash, fn (Builder $query) => $query->onlyTrashed())
                ->when(
                    $search,
                    fn(Builder $query) => $query
                        ->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('id', '=', $search)
                )
                ->paginate(5)
                ->appends(compact('search', 'showTrash')),
            'search' => $search,
            'showTrash' => $showTrash
        ]);
    }

    public function create(?string $tab = null)
    {
        // session()->forget('campaign::create');
        return view('campaigns.create', [
            'tab' => $tab,
            'form' => match ($tab){
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config',
            },
            'data' => session()->get('campaigns::create', [
                'name' => null,
                'subject' => null,
                'email_list_id' => null,
                'template_id' => null,
                'body' => null,
                'track_open' => null,
                'track_click' => null,
                'send_at' => null,
            ])
        ]);
    }

    public function store(?string $tab = null)
    {
        $toRoute = '';
        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_open' => null,
            'track_click' => null,
            'send_at' => null,
        ], request()->all());
        
        if(blank($tab)){
            request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
            ]);
            $toRoute = route('campaigns.create', ['tab' => 'template']);
            }
            
        if($tab == 'template'){
            request()->validate(['body' => ['required']]);
            $toRoute = route('campaigns.create', ['tab' => 'schedule']);
        }

        if($tab == 'schedule'){
            request()->validate(['send_at' => ['required', 'date']]);
            $toRoute = route('campaigns.index');
        }

        // dd(session('campaigns::create'));

        $session = session('campaigns::create');
        foreach($session as $key => $value){
            $newValue = data_get($map, $key);
            if(filled($newValue)){
                $session[$key] = $newValue;
            }
        }

        session()->put('campaigns::create', $session);
        return response()->redirectTo($toRoute);
    }

    public function destroy(Campaigns $Campaigns)
    {
        $Campaigns->delete();
        return back()->with('message', __('Campaigns deleted successfully'));
    }

    public function restore(Campaigns $Campaigns)
    {
        $Campaigns->restore();
        return back()->with('message', __('Campaigns restored successfully'));
    }
}
