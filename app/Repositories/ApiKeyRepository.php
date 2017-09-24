<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Chrisbjr\ApiGuard\Models\ApiKey;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;
use Sijot\User;

/**
 * Class ApiKeyRepository
 *
 * @package Sijot\Repositories
 */
class ApiKeyRepository extends Repository
{
    /**
     * The user variable for the user model.
     *
     * @var User
     */
    private $user;

    /**
     * ApiKeyRepository constructor.
     *
     * @param  App          $app            The Laravel application provider.
     * @param  Collection   $collection     The collection provider form the Eloquent ORM.
     * @param  User         $user           The user database model.
     * @return void
     */
    public function __construct(App $app, Collection $collection, User $user)
    {
        parent::__construct($app, $collection);
        $this->user = $user;
    }

    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return ApiKey::class;
    }

    /**
     * Create a new api key in the system.
     *
     * @param  string $serviceName The name for the API key
     * @return bool|mixed
     */
    public function createKey($serviceName)
    {
        if($dbKey = $this->model->make(auth()->user())) {
            if ($this->addServiceDescription($dbKey->id, $serviceName)) {
                return $dbKey->key; // Return the generated api key.
            }
        }

        return false; // The api key nor the serv ice description could be added in the DB.
    }

    /**
     * The add the service name to the api key.
     *
     * @param  integer $id          The primary key for the api key in the database.
     * @param  string  $serviceName The name of the service where the api key is needed for.
     * @return bool
     */
    private function addServiceDescription($id, $serviceName)
    {
        $key = $this->model->findOrFail($id);
        $key->service = $serviceName;

        if ($key->save()) { // Update = SUCCESS
            return true; // The service name has been added to the api key.
        }
        return false; // Could nod add the service name to the api key.
    }

    /**
     * Delete all the api keys for the given user.
     *
     * @param  mixed $user
     * @return void
     */
    public function deleteUserApiKeys($user)
    {
        $keys = $this->model->where('apikeyable_id', $user->id)->get();

        foreach($keys as $key) { // Loop through the keys
            $this->delete($key->id); // The key has been deleted.
        }
    }

    /**
     * Delete some api key in the system.
     *
     * @param  integer $keyId The primary key in the db for the api key.
     * @return mixed
     */
    public function deleteKey($keyId)
    {
        return $this->delete($keyId);
    }

    /**
     * Count all the keys in the database with the given id.
     *
     * @param  integer $keyId The primary key in the db for the api key.
     * @return int
     */
    public function keyExist($keyId)
    {
        return count($this->findAllBy('id', $keyId));
    }

    /**
     * Condition for checking is the user can delete the api key.
     *
     * @param  mixed   $user  The instance from the currently authenticated user.
     * @param  integer $keyId The primary key for the api key in the database.
     * @return bool
     */
    public function canDeleteApiKey($user, $keyId)
    {
        if ($this->keyExist($keyId) > 0) {
            // RETURN: Condition to check against.
            return $user->hasRole('admin') || $this->find($keyId)->apikeyable_id === $user->id;
        }

        return false; // The is no key found with the given id.
    }
}