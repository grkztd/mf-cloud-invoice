<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Models;

class Billing extends Base {
    protected $fields = [
        'id', 'pdf_url', 'user_id', 'partner_id', 'department_id', 'partner_name',
        'partner_name_suffix', 'partner_detail', 'member_id', 'member_name',
        'office_name', 'office_detail', 'title', 'excise_price', 'deduct_price',
        'subtotal', 'memo', 'payment_condition', 'total_price', 'billing_date',
        'due_date', 'sales_date', 'created_at', 'updated_at', 'billing_number',
        'note', 'document_name', 'tags',
        'status'
    ];
    // protected $relationFields = [];
}
