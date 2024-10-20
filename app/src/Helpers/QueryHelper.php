<?php

namespace App\Helpers;

class QueryHelper
{
    public function getCharacterInfo(int $id): string {
        return sprintf('query {
            charactersByIds(ids: [%d] ) {
                id,
                name
            }
        }', $id);
    }
}