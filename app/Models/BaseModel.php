<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class BaseModel extends Model
{
    protected static function booted()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->beforeSave($model);

            $errors = $model->errors;

            if (!empty($errors) && count($errors) > 0) {
                throw ValidationException::withMessages($errors->toArray());
            }

            $model->validate($model);

        });

        static::saved(function ($model) {
            $model->afterSave($model);
        });

        static::retrieved(function ($model) {
            $model->afterFind($model);
        });
    }

    public static function rules()
    {
        return [];
    }


    private function validate($model)
    {
        $validator = validator($model->attributes, $model::rules());

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    public function addError($attribute, $message)
    {
        $this->errors = new MessageBag($this->errors ?: []);
        $this->errors->add($attribute, $message);

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function beforeSave($model){}

    protected function afterFind($model){}

    protected function afterSave(){}
}
