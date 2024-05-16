<?php


namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Image\ImageRepositoryInterface;

class UserEloquentRepository implements UserRepositoryInterface
{
    private $imageRepository;
    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function getAll($params)
    {
        if(isset($params['email']))
            return User::where('email', $params['email'])->get();

        return User::orderBy('id', 'desc')->get();
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function update($data, $id)
    {
        $user = $this->getById($id);
        if(isset($data['profile_picture_changed']) && $data['profile_picture_changed'] == true)
        {
            $this->imageRepository->deleteData($user->profile_picture_id);
        }

        if(isset($data['profile_picture']))
        {
            $image = $this->imageRepository->createData($data['profile_picture'], 'users/'.$id);
            $data['profile_picture_id'] = $image->id;
        }

        return $user->update($data);
    }

    public function delete($id)
    {
        $user = $this->getById($id);
        return $user->delete();
    }
}