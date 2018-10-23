<?php

use \View\BS;

echo $message;

echo BS::button(
    '/users/create',
    __('Create User')
);

/** @var Database_Result $users*/
if ( $users->count() ): ?>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Telephone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php
        /** @var Model_User $user */
        foreach ( $users as $user )
        {
            echo "<tr>" .
                "<td>{$user->name}</td>" .
                "<td>{$user->surname}</td>" .
                "<td>{$user->telephone}</td>" .
                "<td>" .
                    "{$user->address->street} {$user->address->number}<br />" .
                    "{$user->address->postal_code} {$user->address->city}<br />" .
                "</td>" .
                "<td>" .
                    BS::button(
                        "users/update/{$user->id}",
                        __('Edit')
                    ) . "&nbsp;" .
                    BS::button(
                        "users/delete/{$user->id}",
                        __('Delete'),
                        BS::DANGER
                    ) .
                "</td>" .
                "</tr>\n";
        }
        ?>
    </table>
<?php endif; ?>