<?php 

namespace App\Models;
use CodeIgniter\Model;

class OfficeModel extends Model
{

    protected $table = 't_office';
    protected $primaryKey = 'id_office';
    
    protected $allowedFields = ['id_office', 'rif', 'nomb', 'ubic', 'esta', 'SALSTERR', 'SLPRSNID', 
        'PRSTADCD',  'CUSTNAME',  'nume_tien', 'INI_FACT_GP', 'DOCID', 'PRCLEVEL', 'UOFM', 'CURNCYID', 
        'CREATETAXES', 'DEFTAXSCHDS', 'DEFPRICING'];
}
?>