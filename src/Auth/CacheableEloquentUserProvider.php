<?php
namespace HobbIoT\Auth;

use Illuminate\Auth\EloquentUserProvider;

class CacheableEloquentUserProvider extends EloquentUserProvider {

    /**
     * Retrieve a user by their unique identifier.
     *  - override -
     *  with using cache.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return cache()->remember($this->getModel() . '_By_Id_' . $identifier, 60,
            function() use ($identifier) {
                return $this->createModel()->newQuery()->find($identifier);
            }
        );
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *  - override -
     *  with using cache.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        return cache()->remember($this->getModel() . '_By_Id_Token_' . $identifier, 60,
            function() use ($model, $identifier, $token) {
                return $model->newQuery()
                                ->where($model->getAuthIdentifierName(), $identifier)
                                ->where($model->getRememberTokenName(), $token)
                                ->first();
            }
        );
    }

    // キャッシュクリア
    public static function clearCache($model)
    {
        cache()->forget(get_class($model) . '_By_Id_' . $model->id);
        cache()->forget(get_class($model) . '_By_Id_Token_' . $model->id);
    }

}
