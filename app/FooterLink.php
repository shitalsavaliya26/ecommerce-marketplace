<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{

    public function cmsPage()
    {
        return $this->belongsTo(CmsPage::class)->where('status', 'active')->where('deleted_at', NULL);
    }
}
