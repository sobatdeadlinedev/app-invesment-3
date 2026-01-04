<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'identity_number',
        'identity_type',
        'identity_photo_path',
        'selfie_with_identity_path',
        'submitted_at',
        'verified_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check apakah verifikasi basic sudah lengkap
     */
    public function isBasicComplete(): bool
    {
        return !empty($this->full_name) &&
            !empty($this->identity_number) &&
            !empty($this->identity_type) &&
            !empty($this->identity_photo_path) &&
            !empty($this->selfie_with_identity_path);
    }

    /**
     * Check apakah verifikasi advanced sudah lengkap
     * Advanced hanya butuh 2 foto
     */
    public function isAdvancedComplete(): bool
    {
        return !empty($this->identity_photo_path) &&
            !empty($this->selfie_with_identity_path);
    }

    /**
     * Check apakah sudah diverifikasi
     */
    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    /**
     * Check apakah sudah disubmit
     */
    public function isSubmitted(): bool
    {
        return !is_null($this->submitted_at);
    }

    /**
     * Get URL foto identitas
     * Langsung return path karena sudah disimpan sebagai full URL
     */
    public function getIdentityPhotoUrlAttribute(): ?string
    {
        return $this->identity_photo_path;
    }

    /**
     * Get URL foto selfie dengan identitas
     * Langsung return path karena sudah disimpan sebagai full URL
     */
    public function getSelfieWithIdentityUrlAttribute(): ?string
    {
        return $this->selfie_with_identity_path;
    }

    /**
     * Mark sebagai submitted
     */
    public function markAsSubmitted(): void
    {
        $this->update(['submitted_at' => now()]);
    }

    /**
     * Mark sebagai verified
     */
    public function markAsVerified(): void
    {
        $this->update(['verified_at' => now()]);
    }

    /**
     * Scope untuk filter yang sudah submit
     */
    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_at');
    }

    /**
     * Scope untuk filter yang sudah verified
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    /**
     * Scope untuk filter yang belum verified
     */
    public function scopeUnverified($query)
    {
        return $query->whereNull('verified_at');
    }

    /**
     * Scope untuk filter yang pending (sudah submit tapi belum verified)
     */
    public function scopePending($query)
    {
        return $query->whereNotNull('submitted_at')
            ->whereNull('verified_at');
    }
}
