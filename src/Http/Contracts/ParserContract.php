<?php

namespace EON\Http\Contracts;

interface ParserContract
{
    public function getData(string $path): iterable;
    public function saveData($data): bool;
    public function validation($data): mixed;
}
