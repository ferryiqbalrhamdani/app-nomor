<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'jk',
        'is_password',
        'role_id',
        'pt_id',
        'status',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function generateUniqueUsername($firstName)
    {
        $username = Str::slug($firstName, '_'); // Mengonversi first_name menjadi slug
        $count = User::where('username', 'like', $username . '%')->count(); // Mengecek apakah username sudah ada

        if ($count > 0) {
            $username = $username . '_' . ($count + 1); // Menambahkan angka untuk membuatnya unik
        }

        return $username;
    }

    public function createUser($username, $firstName, $lastName, $jk, $roleId, $ptId)
    {
        return self::create([
            'username' => $username,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => Hash::make('user123'), // Default password
            'jk' => $jk,
            'role_id' => $roleId,
            'pt_id' => $ptId,
        ]);
    }

    public function updateUser($id, $firstName, $lastName, $jk, $roleId, $ptId, $status)
    {
        return self::where('id', $id)->update([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'jk' => $jk,
            'role_id' => $roleId,
            'pt_id' => $ptId,
            'status' => $status,
        ]);
    }

    public function deleteData($id)
    {
        return self::where('id', $id)->delete();
    }

    public function pt(): BelongsTo
    {
        return $this->belongsTo(ModelPT::class, 'pt_id', 'id');
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(ModelRole::class, 'role_id', 'id');
    }
}
