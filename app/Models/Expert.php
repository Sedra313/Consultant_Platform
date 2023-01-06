<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Expert extends Authenticatable
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

        'category_id',
        'profile_image',
        'phone',
        'address',
        'workspace_name',
        'years_of_experience',
        'specialization',
        'description',
        'rating'

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
    ];
    public function categories()
    {
        return $this->belongsTo(Category::class);

    }

      public function business_times()
    {
        return $this->hasMany(BusinessTime::class);

    }
}


// public function transactions()
// {
//     return $this->hasMany(ExpertWallet::class);
// }

// public function validTransactions()
// {
//     return $this->transactions()->where('status', 1);
// }

// public function credit()
// {
//     return $this->validTransactions()
//                 ->where('type', 'credit')
//                 ->sum('amount');
// }
// public function debit()
// {
//     return $this->validTransactions()
//                 ->where('type', 'debit')
//                 ->sum('amount');
// }
// public function balance()
// {
//     return $this->credit() - $this->debit();
// }
// public function allowWithdraw($amount) : bool
// {
//     return $this->balance() >= $amount;
// }
// }    
// }