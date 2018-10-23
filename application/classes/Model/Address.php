<?php

/**
 * Class Model_Address
 *
 * @property integer id
 * @property integer user_id
 * @property string street
 * @property string number
 * @property string city
 * @property string postal_code
 *
 * @property-read Model_User user
 */
class Model_Address extends ORM {
    protected $_table_name = 'users_addresses';

    protected $_table_columns = [
        'id' => null,
        'user_id' => null,
        'street' => null,
        'number' => null,
        'city' => null,
        'postal_code' => null,
    ];

    protected $_belongs_to = [
        'user' => [
            'model' => 'User'
        ]
    ];

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                ['not_empty'],
                ['numeric']
            ],
            'street' => [
                ['not_empty'],
                ['max_length', [':value', 255]]
            ],
            'number' => [
                ['not_empty'],
                ['max_length', [':value', 30]]
            ],
            'city' => [
                ['not_empty'],
                ['max_length', [':value', 255]]
            ],
            'postal_code' => [
                ['not_empty'],
                ['max_length', [':value', 30]]
            ]
        ];
    }

    public function filters()
    {
        //XSS protection
        return [
            'street' => [['HTML::chars']],
            'number' => [['HTML::chars']],
            'city' => [['HTML::chars']],
            'postal_code' => [['HTML::chars']]
        ];
    }

    public function labels()
    {
        return [
            'postal_code' => 'postal code'
        ];
    }
}