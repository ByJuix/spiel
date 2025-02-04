<?php
namespace FantasyRacism\Core;

class Charakter {
    // Attribute
    private $isAlive;
    private $playerControlled;
    private $name;
    
    private $baseMaxHealth;        #stats that dont change outside of constructor
    private $baseStrength;
    private $baseDexterity;
    private $baseIntelligence;
    private $baseSpeed;


    private $maxHealth;            #stats that change with color
    private $currentHealth;
    private $strength;
    private $dexterity;
    private $intelligence;
    private $speed;
    
    private $color;
    private $EquippedWeapon;
    private $EquippedArmor;

    // Konstruktor
    public function __construct($name, $health, $strength, $dexterity, $intelligence, $speed) {

        $possibleNames = ["Cyanis der Schimmernde", "Kuphero der Glühende", "Rubinia Flammenklinge", "Azubios der Garagenfeger", "Ambera Goldhand", "Vermilios Stahlseele", "Bronzora die Mächtige", "Zinnox der Verschlagene", "Smargant der Weise", "Alabastea der Erhabene", "Saphiriel Sturmbrecher", "Ochros Kupferflamme", "Chalybeus der Unverwüstliche", "Verdantus Blattläufer", "Aurenix der Glanzvolle", "Carminelle Schattenruferin", "Cobalta Nachtseele", "Malach der Grüne Hüter", "Zirkon Flammensucher", "Titanora die Ewige", "Feldmannius der Göttliche"];
    
        $this->name = $name ?? $possibleNames[array_rand($possibleNames)];
        $this->name == "Feldmannius der Göttliche" ? $this->color = rand(100, 500) : $this->color = rand(1, 100);

        $this->baseMaxHealth = $health; 
        $this->strength = $strength;
        $this->baseDexterity = $dexterity;
        $this->baseIntelligence = $intelligence;
        $this->baseSpeed = $speed;
        $this->EquippedArmor = new item("Basic Armor", "Armor", 0, 0, 10);
        $this->EquippedWeapon = new item("Basic Sword", "Sword", 10, 0, 0);
    }

    // Destruktor
    public function __destruct() {
    }

    // Getter-Methoden

    public function getStat ($statName) {
        $color = $this->color;
        switch (strtolower($statName)) {
            case "name": return $this->name;
            case "maxhealth": return round( $this->baseMaxHealth * ((100+ $color)*0.01),0 );
            case "strength": return round( $this->baseStrength * ((100+ $color)*0.01),0 );
            case "dexterity": return round( $this->baseDexterity * ((100+ $color)*0.01),0 );
            case "intelligence": return round( $this->baseIntelligence * ((100+ $color)*0.01),0 );
            case "speed": return round( $this->baseSpeed * ((100+ $color)*0.01),0 );
            case "armor": return $this->EquippedArmor;
            case "weapon": return $this->EquippedWeapon;
            case "color": return $color;
        }
             
    }
    // Setter-Methoden
    public function setAttribute($attribute, $value) {
        switch ($attribute) {
            case 'isAlive':
                $this->isAlive = $value;
                break;
            case 'playerControlled':
                $this->playerControlled = $value;
                break;
            case 'name':
                $this->name = $value;
                break;
            case 'maxHealth':
                $this->maxHealth = $value;
                break;
            case 'currentHealth':
                $this->currentHealth = $value;
                break;
            case 'strength':
                $this->strength = $value;
                break;
            case 'dexterity':
                $this->dexterity = $value;
                break;
            case 'intelligence':
                $this->intelligence = $value;
                break;
            case 'speed':
                $this->speed = $value;
                break;
            case 'color':
                $this->color = $value;
                break;
            case 'EquippedWeapon':
                $this->EquippedWeapon = $value;
                break;
            case 'EquippedArmor':
                $this->EquippedArmor = $value;
                break;
            default:
                echo "Fehler";    
        }
    }
    

    private function physAttack ($Enemy){
        $physWeaponDamage = $this->getStat("weapon")->getStat("damagePhys");
        $Enemy->Defend($this->dexterity, $this->getStat("strength") + $physWeaponDamage);
    }
    private function physAttackStrong ($Enemy){
        if (rand(0,1)){
            $physWeaponDamage = $this->getStat("weapon")->getStat("damagePhys");
            $Enemy->Defend($this->dexterity*3, $this->getStat("strength") + $physWeaponDamage);
        }
    }
    private function magAttack ($Enemy){
        $magWeaponDamage = $this->getStat("weapon")->getStat("damagMag");
        $Enemy->Defend($this->dexterity, $this->getStat("intelligence")+ $magWeaponDamage);
    }
    private function magAttackStrong ($Enemy){
        if (rand(0,1)){
            $magWeaponDamage = $this->getStat("weapon")->getStat("damagMag");
            $Enemy->Defend($this->dexterity*3, $this->getStat("intelligence")+ $magWeaponDamage);
        }
    }


    private function TakeDMG($Damage) {
        $this->currentHealth -= $Damage;
    }
    private function Defend($EnemyDex, $Damage) {
        $DamageTaken = $EnemyDex / $this->dexterity * $Damage;
        $this->TakeDmg($DamageTaken);
    }
    private function getLootColour() {
        return round($this->getStat("color") / rand(5,15),0);
    }
    private function getLootArmor() {
        if (rand(1,2) == 1) {
            return $this->getStat("armor");
        }
        return;
    }
    private function getLootWeapon() {
        if (rand(1,2) == 1) {
            return $this->getStat("weapon");
        }    }
}

class Item {

    private $name;
    private $damage_phys;
    private $damage_mag;
    private $defense;
    private $type;

    public function getStat ($statName): mixed { //getter Methode
        switch (strtolower($statName)) {
            case "name": return $this->name;
            case "damagephys": return $this->damage_phys;
            case "damagemag": return $this->damage_mag;
            case "defense": return $this->defense;
            case "type": return $this->type;
            default: return "Fehler bei Item Getstat";
        }
    }

    public function setItemAttributes($name, $type, $damage_phys, $damage_mag, $defense) {
        $this->name = $name;
        $this->type = $type;
        $this->damage_phys = $damage_phys;
        $this->damage_mag = $damage_mag;
        $this->defense = $defense;
    }
    
    

    // Konstruktor
    public function __construct($name, $type, $damage_phys,  $damage_mag, $defense) {
        $this->name = $name;
        $this->type = $type;
        $this->damage_phys = $damage_phys;
        $this->damage_mag = $damage_mag;
        $this->defense = $defense;
    }

    // Destruktor
    public function __destruct() {
    }
}

class Fight {

    private $player;
    private $playerCurrentHP;
    
    private $enemy;
    private $enemyCurrentHP;

    public function __construct($player, $enemy) {
        if ($player) {$this->player = $player;}
        if ($enemy) {$this->enemy = $enemy;}

        $this->playerCurrentHP = $this->player->getStat("maxhealth");
        $this->enemyCurrentHP = $this->enemy->getStat("maxhealth");

    }

    public function FightRound($playerAction){
        if ($playerAction) {
            switch ($playerAction) {
                case "phys":
                    $this->player->physAttack($this->enemy);
                    break;
                case "mag":
                    $this->player->magAttack($this->enemy);
                    break;
                case "physStrong":
                    $this->player->physAttackStrong($this->enemy);
                    break;    
                case "magStrong":
                    $this->player->magAttackStrong($this->enemy);
                    break;        
                }
        if ($this->enemyCurrentHP > 0)
                switch(rand(0,3)){
                    case "0":
                        $this->enemy->physAttack($this->player);
                        break;
                    case "1":
                        $this->enemy->magAttack($this->player);
                        break;
                    case "2":
                        $this->enemy->physAttackStrong($this->player);
                        break;    
                    case "3":
                        $this->enemy->magAttackStrong($this->player);
                        break;        
                    }
                }





        }
    }