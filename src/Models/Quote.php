<?php

namespace Grkztd\MfCloud\Models;

use Grkztd\MfCloud\Models\Base;

class Quote extends Base{
    protected $fields = [
        'quote_number', 'title', 'partner_name', 'partner_detail', 'office_name', 'office_detail', 'subtotal', 'subtotal_of_untaxable_excise', 
        'subtotal_of_non_taxable_excise', 'subtotal_of_tax_exemption_excise', 'subtotal_of_five_percent_excise', 'subtotal_of_eight_percent_excise', 
        'subtotal_of_eight_percent_as_reduced_tax_rate_excise', 'subtotal_of_ten_percent_excise', 'total_price', 'excise_price', 'excise_price_of_five_percent', 
        'excise_price_of_eight_percent', 'excise_price_of_eight_percent_as_reduced_tax_rate', 'excise_price_of_ten_percent', 'note', 'memo', 'quote_date', 
        'expired_date', 'created_at', 'updated_at', 'operator_id', 'partner_id', 'department_id', 'member_id', 'member_name', 'document_name', 
        'partner_name_suffix', 'tags', 'pdf_url', 'is_locked', 'is_downloaded', 'order_status', 'transmit_status', 'posting_status'
    ];
    protected $relationFields = [
        'items',
    ];
}
