<?php

namespace App\Services;

trait DadosContratante
{
    public function getContratante(): string
    {
        return $this->matchContratante("[^[:punct:]]+");
    }

    public function getContratanteCpfOuPj(): string
    {
        return $this->matchContratante("\b\d{3}\.?\d{3}\.?\d{3}-?\d{2}\b");
    }

    public function getContratanteRg(): string
    {
        return $this->matchContratante("\b(\d{1,2}\.?)(\d{3}\.?)(\d{3})\b");
    }

    public function getContratanteCep(): string
    {
        return $this->matchContratante("\d{5}-\d{3}");
    }

    public function getContratanteEstadoCivil(): string
    {
        return $this->matchContratante("Estado\s+Civil:?\s+[^[:punct:]]+");
    }

    public function getContratanteRua(): string
    {
        return $this->matchContratante("(Rua|Avenida|Av.)\s+[^[:punct:]]+(,\s+\d+)?");
    }

    public function getContratanteBairro(): string
    {
        return $this->matchContratante("(Bairro:?|Bairro\sde)\s+[^[:punct:]]+");
    }

    public function getContratanteCidade(): string
    {
        return $this->matchContratante("(Cidade:?|Cidade\sde)\s+[^[:punct:]]+");
    }

    public function getContratanteEstado(): string
    {
        return $this->matchContratante("(Estado:?|Estado\sde)\s+([^[:punct:]]+)");
    }

    private function matchContratante(string $searchRegex): string
    {
        $pattern = sprintf("/(?:Contratante)\s*[:,].*?(?P<result>%s)/i", $searchRegex);
        preg_match($pattern, $this->documento, $matches);

        return isset($matches["result"]) ? trim($matches["result"]) : "N/A";
    }
}
