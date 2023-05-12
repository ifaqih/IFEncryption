<?php

namespace IFaqih\IFEncryption\Component\Password\Version;

abstract class AbstractVersion
{
    protected const name = "if";

    abstract public function decustoming_hash(string $existingHash): array;
}
