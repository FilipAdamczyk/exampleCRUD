<?php

use \Messages\MessageHandler;
use \Errors\Errors;
use \View\BS;

class Controller_Users extends Controller_Template {

    /**
     * Listing all users
     */
    public function action_index(): void
    {
        $users = (new Model_User())
            ->with('address')
            ->find_all();

        $this->template->set('title', 'Home');

        $this->template->set(
            'content',
            View::factory('users/index')
                ->set('users', $users)
                ->set('message', MessageHandler::get())
        );
    }

    /**
     * Create user - form
     * @param Model_User $user
     * @param Model_Address $address
     * @param Errors $errors
     */
    public function action_create(
        Model_User $user = null,
        Model_Address $address = null,
        Errors $errors = null
    ): void
    {
        $user = $user ?? new Model_User();

        $address = $address ?? new Model_Address();

        $errors = $errors ?? new Errors([]);

        $this->template->set('title', 'Create User');

        $this->template->set(
            'content',
            View::factory('users/save')
                ->set('user', $user)
                ->set('address', $address)
                ->set('errors', $errors)
                ->set('action', 'createconfirm')
        );
    }

    /**
     * Create user
     * @throws HTTP_Exception
     */
    public function action_createconfirm(): void
    {
        $this->_handle_cancel();

        $user = $this->_populate_user_with_data(new Model_User());

        $address = $this->_populate_user_address_with_data(new Model_Address());

        try
        {
            $user->save();

            $address->user_id = $user->id;
            $address->save();

            MessageHandler::save(__('User created successfully.'));

            self::_redirect_home();
        }
        catch ( ORM_Validation_Exception $exception )
        {
            //Something went wrong, go back to the drawing board
            $this->_remove_the_user_and_repopulate_it($user);

            $this->action_create(
                $user,
                $address,
                new Errors($exception->errors('model'))
            );
        }
    }

    /**
     * Delete user - form
     * @throws HTTP_Exception
     */
    public function action_delete(): void
    {
        $user_id = $this->request->param('id');

        if ( ! $user_id )
        {
            MessageHandler::save(__("Missing user id"), BS::DANGER);
            self::_redirect_home();
        }

        $user = new Model_User($user_id);

        self::_make_sure_user_exists($user);

        $this->template->set('title', 'Delete User');

        $this->template->set(
            'content',
            View::factory('users/delete')
                ->set('user', $user)
        );
    }

    /**
     * Delete user
     * @throws HTTP_Exception
     */
    public function action_deleteconfirm(): void
    {
        $this->_handle_cancel();

        if ( ( $user_id = $this->request->post('user_id') ) !== null )
        {
            try
            {
                $user = (new Model_User($user_id));

                self::_make_sure_user_exists($user);

                $user_address = $user->address;

                //Delete user' address
                if ( $user_address->loaded() && $user_address->id )
                {
                    $user_address->delete();
                }

                //Delete user
                $user->delete();

                MessageHandler::save(__('User deleted.'));
            }
            catch ( Exception $exception )
            {
                MessageHandler::save(__('Unable to delete user!'), BS::DANGER);
            }
        }

        self::_redirect_home();
    }

    /**
     * Update user - form
     * @param Model_User|null $user
     * @param Model_Address|null $address
     * @param Errors $errors
     * @throws HTTP_Exception
     */
    public function action_update(
        Model_User $user = null,
        Model_Address $address = null,
        Errors $errors = null
    ): void
    {
        $user_id = $this->request->param('id');

        if ( ! ($user_id || $user) )
        {
            MessageHandler::save(__("Missing user"), BS::DANGER);
            self::_redirect_home();
        }

        $user = $user ?? new Model_User($user_id);

        $address = $address ?? $user->address;

        $errors = $errors ?? new Errors([]);

        self::_make_sure_user_exists($user);

        $this->template->set('title', 'Update User');

        $this->template->set(
            'content',
            View::factory('users/save')
                ->set('user', $user)
                ->set('address', $address)
                ->set('errors', $errors)
                ->set('action', 'updateconfirm')
        );
    }

    /**
     * Update user
     * @throws HTTP_Exception
     */
    public function action_updateconfirm(): void
    {
        $this->_handle_cancel();

        $user_id = $this->request->post('user_id');

        if ( ! $user_id )
        {
            MessageHandler::save(__("Missing user id"), BS::DANGER);
            self::_redirect_home();
        }

        $user = new Model_User($user_id);

        self::_make_sure_user_exists($user);

        $address = $user->address;

        //Populate models with data
        $user = $this->_populate_user_with_data($user);
        $address = $this->_populate_user_address_with_data($address);

        try
        {
            $user->save();
            $address->save();

            MessageHandler::save(__('User updated successfully.'));

            self::_redirect_home();
        }
        catch ( ORM_Validation_Exception $exception )
        {
            $this->action_update(
                $user,
                $address,
                new Errors($exception->errors('model'))
            );
        }
    }

    /**
     * Load data from post into Model_User model
     * @param Model_User $user
     * @return Model_User
     */
    private function _populate_user_with_data(Model_User $user): Model_User
    {
        $user->name = $this->request->post('name') ?? $user->name;
        $user->surname = $this->request->post('surname') ?? $user->surname;
        $user->telephone = $this->request->post('telephone') ?? $user->telephone;

        return $user;
    }

    /**
     * Load data from post into Model_Address model
     * @param Model_Address $address
     * @return Model_Address
     */
    private function _populate_user_address_with_data(Model_Address $address): Model_Address
    {
        $address->street = $this->request->post('street') ?? $address->street;
        $address->number = $this->request->post('number') ?? $address->number;
        $address->city = $this->request->post('city') ?? $address->city;
        $address->postal_code = $this->request->post('postal_code') ?? $address->postal_code;

        return $address;
    }

    /**
     * In case of failed user creation - remove user if exists
     * And fill Model with data from POST
     * @param Model_User $user
     * @return Model_User
     */
    private function _remove_the_user_and_repopulate_it(Model_User $user): Model_User
    {
        try
        {
            if ( $user->loaded() && $user->id )
            {
                //Remove the user from the database
                $user->delete();
                //Reload user data back to the model
                $user = $this->_populate_user_with_data($user);
            }
        }
        catch ( Kohana_Exception $exception )
        {
            $user = new Model_User();
        }

        return $user;
    }

    /**
     * Cancel form
     * @throws HTTP_Exception
     */
    private function _handle_cancel()
    {
        if ( $this->request->post('cancel') )
        {
            self::_redirect_home();
        }
    }

    /**
     * Check if user is loaded and redirect Home if it isn't
     * @param Model_User $user
     * @throws HTTP_Exception
     */
    private static function _make_sure_user_exists(Model_User $user): void
    {
        if ( ! ($user->loaded() && $user->id) )
        {
            MessageHandler::save(__("User doesn't exist"), BS::DANGER);
            self::_redirect_home();
        }
    }

    /**
     * Redirect to Home page
     * @throws HTTP_Exception
     */
    private static function _redirect_home()
    {
        HTTP::redirect('/users');
    }
}