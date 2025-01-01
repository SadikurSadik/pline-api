<?php

namespace App\Enums;

enum StreamShipLine: string
{
    case MAERSK = 'MAERSK';
    case MSC = 'MSC';
    case SAFMARINE = 'SAFMARINE';
    case OOCL = 'OOCL';
    case ONE = 'ONE';
    case EVERGREEN = 'EVERGREEN';
    case YANG_MING = 'YANG MING';
    case HMM = 'HMM';
    case PIL = 'PIL';
    case APL = 'APL';
    case APM_TERMINALS = 'APM TERMINALS';
    case CMA_CGM = 'CMA CGM';
    case COSCO = 'COSCO';
    case HAPAG_LLOYD = 'HAPAG LLOYD';
    case SEALAND = 'SEALAND';
    case MEDITERRANEAN = 'MEDITERRANEAN';
}
