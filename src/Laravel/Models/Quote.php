<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Models;

use Illuminate\Support\Facades\DB;

class Quote extends BaseModel {
    protected $table = 'mf_quotes';

    /**
     * Undocumented function.
     *
     * @param array $attributes
     */
    public static function insert(array $attributes) {
        DB::beginTransaction(); // トランザクション開始
        try {
            $items = $attributes['items'];
            $attributes = self::fit($attributes, [
                'id' => 'quote_id',
                'items' => null
            ]);
            $quotation = self::updateOrCreate([
                'quote_id' => $attributes['quote_id']
            ], $attributes);
            // 削除されたitemsの削除
            $insertedItems = QuoteItem::where('quote_id', $attributes['quote_id'])->get();
            foreach ($insertedItems as $insertedItem) {
                // QuoteItemのfit前なので'id'で検索する。
                if (!in_array($insertedItem->item_id, array_column($items, 'id'), true)) {
                    $insertedItem->delete();
                }
            }
            // itemsの挿入
            foreach ($items as $item) {
                $item = self::fit($item, [
                    'id' => 'item_id'
                ]);
                $item['quote_id'] = $quotation->quote_id;
                QuoteItem::updateOrCreate([
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
        return $this->hasMany(QuoteItem::class, 'quote_id', 'quote_id');
    }
}
