<?php

namespace App\Services;

trait DadosContratado
{
    public function getContratado(): string
    {
        return $this->matchContratado("[^[:punct:]]+");
    }

    public function getContratadoCpfOuPj(): string
    {
        return $this->matchContratado("\b\d{3}\.?\d{3}\.?\d{3}-?\d{2}\b");
    }

    public function getContratadoRg(): string
    {
        return $this->matchContratado("\b(\d{1,2}\.?)(\d{3}\.?)(\d{3})\b");
    }

    public function getContratadoCep(): string
    {
        return $this->matchContratado("\d{5}-\d{3}");
    }

    public function getContratadoRua(): string
    {
        return $this->matchContratado("(Rua|Avenida|Av.)\s+[^[:punct:]]+(,\s+\d+)?");
    }

    public function getContratadoBairro(): string
    {
        return $this->matchContratado("(Bairro:?|Bairro\sde)\s+[^[:punct:]]+");
    }

    public function getContratadoCidade(): string
    {
        return $this->matchContratado("(Cidade:?|Cidade\sde)\s+[^[:punct:]]+");
    }

    public function getContratadoEstado(): string
    {
        return $this->matchContratado("(Estado:?|Estado\sde)\s+[^[:punct:]]+");
    }

    private function matchContratado(string $searchRegex): string
    {
        $pattern = sprintf("/(?:Prestador\s+de\s+Serv\S+|Contratado)\s*[:,].*?(?P<result>%s)/i", $searchRegex);
        preg_match($pattern, $this->documento, $matches);

        return isset($matches["result"]) ? trim($matches["result"]) : "N/A";
    }
}
