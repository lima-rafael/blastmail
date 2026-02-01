<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignsStoreRequest;
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

    public function store(CampaignsStoreRequest $request, ?string $tab = null)
    {
        $data = $request->getData();
        $toRoute = $request->getToRoute();

        if($tab == 'schedule'){
            // dd($data);
            Campaigns::create($data);
        }
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
