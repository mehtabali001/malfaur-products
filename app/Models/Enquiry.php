<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'product_category',
        'subject',
        'message',
        'status',
        'admin_notes'
    ];

    /**
     * Virtual product name attribute with fallback to subject parsing.
     */
    public function getProductNameAttribute()
    {
        if (!empty($this->attributes['product_name'])) {
            return $this->attributes['product_name'];
        }
        if (!empty($this->subject)) {
            if (str_starts_with($this->subject, 'Quote Request:')) {
                return trim(substr($this->subject, 14));
            }
            if (str_starts_with($this->subject, 'Technical Inquiry:')) {
                return trim(substr($this->subject, 18));
            }
            if (str_starts_with($this->subject, 'Product Enquiry:')) {
                return trim(substr($this->subject, 16));
            }
        }
        return null;
    }

    /**
     * Scope for unread / new enquiries.
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope for recent enquiries.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get badge color class based on status.
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'new' => 'badge-emerald',
            'in_progress' => 'badge-amber',
            'replied' => 'badge-blue',
            'archived' => 'badge-slate',
            default => 'badge-slate'
        };
    }
}
