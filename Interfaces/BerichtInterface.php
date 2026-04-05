<?php
interface BerichtInterface {
    public function opslaan(string $tekst, int $user_id): bool;
    public function getAlle(): array;
    public function verwijder(int $bericht_id): bool;
}
?>