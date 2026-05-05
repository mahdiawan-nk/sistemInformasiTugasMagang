<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'point',
        'deadline_post',
        'deadline_taken',
        'user_id',
        'submission_file',
        'submission_date',
        'final_point',
        'evaluation_notes',
        'status',
    ];

    /**
     * Casting biar otomatis ke tipe yang benar
     */
    protected $casts = [
        'deadline_post' => 'date',
        'deadline_taken' => 'date',
        'submission_date' => 'date',
        'point' => 'integer',
        'final_point' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Mahasiswa yang mengambil task
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (biar query clean & reusable)
    |--------------------------------------------------------------------------
    */

    public function scopeAvailable(Builder $query)
    {
        return $query->where('status', 'available');
    }

    public function scopeInProgress(Builder $query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeSubmitted(Builder $query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeDone(Builder $query)
    {
        return $query->where('status', 'done');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR (helper untuk UI)
    |--------------------------------------------------------------------------
    */

    public function getIsOverdueAttribute(): bool
    {
        if ($this->deadline_taken && $this->status === 'in_progress') {
            return now()->greaterThan($this->deadline_taken);
        }

        return false;
    }

    public function getRemainingDaysAttribute(): ?int
    {
        if (!$this->deadline_taken)
            return null;

        return now()->diffInDays($this->deadline_taken, false);
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC (clean & reusable)
    |--------------------------------------------------------------------------
    */

    // Mahasiswa ambil task
    public function claimBy(User $user): void
    {
        if ($this->status !== 'available') {
            throw new \Exception('Task tidak tersedia');
        }

        $this->update([
            'user_id' => $user->id,
            'status' => 'in_progress',
            'deadline_taken' => now()->addDays(7),
        ]);
    }

    // Submit task
    public function submit(string $filePath): void
    {
        if ($this->status !== 'in_progress') {
            throw new \Exception('Task belum dalam progress');
        }

        $this->update([
            'submission_file' => $filePath,
            'submission_date' => now(),
            'status' => 'submitted',
        ]);
    }

    // Evaluasi oleh pembimbing
    public function evaluate(int $finalPoint, ?string $notes = null): void
    {
        if ($this->status !== 'submitted') {
            throw new \Exception('Task belum disubmit');
        }

        $this->update([
            'final_point' => $finalPoint,
            'evaluation_notes' => $notes,
            'status' => 'done',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER STATUS LABEL (optional untuk UI)
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'in_progress' => 'Dikerjakan',
            'submitted' => 'Menunggu Review',
            'done' => 'Selesai',
            default => '-',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'available' => 'gray',
            'in_progress' => 'blue',
            'submitted' => 'yellow',
            'done' => 'green',
            default => 'gray',
        };
    }
}