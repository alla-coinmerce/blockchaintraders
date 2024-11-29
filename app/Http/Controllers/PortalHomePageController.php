<?php

namespace App\Http\Controllers;

use App\Dtos\Fund as FundDto;
use App\Dtos\Participation as ParticipationDto;
use App\Dtos\ParticipationGroup;
use App\Dtos\UserWithParticipationData;
use App\Models\Fund;
use App\Models\FundValue;
use App\Models\KnowledgeBaseNewsArticle;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PortalHomePageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /**@var \App\Models\User */
        $user = Auth::user();
        $userIsParticipant = $user->isParticipant();
        $userIsKnowledgeBaseSubscriber = $user->isKnowledgeBaseSubscriber();

        // Switch: Has portfolio and subscribed?
        if(($userIsParticipant && $userIsKnowledgeBaseSubscriber) ||
            $user->isAdmin())
        {
            if($request->has('choice'))
            {
                if($request->get('choice') === 'portfolio')
                {
                    $request->session()->put('choice', 'portfolio');
                }
                elseif($request->get('choice') === 'knowledge_base')
                {
                    $request->session()->put('choice', 'knowledge_base');
                }
            }

            $choice = $request->session()->get('choice', '');

            // Choice made?
            if($choice === 'portfolio')
            {
                return $this->showPortfolio();
            }
            elseif($choice === 'knowledge_base')
            {
                return $this->showKnowledgeBase();
            }
            else
            {
                // Show choices
                return view('portal.knowledgebase.start', [
                    'user' => $user
                ]);
            }
        }
        // Has portfolio?
        elseif($userIsParticipant)
        {
            return $this->showPortfolio();
        }
        // Is subscribed to knowledge base?
        elseif($userIsKnowledgeBaseSubscriber)
        {
            return $this->showKnowledgeBase();
        }
        else
        {
            // Not authorized
            abort(403);
        }
    }

    private function showKnowledgeBase()
    {
        /**@var \App\Models\User */
        $user = Auth::user();

        $articles = KnowledgeBaseNewsArticle::orderBy('publication_date', 'DESC')
        ->orderBY('created_at', 'DESC')
        ->where('published', true)
        ->take(4)
        ->get();

        return view('portal.knowledgebase.knowledge-base', [
            'user' => $user,
            'articles' => $articles
        ]);
    }

    private function showPortfolio()
    {
        // DB::enableQueryLog();

        $user_id = Auth::id();

        $user = User::where('id', $user_id)
            ->with(['annualfinancialoverviews' => function($query) {
                $query->orderBy('year', 'DESC');
            }])
            ->with(['funds' => function($query) {
                $query->orderBy('name', 'ASC');
            }])
            ->first();

        // $query_dump = DB::getQueryLog();
        // dd($query_dump);

        $fundIds = $user->funds->pluck('id')->toArray();

        $multifundParticipant = count($fundIds) > 1 ? true : false;

        $funds = Fund::whereIn('id', $fundIds)
            ->with('factsheets')
            ->with(['fundvalues' => function($query) {
                $query->orderBy('date', 'DESC');
            }])
            ->get();

        $participations = Participation::join('tags', 'tags.id', '=', 'participations.tag_id')
            ->select('participations.*', 'tags.name as tag')
            ->orderBy('fund_id', 'ASC')
            ->orderBy('tags.name', 'ASC')
            ->orderBy('purchase_date', 'ASC')
            ->where('participant_id', $user_id)
            ->where('participant_type', User::class)
            ->get();

        // dd($user);
        // dd($fundIds);
        // dd($funds);
        // dd($participations);

        $participationDtosGroupedByFundAndTag = Array();
        $participationGroupsDtos = Array();
        $fundDtos = Array();

        $sequenceNumber = 1;
        $fund_id = 0;
        $tag = 'xyz';
        foreach($participations as $participation)
        {
            if($fund_id !== $participation->fund_id)
            {
                $fund_id = $participation->fund_id;
                $sequenceNumber = 1;
            }
            if($tag !== $participation->tag)
            {
                $tag = $participation->tag;
                $sequenceNumber = 1;
            }

            $fund = $funds->find($participation->fund_id);

            $participationDtosGroupedByFundAndTag[$participation->fund_id][$participation->tag][] = new ParticipationDto($participation, $sequenceNumber++, $fund);
        }

        foreach($participationDtosGroupedByFundAndTag as $fund_id => $participationDtosGroupedBydTag)
        {
            $participationGroupsDtos = Array();
           
            foreach($participationDtosGroupedBydTag as $tag => $participationGroupDtos)
            {
                $participationGroupsDtos[] = new ParticipationGroup($tag, $participationGroupDtos);
            }

            $fund = $funds->find($fund_id);

            $fundDtos[] = new FundDto($fund, $participationGroupsDtos);
        }

        $userDto = new UserWithParticipationData($user, $fundDtos);

        // $query_dump = DB::getQueryLog();
        // dd($query_dump);

        $latestFundValue = FundValue::whereIn('fund_id', $fundIds)
            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['06:50:00'])
            ->orderBy('date_time', 'DESC')
            ->first();

        $latestUpdate = '';
        if($latestFundValue)
        {
            $latestUpdate = Carbon::parse($latestFundValue->date_time)->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i');
        }

        return view('portal.home', [
            'user' => $userDto,
            'multifundParticipant' => $multifundParticipant,
            'latestUpdate' => $latestUpdate
        ]);
    }
}
