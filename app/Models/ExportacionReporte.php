<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportacionReporte extends Model
{
    protected $table = 'exportacion_reporte';
    protected $fillable = [
        'tipoExportacion',
        'filtros',
        'idGeneradoPor'
    ];

  }
