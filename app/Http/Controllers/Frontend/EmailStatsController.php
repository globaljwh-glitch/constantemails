<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MailCampaign;
use App\Models\ContactCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmailStatsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | EMAIL HISTORY / STATISTICS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $userId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Contact Group Categories
        |--------------------------------------------------------------------------
        */

        $categories = ContactCategory::orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Campaign Query
        |--------------------------------------------------------------------------
        */

        $query = MailCampaign::query()
            ->where('mail_campaign.user_id', $userId)
            ->where('mail_campaign.campaign_status', 'completed');


        /*
        |--------------------------------------------------------------------------
        | CONTACT GROUP CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        $categoryId = $request->input('contact_cat');

        if (
            $categoryId &&
            $categoryId != '0'
        ) {

            $query->whereExists(function ($subQuery) use ($categoryId) {

                $subQuery->select(DB::raw(1))

                    ->from('campaign_group')

                    ->join(
                        'contact_groups',
                        'contact_groups.id',
                        '=',
                        'campaign_group.group_id'
                    )

                    ->whereColumn(
                        'campaign_group.campaign_id',
                        'mail_campaign.id'
                    )

                    ->where(
                        'contact_groups.category_id',
                        $categoryId
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | TRACKING EMAIL NAME
        |--------------------------------------------------------------------------
        */

        if ($request->filled('sub')) {

            $search = trim($request->input('sub'));

            $query->where(
                'mail_campaign.email_title',
                'like',
                '%' . $search . '%'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_picker')) {

            $dateRange = $request->input(
                'date_range',
                'after'
            );

            $date = $request->input('date_picker');

            try {

                $parsedDate = \Carbon\Carbon::parse($date)
                    ->startOfDay();

                if ($dateRange === 'before') {

                    $query->where(
                        'mail_campaign.schedule_date',
                        '<',
                        $parsedDate
                    );

                } elseif ($dateRange === 'after') {

                    $query->where(
                        'mail_campaign.schedule_date',
                        '>',
                        $parsedDate
                    );

                } elseif ($dateRange === 'between') {

                    /*
                    |--------------------------------------------------------------------------
                    | If only one date is supplied for "between",
                    | treat it as that complete day.
                    |--------------------------------------------------------------------------
                    */

                    $query->whereBetween(
                        'mail_campaign.schedule_date',
                        [
                            $parsedDate->copy()->startOfDay(),
                            $parsedDate->copy()->endOfDay(),
                        ]
                    );
                }

            } catch (\Throwable $e) {

                // Ignore invalid date input.
            }
        }


        /*
        |--------------------------------------------------------------------------
        | GET CAMPAIGNS
        |--------------------------------------------------------------------------
        */

        $campaigns = $query
            ->withCount('recipients')
            ->latest('mail_campaign.id')
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | ADD STATISTICS TO EACH CAMPAIGN
        |--------------------------------------------------------------------------
        */

        foreach ($campaigns as $campaign) {

            $campaign->stats = $this->getCampaignStats(
                $campaign->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECIPIENT COUNT FILTER
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('r_count') &&
            is_numeric($request->input('r_count'))
        ) {

            $rCount = (int) $request->input('r_count');

            $campaigns->setCollection(
                $campaigns->getCollection()->filter(
                    function ($campaign) use ($request, $rCount) {

                        $total = $campaign->stats->total_user ?? 0;

                        return match ($request->input('r_range')) {

                            'least' =>
                                $total >= $rCount,

                            'most' =>
                                $total <= $rCount,

                            'equal' =>
                                $total == $rCount,

                            default =>
                                true,
                        };
                    }
                )
            );
        }


        return view(
            'frontend.user.email-stats.index',
            compact(
                'campaigns',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW CAMPAIGN STATISTICS
    |--------------------------------------------------------------------------
    */

    public function show(MailCampaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $stats = $this->getCampaignStats(
            $campaign->id
        );


        return view(
            'frontend.user.email-stats.show',
            compact(
                'campaign',
                'stats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ITEMIZED REPORT
    |--------------------------------------------------------------------------
    */

    public function itemized(MailCampaign $campaign)
    {
        $this->authorizeCampaign($campaign);


        $recipients = DB::table('campaign_recipients')
            ->where('campaign_id', $campaign->id)
            ->orderBy('id')
            ->paginate(25);


        $stats = $this->getCampaignStats(
            $campaign->id
        );


        return view(
            'frontend.user.email-stats.itemized',
            compact(
                'campaign',
                'recipients',
                'stats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE SELECTED CAMPAIGNS
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request)
    {
        $request->validate([
            'campaign_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'campaign_ids.*' => [
                'integer',
            ],
        ]);


        $campaignIds = $request->input(
            'campaign_ids'
        );


        /*
        |--------------------------------------------------------------------------
        | Only allow current user's campaigns
        |--------------------------------------------------------------------------
        */

        MailCampaign::where('user_id', auth()->id())
            ->whereIn('id', $campaignIds)
            ->update([
                'campaign_status' => 'deleted',
            ]);


        return redirect()
            ->route('user.email-stats.index')
            ->with(
                'success',
                'Selected email history has been deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT CSV
    |--------------------------------------------------------------------------
    */

    public function export(Request $request): StreamedResponse
    {
        $userId = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | Build same campaign query as history
        |--------------------------------------------------------------------------
        */

        $query = MailCampaign::query()
            ->where('mail_campaign.user_id', $userId)
            ->where(
                'mail_campaign.campaign_status',
                'completed'
            );


        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('contact_cat') &&
            $request->contact_cat != '0'
        ) {

            $categoryId = $request->contact_cat;

            $query->whereExists(function ($subQuery) use ($categoryId) {

                $subQuery->select(DB::raw(1))

                    ->from('campaign_group')

                    ->join(
                        'contact_groups',
                        'contact_groups.id',
                        '=',
                        'campaign_group.group_id'
                    )

                    ->whereColumn(
                        'campaign_group.campaign_id',
                        'mail_campaign.id'
                    )

                    ->where(
                        'contact_groups.category_id',
                        $categoryId
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | TRACKING EMAIL NAME
        |--------------------------------------------------------------------------
        */

        if ($request->filled('sub')) {

            $query->where(
                'mail_campaign.email_title',
                'like',
                '%' . trim($request->sub) . '%'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_picker')) {

            try {

                $date = \Carbon\Carbon::parse(
                    $request->date_picker
                );

                if ($request->date_range === 'before') {

                    $query->where(
                        'mail_campaign.schedule_date',
                        '<',
                        $date->startOfDay()
                    );

                } elseif ($request->date_range === 'after') {

                    $query->where(
                        'mail_campaign.schedule_date',
                        '>',
                        $date->endOfDay()
                    );

                } elseif ($request->date_range === 'between') {

                    $query->whereBetween(
                        'mail_campaign.schedule_date',
                        [
                            $date->startOfDay(),
                            $date->endOfDay(),
                        ]
                    );
                }

            } catch (\Throwable $e) {
                // Ignore invalid date.
            }
        }


        $campaigns = $query
            ->latest('mail_campaign.id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CSV DOWNLOAD
        |--------------------------------------------------------------------------
        */

        $fileName =
            'email-history-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';


        return response()->streamDownload(
            function () use ($campaigns) {

                $handle = fopen(
                    'php://output',
                    'w'
                );


                /*
                |--------------------------------------------------------------------------
                | CSV HEADER
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [
                    'Tracking Email Name',
                    'Date',
                    'Recipients',
                    'Opened / Viewed',
                    'Clicked',
                    'Unsubscribed',
                    'Bounced',
                    'Forwarded',
                ]);


                /*
                |--------------------------------------------------------------------------
                | DATA
                |--------------------------------------------------------------------------
                */

                foreach ($campaigns as $campaign) {

                    $stats = $this->getCampaignStats(
                        $campaign->id
                    );


                    fputcsv($handle, [

                        $campaign->email_title,

                        $campaign->schedule_date
                            ? \Carbon\Carbon::parse(
                                $campaign->schedule_date
                            )->format('m/d/Y')
                            : '',

                        $stats->total_user ?? 0,

                        $stats->viewed_user ?? 0,

                        $stats->embed_link_click_status_user ?? 0,

                        $stats->unsubscribed_user ?? 0,

                        $stats->bounced_user ?? 0,

                        $stats->forword_to_friend_user ?? 0,
                    ]);
                }


                fclose($handle);
            },
            $fileName,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GET CAMPAIGN STATISTICS
    |--------------------------------------------------------------------------
    */

    private function getCampaignStats(int $campaignId)
    {
        return DB::table('campaign_recipients')
            ->where('campaign_id', $campaignId)
            ->selectRaw('
                COUNT(*) as total_user,

                SUM(
                    CASE
                        WHEN opened_at IS NOT NULL
                        THEN 1
                        ELSE 0
                    END
                ) as viewed_user,

                SUM(
                    CASE
                        WHEN clicked_at IS NOT NULL
                        THEN 1
                        ELSE 0
                    END
                ) as embed_link_click_status_user,

                SUM(
                    CASE
                        WHEN status = "unsubscribed"
                        THEN 1
                        ELSE 0
                    END
                ) as unsubscribed_user,

                SUM(
                    CASE
                        WHEN status = "bounced"
                        THEN 1
                        ELSE 0
                    END
                ) as bounced_user,

                SUM(
                    CASE
                        WHEN status = "forwarded"
                        THEN 1
                        ELSE 0
                    END
                ) as forword_to_friend_user
            ')
            ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | AUTHORIZE CAMPAIGN
    |--------------------------------------------------------------------------
    */

    private function authorizeCampaign(
        MailCampaign $campaign
    ): void {

        abort_if(
            $campaign->user_id !== auth()->id(),
            403
        );
    }
}