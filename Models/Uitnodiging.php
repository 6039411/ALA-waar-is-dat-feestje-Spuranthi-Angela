<?php
// Verstuurt uitnodigingen via e-mail naar MailHog (XAMPP, poort 1025)
class Uitnodiging {

    private $conn;
    private $table_name = "uitnodiging";

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function verstuur($activiteit_id, $email, $activiteit) {
        $this->slaOp($activiteit_id, $email);
        return $this->stuurEmail($email, $activiteit);
    }

    private function slaOp($activiteit_id, $email) {
        try {
            $sql  = "INSERT INTO " . $this->table_name . " (activiteit_id, email) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$activiteit_id, $email]);
        } catch (PDOException $e) {
        
        }
    }

    private function stuurEmail($email, $activiteit) {
        $naam         = htmlspecialchars($activiteit['naam']);
        $datum        = htmlspecialchars($activiteit['datum']);
        $tijd         = htmlspecialchars($activiteit['tijd']);
        $beschrijving = htmlspecialchars($activiteit['beschrijving']);

        $onderwerp = "Uitnodiging: " . $naam;

        $bericht = "
        <html>
        <body style='font-family: Gill Sans Extrabold, sans-serif; padding: 20px;'>
            <h2>Je bent uitgenodigd voor een activiteit</h2>
            <p>Er is een activiteit gepland waar je bij kunt zijn:</p>
            <table style='border-collapse: collapse;'>
                <tr><td style='padding: 6px 12px;'>Activiteit:</td><td>{$naam}</td></tr>
                <tr><td style='padding: 6px 12px;'>Datum:</td><td>{$datum}</td></tr>
                <tr><td style='padding: 6px 12px;'>Tijd:</td><td>{$tijd}</td></tr>
                <tr><td style='padding: 6px 12px;'>Beschrijving:</td><td>{$beschrijving}</td></tr>
            </table>
            <p>Ga naar de website om jezelf aan te melden aan de activiteit.</p>
        </body>
        </html>";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: noreply@waarisdatfeestje.nl\r\n";

        return mail($email, $onderwerp, $bericht, $headers);
    }
}
?>