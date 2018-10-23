<?php
    use \View\BS;

/**
 * @var Model_User $user
 * @var Model_Address $address
 */
    echo Form::open("/users/{$action}", ['class' => 'form-horizontal']);
    echo BS::input(
        'name',
        $user->name ?? '',
        __('Name: '),
        $errors->get('name')
    );

    echo BS::input(
        'surname',
        $user->surname ?? '',
        __('Surname: '),
        $errors->get('surname')
    );

    echo BS::input(
        'telephone',
        $user->telephone ?? '',
        __('Telephone: '),
        $errors->get('telephone')
    );

    echo BS::input(
        'street',
        $address->street ?? '',
        __('Street: '),
        $errors->get('street')
    );

    echo BS::input(
        'number',
        $address->number ?? '',
        __('Number: '),
        $errors->get('number')
    );

    echo BS::input(
        'city',
        $address->city ?? '',
        __('City: '),
        $errors->get('city')
    );


    echo BS::input(
        'postal_code',
        $address->postal_code ?? '',
        __('Postal Code: '),
        $errors->get('postal_code')
    );

    echo ( ! empty($user->id) ) ? Form::hidden('user_id', $user->id) : '';
    echo Form::submit('submit', __('Save'), ['class' => 'btn btn-primary']) . '&nbsp;';
    echo Form::submit('cancel', __('Cancel'), ['class' => 'btn']);
    echo Form::close();