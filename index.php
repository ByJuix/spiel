<?php
class Charakter {
    // Attribute
    private $name;
    private $health;
    private $strength;
    private $dexterity;
    private $intelligence;
    private $color;
    private $speed;

    // Konstruktor
    public function __construct($name, $health, $strength, $dexterity, $intelligence, $speed) {
        $this->color = rand(1,100);
        $this->name = $name;
        $this->health = $health * ((100+ $this->color)/100);
        $this->strength = $strength * ((100+ $this->color)/100);
        $this->dexterity = $dexterity * ((100+ $this->color)/100);
        $this->intelligence = $intelligence * ((100+ $this->color)/100);
        $this->speed = $speed * ((100+ $this->color)/100);

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
    public function getSpeed() {
        return $this->speed;
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

    public function setSpeed($speed) {
        $this->color = $speed;
    }

    private function Attack ($Enemy){
        $Enemy->Defend($this->dexterity, $this->getStrength());
    }
    
    private function Defend ($EnemyDex, $Damage){
        $DamageTaken = $EnemyDex/$this->dexterity *$Damage;
        $this->setHealth($this->getHealth() - $DamageTaken);
    }

    private function Fight ($Enemy) {

    }
}

class items {

    private $item_name;
    private $item_damage;
    private $item_type;


    // Getter-Methoden
    public function getItem_name() {
        return $this->item_name;
    }
    public function getItem_damage() {
        return $this->item_damage;
    }
    public function getItem_type() {
        return $this->item_type;
    }
        // Setter-Methoden
    
    public function setItem_name($item_name) {
        $this->item_name = $item_name;
    }
    public function setItem_damage($item_damage) {
        $this->item_damage = $item_damage;
    }
    public function setItem_type($item_type) {
        $this->item_type = $item_type;
    }

    // Konstruktor
    public function __construct($item_name, $item_damage, $item_type) {
        $this->item_name = $item_name;
        $this->item_damage = $item_damage;
        $this->item_type = $item_type;
    }

    // Destruktor
    public function __destruct() {
        echo "Item {$this->item_name} wird zerstoert.<br>";
    }
}

// Beispiel zur Nutzung der Klasse
$charakter = new Charakter("Held", 100, 100, 20, 15, 10);
echo "Name: " . $charakter->getName() . "<br>";
echo "Health: " . $charakter->getHealth() . "<br>";
echo "Strength: " . $charakter->getStrength() . "<br>";
echo "Dexterity: " . $charakter->getDexterity() . "<br>";
echo "Intelligence: " . $charakter->getIntelligence() . "<br>";
echo "Speed: " . $charakter->getSpeed() . "<br>";
echo "Color: " . $charakter->getColor() . "<br>";

// Zerstoerung des Objekts
unset($charakter);
?>