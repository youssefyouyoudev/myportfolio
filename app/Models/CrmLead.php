<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CrmLead extends Model
{
    use HasFactory;

    public const REVIEW_PENDING = 'pending';
    public const REVIEW_APPROVED = 'approved';
    public const REVIEW_REJECTED = 'rejected';

    public const STATUS_NEW = 'new';
    public const STATUS_HOT = 'hot';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_INTERESTED = 'interested';
    public const STATUS_PROPOSAL_SENT = 'proposal_sent';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_REJECTED = 'rejected';

    protected $table = 'crm_leads';

    protected $fillable = [
        'business_name',
        'category',
        'city',
        'phone',
        'email',
        'website',
        'source',
        'source_type',
        'external_id',
        'notes',
        'status',
        'review_status',
        'online_presence_score',
        'online_presence_issues',
        'social_links',
        'pitch_payload',
        'source_data',
        'reply_count',
        'estimated_revenue',
        'found_at',
    ];

    protected $casts = [
        'online_presence_issues' => 'array',
        'social_links' => 'array',
        'pitch_payload' => 'array',
        'source_data' => 'array',
        'reply_count' => 'integer',
        'estimated_revenue' => 'decimal:2',
        'found_at' => 'datetime',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_HOT => 'Hot',
            self::STATUS_CONTACTED => 'Contacted',
            self::STATUS_INTERESTED => 'Interested',
            self::STATUS_PROPOSAL_SENT => 'Proposal Sent',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    public static function reviewStatuses(): array
    {
        return [
            self::REVIEW_PENDING => 'Pending Review',
            self::REVIEW_APPROVED => 'Approved',
            self::REVIEW_REJECTED => 'Rejected',
        ];
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! filled($term)) {
            return $query;
        }

        return $query->where(function ($query) use ($term): void {
            $query
                ->where('business_name', 'like', '%'.$term.'%')
                ->orWhere('category', 'like', '%'.$term.'%')
                ->orWhere('city', 'like', '%'.$term.'%')
                ->orWhere('phone', 'like', '%'.$term.'%')
                ->orWhere('email', 'like', '%'.$term.'%')
                ->orWhere('website', 'like', '%'.$term.'%')
                ->orWhere('source', 'like', '%'.$term.'%')
                ->orWhere('notes', 'like', '%'.$term.'%');
        });
    }

    public function scopeStatus($query, ?string $status)
    {
        if (filled($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function scopeReviewStatus($query, ?string $reviewStatus)
    {
        if (filled($reviewStatus)) {
            $query->where('review_status', $reviewStatus);
        }

        return $query;
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? Str::headline((string) $this->status);
    }

    public function statusTone(): string
    {
        return match ($this->status) {
            self::STATUS_HOT => 'is-danger',
            self::STATUS_CONTACTED, self::STATUS_INTERESTED, self::STATUS_PROPOSAL_SENT => 'is-warm',
            self::STATUS_CLOSED => 'is-success',
            self::STATUS_REJECTED => 'is-muted',
            default => '',
        };
    }

    public function reviewLabel(): string
    {
        return self::reviewStatuses()[$this->review_status] ?? Str::headline((string) $this->review_status);
    }

    public function reviewTone(): string
    {
        return match ($this->review_status) {
            self::REVIEW_PENDING => 'is-warm',
            self::REVIEW_REJECTED => 'is-muted',
            default => 'is-success',
        };
    }

    public function whatsappUrl(): ?string
    {
        $phone = preg_replace('/\D+/', '', (string) $this->phone);

        if ($phone === '') {
            return null;
        }

        return 'https://wa.me/'.$phone.'?text='.rawurlencode($this->outreachMessage());
    }

    public function outreachMessage(): string
    {
        return "Hello {$this->business_name}, I help businesses build premium websites, dashboards, SaaS platforms, and custom systems. If you're open to it, I'd be happy to share a few ideas that could improve your digital presence.";
    }

    public function issues(): array
    {
        return collect($this->online_presence_issues ?? [])->map(fn ($issue) => (string) $issue)->filter()->values()->all();
    }

    public function pitches(): array
    {
        return $this->pitch_payload ?? [];
    }

    public function sourceLabel(): string
    {
        return match ($this->source_type) {
            'lead_finder' => 'AI Lead Finder',
            'manual' => 'Manual CRM',
            default => Str::headline((string) ($this->source_type ?: $this->source ?: 'crm')),
        };
    }
}
