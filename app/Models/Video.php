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
    protected $appends = [
        'link',
        'has_conspectus',
        'conspectus',
        'video_url'
    ];

    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id());
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
        if (!$progress){
            return $this->path;
        }
        return $this->path."#t".$progress->rate;
    }
}
