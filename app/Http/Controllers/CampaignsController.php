<?php

namespace App\Http\Controllers;

use App\Models\Campaing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function index()
    {
        
        $search = request()->get('search', null);
        $showTrash = request()->get('showTrash', false);

        return view('campaigns.index', [
            'campaings' => Campaing::query()
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
        return view('campaigns.create', [
            'tab' => $tab,
            'form' => match ($tab){
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config',
            }
        ]);
    }

    public function store(?string $tab = null)
    {
        if(blank($tab)){
            $data = request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
            ]);

            session()->put('campaign::create', $data);
            return to_route('campaigns.create', ['tab' => 'template']);
        }
    }

    public function destroy(Campaing $campaing)
    {
        $campaing->delete();
        return back()->with('message', __('Campaing deleted successfully'));
    }

    public function restore(Campaing $campaing)
    {
        $campaing->restore();
        return back()->with('message', __('Campaing restored successfully'));
    }
}
