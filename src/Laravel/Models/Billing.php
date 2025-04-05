<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Models;

use Illuminate\Support\Facades\DB;

class Billing extends BaseModel {
    protected $table = 'mf_billings';

    /**
     *
     */
    public static function insert(array $attributes) {
        DB::beginTransaction(); // トランザクション開始
        try {
            $items = $attributes['items'];
            $tag_names = $attributes['tag_names'];
            $config = $attributes['config'];
            $attributes = array_merge(self::fit($attributes, [
                'id' => 'billing_id',
                'tag_names' => null,
                'config' => null,
                'items' => null
            ]), $config);
            $attributes['tag_names'] = json_encode($tag_names);
            $billing = self::updateOrCreate([
                'billing_id' => $attributes['billing_id']
            ], $attributes);
            // 削除されたitemsの削除
            $insertedItems = BillingItem::where('billing_id', $attributes['billing_id'])->get();
            foreach ($insertedItems as $insertedItem) {
                // Itemのfit前なので'id'で検索する。
                if (!in_array($insertedItem->item_id, array_column($items, 'id'), true)) {
                    $insertedItem->delete();
                }
            }
            // itemsの挿入
            foreach ($items as $item) {
                $item = self::fit($item, [
                    'id' => 'item_id'
                ]);
                $item['billing_id'] = $billing->billing_id;
                BillingItem::updateOrCreate([
                    'item_id' => $item['item_id']
                ], $item);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack(); // エラーが発生したらロールバック
            throw $e; // エラーを再スローして呼び出し元で処理
        }
    }

    public function items() {
        return $this->hasMany(BillingItem::class, 'billing_id', 'billing_id');
    }
}
