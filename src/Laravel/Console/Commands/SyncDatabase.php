<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Console\Commands;

use Carbon\CarbonImmutable as Carbon;
use Grkztd\MfCloud\Client;
use Grkztd\MfCloud\Initialization;
use Grkztd\MfCloud\Laravel\Models\Billing as MfBilling;
use Grkztd\MfCloud\Laravel\Models\Partner as MfPartner;
use Grkztd\MfCloud\Laravel\Models\Quote as MfQuote;
use Illuminate\Console\Command;

class SyncDatabase extends Command {
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'mf-invoice:sync-database {kind?}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'MoneyForwardのデータをデータベースとSyncさせる';

    /**
     * Execute the console command.
     * @var string
     */
    public function handle() {
        $kind = $this->argument('kind') ?? 'none';
        //
        $token = (new Initialization())->access();
        $client = new Client($token);
        $from = Carbon::now()->subDays(2)->format('Y-m-d');
        $to = Carbon::now()->addDay(1)->format('Y-m-d');

        if ($kind === 'refresh') {
            echo "完全同期を実施します。\r\n";
            $conditions = [];
        } else {
            $conditions = ['range_key' => 'updated_at', 'from' => $from, 'to' => $to];
        }
        $this->syncQuotations($client, $conditions);  // 1分弱
        $this->syncBillings($client, $conditions);    // 2分弱
        $this->syncPartners($client);    // 5秒程度
    }

    /**
     * Undocumented function.
     */
    public function syncQuotations($client, $conditions = []) {
        $i = 1;
        while (true) {
            $quotations = $client->quotes()->all(array_merge(['per_page' => 100, 'page' => $i], $conditions));
            if (count($quotations) === 0) {
                break;
            }
            foreach ($quotations as $quotation) {
                MfQuote::insert($quotation->toArray());
            }
            $i++;
        }
    }

    /**
     * Undocumented function.
     */
    public function syncBillings($client, $conditions = []) {
        $i = 1;
        while (true) {
            $billings = $client->billings()->all(array_merge(['per_page' => 100, 'page' => $i], $conditions));
            if (count($billings) === 0) {
                break;
            }
            foreach ($billings as $billing) {
                MfBilling::insert($billing->toArray());
            }
            $i++;
        }
    }

    /**
     * Undocumented function.
     */
    public function syncPartners($client, $conditions = []) {
        $i = 1;
        while (true) {
            $partners = $client->partners()->all(array_merge(['per_page' => 100, 'page' => $i], $conditions));
            if (count($partners) === 0) {
                break;
            }
            foreach ($partners as $partner) {
                MfPartner::insert($partner->toArray());
            }
            $i++;
        }
    }
}
