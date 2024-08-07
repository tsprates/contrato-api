<?php

namespace App\Services;

trait DadosClausula
{
    public function getClausulas(): array
    {
        $pattern = "/Cláusula\s+[^;.]+/i";
        preg_match_all($pattern, $this->documento, $matches);

        return isset($matches[0]) ? array_map("trim", $matches[0]) : [];
    }
}
