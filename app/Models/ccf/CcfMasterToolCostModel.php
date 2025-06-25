<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfMasterToolCostModel extends Model
{
    protected $table         = 'ccf_master_tool_cost';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'tool_cost_process',
        'tool_cost_tool',
        'tool_cost_spec',
        'tool_cost_qty','jenis',
        'class',
        'jenis'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
