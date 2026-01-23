<?php

namespace App\Http\Controllers;

use App\Models\Campaing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CampaingController extends Controller
{
    public function index()
    {
        
        $search = request()->get('search', null);
        $showTrash = request()->get('showTrash', false);

        return view('campaings.index', [
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
                ->appends(compact('search')),
            'search' => $search,
            'showTrash' => $showTrash
        ]);
    }
}
