<?php

namespace Visanduma\NovaTwoFactor\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwoFa extends Model
{
    protected $table = 'nova_twofa';

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('nova-two-factor.user_model'));
    }

    public function getGoogle2faSecretAttribute()
    {
        $value = $this->attributes['google2fa_secret'];

        if ($value !== null && config('nova-two-factor.encrypt_google2fa_secrets')) {
            $value = Crypt::decrypt($value);
        }

        return $value;
    }

    public function setGoogle2faSecretAttribute($value)
    {
        if ($value !== null && config('nova-two-factor.encrypt_google2fa_secrets')) {
            $value = Crypt::encrypt($value);
        }

        $this->attributes['google2fa_secret'] = $value;
    }
}
