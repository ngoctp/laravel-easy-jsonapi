# Laravel Easy JsonApi
This is an extended library for responding common API easily.

This package supports Laravel 5.0 and newer versions.

You can also use this package with Lumen. 

## Installation

Import package using composer:

```shell
composer require ngoctp/laravel-easy-jsonapi
```

### Usages

#### New options parameter for transformer

With new `options` parameter in constructor, you can respond more fields optionally in each action

```php
class UserTransformer extends ExtendedTransformerAbstract
{

    protected $name = 'user';

    protected $availableIncludes = [
        'roles',
    ];

    /**
     * @param User $user
     * @return array
     */
    public function transform($user)
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
        ];
        
        if (array_get($this->options, 'respond_birthday')) {
            $data['birthday'] = $user->birthday;
        }
        
        return $data;
    }

    public function includeRoles($user)
    {
        return new Collection($user->roles, new RoleTransformer(array_get($this->options, 'roles')), 'role');
    }
}

// Controller
class UserController extends Controller {
    public function index($request) {
        $users = \App\Models\User::get();
        
        return eja_data($users, new \App\Transformers\UserTransformer(
            [
                'respond_birthday' => true,
                'roles' => [
                    'respond_name' => false,
                ]
            ]
        ));
    }
}

```

#### Respond success message

```php
class UserController extends Controller {
    public function store($request) {
        // ...
        
        return eja_success('Created user successfully');
    }
}

```

#### Respond error message

```php
class UserController extends Controller {
    public function update($request) {
        $validUsername = false;
        
        if (!$validUsername) {
            return eja_error('Username is not valid');
        }
        
        return eja_success('Updated user successfully');
    }
}

```

#### Respond normal form error message

```php
class UserController extends Controller {
    public function update($request) {
        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            return eja_form_error($validator);
        }
        
        return eja_success('Updated user successfully');
    }
}

```

#### Respond data

```php
class UserController extends Controller {
    public function index($request) {
        $users = \App\Models\User::get();
        //$users = \App\Models\User::paginate(10);
        
        return eja_data($users, new \App\Transformers\UserTransformer());
    }
}

```

Happy coding :)
