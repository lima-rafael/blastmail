<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignShowRequest;
use App\Http\Requests\CampaignsStoreRequest;
use App\Jobs\SendEmailsCampaign;
use App\Mail\EmailCampaign;
use App\Models\Campaigns;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Traits\Conditionable;

use function PHPUnit\Framework\isNull;

class CampaignsController extends Controller
{
    use Conditionable;
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

    public function show(CampaignShowRequest $request, Campaigns $campaigns, ?string $what = null)
    {
        if($redirect = $request->checkWhat()){
            return $redirect;
        }

        $query = $campaigns
            ->mails()
            ->selectRaw("
                count(subscriber_id) as total_subscribers,
                sum(openings) as total_openings,
                count(case when openings > 0 then subscriber_id end) as unique_openings,
                round((cast(count(case when openings > 0 then subscriber_id end) as float) / cast(count(subscriber_id) as float)) * 100) as openings_rate,

                sum(clicks) as total_clicks,
                count(case when clicks > 0 then subscriber_id end) as unique_clicks,
                round((cast(count(case when clicks > 0 then subscriber_id end) as float) / cast(count(subscriber_id) as float)) * 100) as clicks_rate
            ")
            ->first();

        // dd($query->toArray());

        $search = request()->search;
        return view('campaigns.show', compact('campaigns', 'what', 'search', 'query'));
    }

    public function create(?string $tab = null)
    {
        // session()->forget('campaign::create');
        $data = session()->get('campaigns::create', [
                        'name' => null,
                        'subject' => null,
                        'email_list_id' => null,
                        'template_id' => null,
                        'body' => null,
                        'track_open' => null,
                        'track_click' => null,
                        'send_at' => null,
                        'send_when' => 'now',
                    ]);
        return view('campaigns.create', 
            array_merge(
                $this->when(blank($tab), fn() => [
                    'emailLists' => EmailList::query()->select(['id', 'title'])->orderBy('title')->get(),
                    'templates' => Template::query()->select(['id', 'name'])->orderBy('name')->get(),
                ], fn() => []),
                $this->when($tab == 'schedule', fn() => [
                    'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                    'template' => Template::find($data['template_id'])->name,
                ], fn() => []),
                [
                    'tab' => $tab,
                    'form' => match ($tab){
                        'template' => '_template',
                        'schedule' => '_schedule',
                        default => '_config',
                    },
                    'data' => $data
                ]
            ));
    }

    public function store(CampaignsStoreRequest $request, ?string $tab = null)
    {
        $data = $request->getData();
        $toRoute = $request->getToRoute();

        if($tab == 'schedule'){
            // dd($data);
            $campaigns = Campaigns::create($data);

             SendEmailsCampaign::dispatchAfterResponse($campaigns);
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
