<?php

namespace App\Models;

class User
{
    private const USERS = [
        [
            'cpf' => '79802140996',
            'name' => 'Renan Ruan Baptista',
            'email' => 'marianetatianealinebernardes-87@outllok.com',

        ], [
            'cpf' => '49547824732',
            'name' => 'Jorge Kevin Marcelo Fernandes',
            'email' => 'jenniferisisvieira-98@tjam.jus.br',

        ], [
            'cpf' => '36693267904',
            'name' => 'Julia Valentina Galvão',
            'email' => 'heloisealiceclariceviana_@afsn.com.br',

        ], [
            'cpf' => '20381626547',
            'name' => 'Aparecida Stefany Silvana Rezende',
            'email' => 'cauetheopereira_@indaseg.com.br',

        ],
    ];

    public static function get(string $cpf = '')
    {
        $users = self::USERS;

        if ($cpf) {
            // Filter
        }

        return $users;
    }
}
