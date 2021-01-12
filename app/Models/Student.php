<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name',
        'last_name',
        'area_id',
        'region_id',
        'school_id',
        'language_id',
        'user_id',
        'class_id',
    ];

    protected $casts = [
        'area_id' => 'integer',
        'region_id' => 'integer',
        'school_id' => 'integer',
        'language_id' => 'integer',
        'user_id' => 'integer',
        'class_id' => 'integer'
    ];

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function scopeByUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'class_id', 'class_id');
    }

    public function get_students($user_ids = null)
    {
        $students = User::whereHas("roles", function ($query) {
            $query->where("name", "student");
        });
        if (isset($user_ids)) {
            $students = $students->whereIn('id', $user_ids);
        }
        return $students->get();
    }

    public function get_items()
    {
        $areas = Area::all()->pluck('name_ru', 'id')->toArray();
        $classes = EducationLevel::all()->pluck('order_number', 'id')->toArray();
        $languages = Language::all()->pluck('name_ru', 'id')->toArray();
        $subscriptions = Subscription::where(['is_active' => true])->get()->pluck('name', 'id');
        sort($classes);

        $regions = Region::all()->pluck('name_ru', 'id')->toArray();
        $schools = School::all()->pluck('name_ru', 'id')->toArray();

        $result = [
            'areas' => $areas,
            'classes' => $classes,
            'languages' => $languages,
            'subscriptions' => $subscriptions,
            'regions' => $regions,
            'schools' => $schools,
        ];
        return $result;
    }

    public function get_temp_filter_items($request)
    {
        $areas = !empty($request->input('area')) ? explode(',', $request->input('area')) : [];
        $regions = !empty($request->input('region')) ? explode(',', $request->input('region')) : [];
        $schools = !empty($request->input('school')) ? explode(',', $request->input('school')) : [];
        $classes = !empty($request->input('class')) ? explode(',', $request->input('class')) : [];
        $languages = !empty($request->input('language')) ? explode(',', $request->input('language')) : [];

        return [
            'areas' => $areas,
            'regions' => $regions,
            'schools' => $schools,
            'classes' => $classes,
            'languages' => $languages,
        ];
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $new_user = [
                'name' => $request['first_name'],
                'password' => Hash::make('Amin'),
                'email' => $request['email'],
                'is_active' => true,
                'balance' => 0,
                'phone' => $request['phone'],
                'last_visit' => date('Y-m-d H:i:s'),
            ];
            $user = User::create($new_user);

            $user->assignRole('student');

            $new_student = $request;
            $new_student['user_id'] = $user->id;

            Student::create($new_student);
            DB::commit();

            return [
                'success' => true,
                'message' => '',
            ];

        } catch (\Exception $exception) {
            DB::rollBack();

            $message = sprintf('%s, %s, %s', $exception->getMessage(), $exception->getFile(), $exception->getLine());
            info($message);
            return [
                'success' => false,
                'message' => $message,
            ];
        }
    }


    public function modify(array $request)
    {
        try {
            DB::beginTransaction();

            $new_user = [
                'name' => $request['first_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
            ];

            $user = User::find($request['user_id']);
            $user->fill($request);
            $user->save();

            $student = Student::where(['user_id' => $request['user_id']])->first();
            $student->fill($request);
            $student->save();

            DB::commit();

            return [
                'success' => true,
                'message' => '',
            ];

        } catch (\Exception $exception) {
            DB::rollBack();

            $message = sprintf('%s, %s, %s', $exception->getMessage(), $exception->getFile(), $exception->getLine());
            info($message);
            return [
                'success' => false,
                'message' => $message,
            ];
        }
    }

    public function password_change($request)
    {
        try {
            DB::table('users')
                ->where(['id' => $request->user_id])
                ->update([
                    'password' => Hash::make($request->password),
                ]);
        } catch (\Exception $exception) {
            $message = sprintf('%s %s %s', $exception->getFile(), $exception->getLine(), $exception->getMessage());
            info($message);
            return [
                'success' => false,
                'message' => $message
            ];
        }
        return [
            'success' => true,
            'message' => '',
        ];

    }

    public function add_subscription($request)
    {
        $result = UserSubscription::insert(
            [
                'user_id' => $request->user_id,
                'subscription_id' => $request->subscription_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'is_active' => true,
            ]
        );
        if ($result) {
            return [
                'success' => true,
                'message' => '',
            ];
        }
        return [
            'success' => false,
            'message' => 'Ошибка при добавление подписку',
        ];
    }

}
