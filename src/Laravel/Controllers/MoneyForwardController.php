<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Controllers;

use Grkztd\MfCloud\Client;
use Grkztd\MfCloud\Initialization;
use Illuminate\Http\Request;

class MoneyForwardController extends Controller {
    /**
     * Undocumented function.
     */
    public function quotations(Request $request) {
        $query = $request->query();
        try {
            $token = (new Initialization())->access();
            $client = new Client($token);
            $quotations = $client->quotes()->pagination($query);
            $statuses = [
                'default' => '-',
                'received' => '受注',
                'not_received' => '未受注',
                'failure' => '失注',
            ];
            return view('mf::quotations', compact('quotations', 'statuses'));
        } catch (Exception $e) {
            return redirect()->away((new Initialization())->getNewTokenUrl());
        }
    }

    /**
     * Undocumented function.
     */
    public function partners(Request $request) {
        $query = $request->query();
        try {
            $token = (new Initialization())->access();
            $client = new Client($token);
            $partners = $client->partners()->pagination($query);
            return view('mf::partners', compact('partners'));
        } catch (Exception $e) {
            return redirect()->away((new Initialization())->getNewTokenUrl());
        }
    }

    /**
     * Undocumented function.
     */
    public function billings(Request $request) {
        $query = $request->query();
        try {
            $token = (new Initialization())->access();
            $client = new Client($token);
            $billings = $client->billings()->pagination($query);
            return view('mf::billings', compact('billings'));
        } catch (Exception $e) {
            return redirect()->away((new Initialization())->getNewTokenUrl());
        }
    }

    /**
     * Undocumented function.
     *
     * @param Request $request
     * @param [type] $kind
     */
    public function download(Request $request, $kind) {
        $path = $request->query('path');
        $filename = $request->query('filename');
        try {
            $token = (new Initialization())->access();
            $client = new Client($token);
            return $client->download('GET', $path, $filename);
        } catch (Exception $e) {
            return redirect()->away((new Initialization())->getNewTokenUrl());
        }
    }
}
