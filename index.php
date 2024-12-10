<?php
class Charakter {
    // Attribute
    private $name;
    private $lebenspunkte;
    private $staerke;
    private $geschick;
    private $intelligenz;

    // Konstruktor
    public function __construct($name, $lebenspunkte, $staerke, $geschick, $intelligenz) {
        $this->name = $name;
        $this->lebenspunkte = $lebenspunkte;
        $this->staerke = $staerke;
        $this->geschick = $geschick;
        $this->intelligenz = $intelligenz;
    }

    // Destruktor
    public function __destruct() {
        echo "Charakter {$this->name} wird zerstoert.<br>";
    }

    // Getter-Methoden
    public function getName() {
        return $this->name;
    }

    public function getLebenspunkte() {
        return $this->lebenspunkte;
    }

    public function getStaerke() {
        return $this->staerke;
    }

    public function getGeschick() {
        return $this->geschick;
    }

    public function getIntelligenz() {
        return $this->intelligenz;
    }

    // Setter-Methoden
    public function setName($name) {
        $this->name = $name;
    }

    public function setLebenspunkte($lebenspunkte) {
        $this->lebenspunkte = $lebenspunkte;
    }

    public function setStaerke($staerke) {
        $this->staerke = $staerke;
    }

    public function setGeschick($geschick) {
        $this->geschick = $geschick;
    }

    public function setIntelligenz($intelligenz) {
        $this->intelligenz = $intelligenz;
    }
}

// Beispiel zur Nutzung der Klasse
$charakter = new Charakter("Held", 100, 20, 15, 10);
echo "Name: " . $charakter->getName() . "<br>";
echo "Lebenspunkte: " . $charakter->getLebenspunkte() . "<br>";
echo "Staerke: " . $charakter->getStaerke() . "<br>";
echo "Geschick: " . $charakter->getGeschick() . "<br>";
echo "Intelligenz: " . $charakter->getIntelligenz() . "<br>";

// Zerstoerung des Objekts
unset($charakter);
?>