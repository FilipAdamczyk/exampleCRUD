<?php
    /** @var Model_User $user */
    echo __('Are you sure you want to delete user :user', [':user' => "{$user->name} {$user->surname}"]) . "<br />";
    echo Form::open('/users/deleteconfirm');
    echo Form::hidden('user_id', $user->id);
    echo Form::submit('submit', __('Delete'), ['class' => 'btn btn-danger']) . '&nbsp;';
    echo Form::submit('cancel', __('Cancel'), ['class' => 'btn']);
    echo Form::close();