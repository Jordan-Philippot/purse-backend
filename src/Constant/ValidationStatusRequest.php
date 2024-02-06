<?php

namespace App\Constant;

class ValidationStatusRequest
{
    // Status
    const PENDING = 'pending';
    const APPROVED =  'approved';
    const REJECTED =  'rejected';

    public static function list()
    {
        return [
            self::PENDING,
            self::APPROVED,
            self::REJECTED

        ];
    }
}
