<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VisionData extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'vision_datas';

    protected $appends = [
        'file',
    ];

    public const FILE_TYPE_SELECT = [
        'image' => 'Image',
        'video' => 'Video',
    ];

    public const TRIAL_TYPE_SELECT = [
        'birth' => 'Childbirth',
        'ivas'  => 'IVAS',
    ];

    protected $dates = [
        'time_taken',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'trial_code',
        'name',
        'gravidity',
        'parity',
        'age',
        'trial_type',
        'time_taken',
        'file_type',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getTimeTakenAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setTimeTakenAttribute($value)
    {
        $this->attributes['time_taken'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file')->last();
    }
}
