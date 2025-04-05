<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Models;

use Illuminate\Support\Facades\DB;

class Partner extends BaseModel {
    protected $table = 'mf_partners';

    /**
     *
     */
    public static function insert(array $attributes) {
        DB::beginTransaction(); // トランザクション開始
        try {
            $departments = $attributes['departments'];
            $attributes = self::fit($attributes, [
                'id' => 'partner_id',
                'departments' => null
            ]);
            $partner = self::updateOrCreate([
                'partner_id' => $attributes['partner_id']
            ], $attributes);
            // 削除されたitemsの削除
            $insertedDepartments = Department::where('partner_id', $attributes['partner_id'])->get();
            foreach ($insertedDepartments as $insertedDepartment) {
                // Itemのfit前なので'id'で検索する。
                if (!in_array($insertedDepartment->department_id, array_column($departments, 'id'), true)) {
                    $insertedDepartment->delete();
                }
            }
            // itemsの挿入
            foreach ($departments as $department) {
                $department = self::fit($department, [
                    'id' => 'department_id'
                ]);
                $department['partner_id'] = $partner->partner_id;
                Department::updateOrCreate([
                    'department_id' => $department['department_id']
                ], $department);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack(); // エラーが発生したらロールバック
            throw $e; // エラーを再スローして呼び出し元で処理
        }
    }

    public function departments() {
        return $this->hasMany(Department::class, 'partner_id', 'partner_id');
    }
}
