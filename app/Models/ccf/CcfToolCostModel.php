<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfToolCostModel extends Model
{
    protected $table         = 'ccf_tool_cost';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'tool_cost_process',
        'tool_cost_tool',
        'tool_cost_spec',
        'tool_cost_qty'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
