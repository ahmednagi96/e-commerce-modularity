<?php 

namespace Modules\User\DTOs;

use App\Models\User;

readonly class UserDto
{
    public function  __construct(
        public int $userId,
        public string $name,
        public string $email,
    ){

    }

    /** @param User $user  */
    /** @return self */
    public static function fromEloguentModel(User $user):self
    {
        return new self($user->id,$user->name,$user->email);
    }
}
