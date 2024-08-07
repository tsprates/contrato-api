<?php

namespace App\Services;

class DocumentoParser
{
    use DadosContratante, DadosContratado, DadosClausula;

    private string $documento;

    public function __construct(string $documento)
    {
        $this->documento = preg_replace("/\s+/", " ", trim($documento));
    }

    public function getData()
    {
        $pattern = "/(?P<data>\d{1,2}\s+de\s+(janeiro|fevereiro|março|abril|maio|junho|julho|agosto|setembro|outubro|novembro|dezembro)\s+de\s+\d{4})/i";
        preg_match($pattern, $this->documento, $matches);

        return isset($matches["data"]) ? trim($matches["data"]) : "N/A";
    }
}
