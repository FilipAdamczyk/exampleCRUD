<?php

/**
 * Class Model_User
 *
 * @property integer id
 * @property string name
 * @property string surname
 * @property string telephone
 *
 * @property-read Model_Address address
 */
class Model_User extends ORM {

    protected $_table_name = 'users';

    protected $_has_one = [
        'address' => [
            'model' => 'Address'
        ]
    ];

    protected $_table_columns = [
        'id' => null,
        'name' => null,
        'surname' => null,
        'telephone' => null
    ];

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                ['not_empty'],
                ['max_length', [':value', 255]]
            ],
            'surname' => [
                ['not_empty'],
                ['max_length', [':value', 255]]
            ],
            'telephone' => [
                ['not_empty'],
                ['phone']
            ]
        ];
    }

    public function filters()
    {
        //XSS protection
        return [
            'name' => [['HTML::chars']],
            'surname' => [['HTML::chars']]
        ];
    }
}