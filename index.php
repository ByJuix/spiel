<?php
class Charakter {
    // Attribute
    private $name;
    private $health;
    private $strength;
    private $dexterity;
    private $intelligence;
    private $color;

    // Possible names array
    private $possibleNames = ["Cyanis der Schimmernde", "Kuphero der Glühende", "Rubinia Flammenklinge", "Azubios der Garagenfeger", "Ambera Goldhand", "Vermilios Stahlseele", "Bronzora die Mächtige", "Zinnox der Verschlagene", "Smargant der Weise", "Alabastea der Erhabene", "Saphiriel Sturmbrecher", "Ochros Kupferflamme", "Chalybeus der Unverwüstliche", "Verdantus Blattläufer", "Aurenix der Glanzvolle", "Carminelle Schattenruferin", "Cobalta Nachtseele", "Malach der Grüne Hüter", "Zirkon Flammensucher", "Titanora die Ewige", "Feldmannius der Göttliche"];

    // Konstruktor
    public function __construct($name = null, $health, $strength, $dexterity, $intelligence) {
        $this->name == "Feldmannius der Göttliche" ? $this->color = rand(1, 100) : $this->color = rand(100, 500);
        $this->name = $name ?? $this->possibleNames[array_rand($this->possibleNames)];
        $this->health = $health * ((100 + $this->color) * 0.01);
        $this->strength = round($strength * ((100 + $this->color) * 0.01), 0);
        $this->dexterity = round($dexterity * ((100 + $this->color) * 0.01), 0);
        $this->intelligence = round($intelligence * ((100 + $this->color) * 0.01), 0);
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

    private function Attack($Enemy) {
        $Enemy->Defend($this->dexterity, $this->getStrength());
    }

    private function Defend($EnemyDex, $Damage) {
        $DamageTaken = $EnemyDex / $this->dexterity * $Damage;
        $this->setHealth($this->getHealth() - $DamageTaken);
    }
}

// Beispiel zur Nutzung der Klasse
$charakter = new Charakter(null, 1000, 37, 20, 15);
echo "Name: " . $charakter->getName() . "<br>";
echo "Health: " . $charakter->getHealth() . "<br>";
echo "Strength: " . $charakter->getStrength() . "<br>";
echo "Dexterity: " . $charakter->getDexterity() . "<br>";
echo "Intelligence: " . $charakter->getIntelligence() . "<br>";
echo "Color: " . $charakter->getColor() . "<br>";

// Zerstoerung des Objekts
unset($charakter);
?>