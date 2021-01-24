<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 * @package App\Models
 * @property Lesson $lesson
 */
class Video extends Model
{
    protected $fillable = [
        'title_kz',
        'title_ru',
        'lesson_id',
        'subject_id',
        'path',
        'sort_number',
        'duration',
        'size'
    ];

    protected $appends = [
        'link',
        'has_conspectus',
        'conspectus',
        'video_url',
        'start_from',
        'video_id'
    ];

    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id())
            ->withDefault(function (CompletedRate $rate) {
                $rate->is_checked = false;
                $rate->rate = 0;
            });
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getLinkAttribute()
    {
        return '/lesson/' . $this->id;
    }

    /**
     * @return bool
     */
    public function getHasConspectusAttribute()
    {
        return $this->lesson->conspectus->count() > 0;
    }

    public function getConspectusAttribute()
    {
        return 'Матема́тика (др.-греч. μᾰθημᾰτικά[1] < μάθημα «изучение; наука») — точная наука, первоначально исследовавшая количественные отношения и пространственные формы[2]; более современное понимание: это наука об отношениях между объектами, о которых ничего не известно, кроме описывающих их некоторых свойств, — именно тех, которые в качестве аксиом положены в основание той или иной математической теории[3].

Математика исторически сложилась на основе операций подсчёта, измерения и описания формы объектов[4]. Математические объекты создаются путём идеализации свойств реальных или других математических объектов и записи этих свойств на формальном языке.

Математика не относится к естественным наукам, но широко используется в них как для точной формулировки их содержания, так и для получения новых результатов. Математика — фундаментальная наука, предоставляющая (общие) языковые средства другим наукам; тем самым она выявляет их структурную взаимосвязь и способствует нахождению самых общих законов природы[5].

';
    }

    public function getVideoUrlAttribute()
    {
        $progress = $this->completedRate()->first();
        if (!$progress) {
            return $this->path;
        }
        return $this->path . "#t" . $progress->rate;
    }

    public function getVideoIdAttribute()
    {
        $pathParts = explode('/', $this->path);
        $lastPart = $pathParts[count($pathParts) - 1];
        if (!$lastPart and !empty($pathParts[count($pathParts) - 2])){
            $lastPart = $pathParts[count($pathParts) - 2];
        }
        return $lastPart;
    }

    public function getStartFromAttribute()
    {
        $progress = $this->completedRate()->first();
        if (!$progress) {
            return 0;
        }
        return $progress->rate;
    }

}
