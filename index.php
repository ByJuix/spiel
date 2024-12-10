<?php
class Charakter {
    // Attribute
    private $name;
    private $health;
    private $strength;
    private $dexterity;
    private $intelligence;
    private $color;

    // Konstruktor
    public function __construct($name, $health, $strength, $dexterity, $intelligence) {
        $this->color = rand(1,100);
        $this->name = $name;
        $this->health = $health * ((100+ $this->color)/100);
        $this->strength = $strength * ((100+ $this->color)/100);
        $this->dexterity = $dexterity * ((100+ $this->color)/100);
        $this->intelligence = $intelligence * ((100+ $this->color)/100);
    }

    // Destruktor
    public function __destruct() {
        echo "Charakter {$this->name} wird zerstoert.<br>";
    }

    // Getter-Methoden
    public function getName() {
        return $this->name;
    }

    public function getHealth() {
        return $this->health;
    }

    public function getStrength() {
        return $this->strength;
    }

    public function getDexterity() {
        return $this->dexterity;
    }

    public function getIntelligence() {
        return $this->intelligence;
    }

    public function getColor() {
        return $this->color;
    }

    // Setter-Methoden
    public function setName($name) {
        $this->name = $name;
    }

    public function setHealth($health) {
        $this->health = $health;
    }

    public function setStrength($strength) {
        $this->strength = $strength;
    }

    public function setDexterity($dexterity) {
        $this->dexterity = $dexterity;
    }

    public function setIntelligence($intelligence) {
        $this->intelligence = $intelligence;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    private function Attack ($Enemy){
        $Enemy->setHealth() = $Enemy->getHealth() - $this->getStrength();
    }
}

// Beispiel zur Nutzung der Klasse
$charakter = new Charakter("Held", 100, 100, 20, 15);
echo "Name: " . $charakter->getName() . "<br>";
echo "Health: " . $charakter->getHealth() . "<br>";
echo "Strength: " . $charakter->getStrength() . "<br>";
echo "Dexterity: " . $charakter->getDexterity() . "<br>";
echo "Intelligence: " . $charakter->getIntelligence() . "<br>";
echo "Color: " . $charakter->getColor() . "<br>";

// Zerstoerung des Objekts
unset($charakter);
?>