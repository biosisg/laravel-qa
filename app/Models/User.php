<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //, 'user_id', 'question_id');
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function getUrlAttribute()
    {
        return '#';
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;

    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();

        $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();

        $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote)
    {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationship->attach($model, ['vote' => $vote]);
        }

        $model->load('votes');
        $downVotes = (int)$model->downVotes()->sum('vote');
        $upVotes = (int)$model->upVotes()->sum('vote');
        $model->votes_count = $upVotes + $downVotes;
        $model->save();
    }

}
