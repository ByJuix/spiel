<?php
namespace PHPixel\Core;

class Charakter {
    // Attribute/Stats
    private $isAlive; 
    private $playerControlled;
    private $name;
    
    private $baseMaxHealth;        #stats that dont change outside of constructor
    private $baseStrength;
    private $baseDexterity;
    private $baseIntelligence;
    
    private $currentHealth;


    private $maxHealth;            #unneccesary weil base stats im getter mit xp verrechnet werden
    private $strength;
    private $dexterity;
    private $intelligence;
    
    private $money;
    private $xp;
    private $EquippedWeapon;
    private $EquippedArmor;

    // Konstruktor
    public function __construct($name, $isPlayer, $health, $strength, $dexterity, $intelligence) {

        $playerNames = ["Cyanis der Schimmernde", "Kuphero der Glühende", "Rubinia Flammenklinge", "Azubios der Garagenfeger", "Ambera Goldhand", "Vermilios Stahlseele", "Bronzora die Mächtige", "Zinnox der Verschlagene", "Smargant der Weise", "Alabastea der Erhabene", "Saphiriel Sturmbrecher", "Ochros Kupferflamme", "Chalybeus der Unverwüstliche", "Verdantus Blattläufer", "Aurenix der Glanzvolle", "Carminelle Schattenruferin", "Cobalta Nachtseele", "Malach der Grüne Hüter", "Zirkon Flammensucher", "Titanora die Ewige", "Feldmannius der Göttliche"];
        $enemyNames = ["Das wundersame Skelett", "Das aromatische Ding", "Der wundersame Hüter", "Der Phantomsucher", "Das aromatische Monster", "Der achtsame Charmeur", "Der aromatische Charmeur", "Das gutherzige Ding", "Das Phantommonster", "Die Phantomhexe" /*, "Feldmannius der Göttliche"*/];
        


        $this->isAlive = true;
        $this->playerControlled = $isPlayer ?? false;     // muss bei Spielercharakter auf true gesetzt werden
        if (!$name){                                        //if no name set select name from playerNames/enemyNames list, set XP values
            if ($isPlayer) {
                $this->name = $playerNames[array_rand($playerNames)];
                $this->name == "Feldmannius der Göttliche" ? $this->xp = rand(100, 500) : $this->xp = rand(1, 100);
            } else {
                $this->name = $enemyNames[array_rand($enemyNames)];
                $this->name == "Feldmannius der Göttliche" ? $this->xp = rand(100, 500) : $this->xp = rand(50, 200);
            }
        }

        $this->money = round($this->xp / 3, 0); 

        $this->baseMaxHealth = $health;         //verwertung der eingegebenen werte
        $this->currentHealth = $health;
        $this->baseStrength = $strength;
        $this->baseDexterity = $dexterity;
        $this->baseIntelligence = $intelligence;
        $this->EquippedArmor = new item("Kupferrüstung", 1, "Armor", 0, 0, 10); //standardausruestung
        $this->EquippedWeapon = new item("Kupferdolch", 1, "Weapon", 10, 0, 0);

        $this->currentHealth = $this->getStat("maxhealth");
    }

    // Destruktor
    public function __destruct() {
    }

    // Getter-Methode

    public function getStat ($statName) {
        $xp = $this->xp;
        switch (strtolower($statName)) {
            case "isalive": return $this->isAlive;
            case "name": return $this->name;
            case "maxhealth": return round( $this->baseMaxHealth * ((100+ $xp)*0.01),0 );
            case "currenthealth": return round( $this->currentHealth );
            case "strength": return round( $this->baseStrength * ((100+ $xp)*0.01),0 );
            case "dexterity": return round( $this->baseDexterity * ((100+ $xp)*0.01),0 );
            case "intelligence": return round( $this->baseIntelligence * ((100+ $xp)*0.01),0 );
            case "armor": return $this->EquippedArmor;
            case "weapon": return $this->EquippedWeapon;
            case "xp": return $xp;
            case "money" : return $this->money;
        }
             
    }
    // Setter-Methoden
    public function setAttribute($attribute, $value) {
        switch (strtolower($attribute)) {
            case 'isalive':
                $this->isAlive = $value;
                break;
            case 'playercontrolled':
                $this->playerControlled = $value;
                break;
            case 'name':
                $this->name = $value;
                break;
            case 'maxhealth':
                $this->baseMaxHealth = $value;
                break;
            case 'currenthealth':
                $this->currentHealth = $value;
                break;
            case 'strength':
                $this->baseStrength = $value;
                break;
            case 'dexterity':
                $this->baseDexterity = $value;
                break;
            case 'intelligence':
                $this->baseIntelligence = $value;
                break;
            case 'xp':
                $this->xp = $value;
                break;
            case 'money':
                $this->money = $value;
                break;
            case 'equippedweapon':
                $this->EquippedWeapon = $value;
                break;
            case 'equippedarmor':
                $this->EquippedArmor = $value;
                break;
            default:
                echo "Fehler";    
        }
    }
    

    public function Attack ($type, $Enemy, $blocked):int{ //the fact if it was blocked or not is given to the attack
        if ($blocked) {$blockedMult = 0.5;} else {$blockedMult = 1;}

        switch ($type) {            //get corresponding weapon damage and player stat to the attack type
            case "phys": 
                $WeaponDamage = $this->getStat("weapon")->getStat("damagePhys");
                $attackStat = $this->getStat("strength");
                $damageMult = 1;
                break;
            case "mag": 
                $WeaponDamage = $this->getStat("weapon")->getStat("damageMag");
                $attackStat = $this->getStat("intelligence");
                $damageMult = 1;
                break;
            case "physstrong":
                $WeaponDamage = $this->getStat("weapon")->getStat("damagePhys");
                $attackStat = $this->getStat("strength");
                $damageMult = rand(0,2);
                break;
            case "magstrong":
                $WeaponDamage = $this->getStat("weapon")->getStat("damageMag");
                $attackStat = $this->getStat("intelligence");
                $damageMult = rand(0,2);
                break;
            default: 
                break;
        }
        $dealDMG = ($attackStat + $WeaponDamage)*$blockedMult*$damageMult; //total dmg depends on the attack stat, weapon attack stat, and if its blocked or not, and possible multiplier if its strong attack. 
        $damageDealt = $Enemy->Defend($this->getStat("dexterity"), $dealDMG);
        return $damageDealt;
        
    }

    /*          entfernt, da alles in Attack funktion


    public function physAttackStrong ($Enemy, $blocked):int{ //the fact if it was blocked or not is given to the attack 
        if ($blocked) {$blockedMult = 0.5;} else $blockedMult = 1;
        if (rand(0,1)){                             //50/50 to hit/miss
            $physWeaponDamage = $this->getStat("weapon")->getStat("damagePhys");
            $dealDMG = ($this->getStat("strength") + $physWeaponDamage)*3*$blockedMult;  //total dmg depends on strength, weapon attack stat, and if its blocked or not. factor 3 bc strong attack
            $damageDealt = $Enemy->Defend($this->getStat("dexterity")*3, $dealDMG);
            return $damageDealt;
        } else return 0;
    }
    public function magAttack ($Enemy, $blocked):int{ //the fact if it was blocked or not is given to the attack
        if ($blocked) {$blockedMult = 0.5;} else $blockedMult = 1;
        if (rand(0,9)!= 0){                         // 10%chance to miss
            $magWeaponDamage = $this->getStat("weapon")->getStat("damageMag");
            $dealDMG = ($this->getStat(statName: "intelligence") + $magWeaponDamage)*$blockedMult; //total dmg depends on intelligence, weapon attack stat, and if its blocked or not
            $damageDealt = $Enemy->Defend($this->getStat("dexterity"), $dealDMG);
            return $damageDealt;
        } else return 0;
    }
    public function magAttackStrong ($Enemy, $blocked):int{ //the fact if it was blocked or not is given to the attack
        if ($blocked) {$blockedMult = 0.5;} else $blockedMult = 1;
        if (rand(0,1)){                             // 50/50 chance to miss/hit
            $magWeaponDamage = $this->getStat("weapon")->getStat("damageMag");
            $dealDMG = ($this->getStat(statName: "intelligence") + $magWeaponDamage)*3*$blockedMult; //total dmg depends on intelligence, weapon attack stat, and if its blocked or not. factor 3 bc strong attack
            $damageDealt = $Enemy->Defend($this->getStat("dexterity")*3, $dealDMG);
            return $damageDealt;
        } else return 0;
    }*/


    public function TakeDMG($Damage) {                  //basically setter function, for readability
        $this->currentHealth -= $Damage;
    }
    public function Heal($heal) {                  //basically setter function, for readability
        $this->currentHealth += $heal;
        if ($this->currentHealth > $this->Getstat("maxhealth")) {$this->setAttribute("currenthealth", $this->Getstat("maxhealth")) ; }
    }
    public function Defend($EnemyDex, $Damage):int {        //damage depends on dexterity stat of attacker and defender
        $DamageTaken = $EnemyDex / $this->getStat("dexterity") * $Damage;
        $this->TakeDmg($DamageTaken);
        return $DamageTaken;
    }
    public function getLootXp() {                //basically getter function, for readability. u gain varying piece of XP from enemy on killing it
        return round($this->getStat("xp") / rand(5,15),0);
    }
    public function getLootMoney() {                 //basically getter function, for readability. u gain varying piece of cash from enemy on killing it
        return round($this->getStat("money") / rand(1,3),0);
    }
}

class Item {

    private $name;
    private $level;
    private $damage_phys;
    private $damage_mag;
    private $defense;
    private $type;

    public function getStat ($statName): mixed { //getter Methode
        switch (strtolower($statName)) {
            case "name": return $this->name;
            case "level": return $this->level;
            case "damagephys": return $this->damage_phys;
            case "damagemag": return $this->damage_mag;
            case "defense": return $this->defense;
            case "type": return $this->type;
            default: return "Fehler bei Item Getstat";
        }
    }

    public function setItemAttributes($name, $level, $type, $damage_phys, $damage_mag, $defense) { //setter
        $this->name = $name;
        $this->level = $level;
        $this->type = $type;
        $this->damage_phys = $damage_phys;
        $this->damage_mag = $damage_mag;
        $this->defense = $defense;
    }

    // Konstruktor
    public function __construct($name, $level, $type, $damage_phys,  $damage_mag, $defense) {

        //verwerten der eingegebenen werte

        $this->name = $name;
        $this->level = $level ?? 1;
        $this->type = $type;
        $this->damage_phys = $damage_phys;
        $this->damage_mag = $damage_mag;
        $this->defense = $defense;
    }

    // Destruktor
    public function __destruct() {
    }
}

class FightRoundReturnValue
{ //class to create return object as fightrounds need to return alot of information
 public $WinLooseContinue;
 public $playerDamageDealt;
 public $playerBlocked;
 public $enemyDamageDealt;
 public $enemyBlocked;
}
class Fight {

    private $player;
    private $enemy;


    public function __construct($player, $enemy) {
        if ($player) {$this->player = $player;}
        if ($enemy) {$this->enemy = $enemy;}
    }

    public function FightRound($playerAttackAction, $playerDefenseAction):FightRoundReturnValue{ //input is the way player attacks (mag, phys, magstrong, physstrong) and the way player defends (mag, phys)

        $ReturnValue = new FightRoundReturnValue();

        $enemyDefenseAction = rand(0,1); # 1 physical block, 0 magical block
        $enemyAttackAction = rand(0,3); #0 phys, 1 mag, 2 physstrong, 3 magstrong
        if ($playerAttackAction) {
            switch ($playerAttackAction) {
                case "phys":
                    if ($enemyDefenseAction == 1) {$this->player->Attack($playerAttackAction, $this->enemy, true); $ReturnValue->enemyBlocked = true;} else
                    {$ReturnValue->playerDamageDealt = $this->player->Attack($playerAttackAction, $this->enemy, false); $ReturnValue->enemyBlocked = false;}
                    break;
                case "mag":
                    if ($enemyDefenseAction == 0) {$this->player->Attack($playerAttackAction, $this->enemy, true); $ReturnValue->enemyBlocked = true;} else
                    {$ReturnValue->playerDamageDealt = $this->player->magAttack($playerAttackAction, $this->enemy, false); $ReturnValue->enemyBlocked = false;}
                    break;
                case "physStrong":
                    if ($enemyDefenseAction == 1) {$this->player->Attack($playerAttackAction, $this->enemy, true); $ReturnValue->enemyBlocked = true;} else
                    {$ReturnValue->playerDamageDealt = $this->player->Attack($playerAttackAction,$this->enemy, false);$ReturnValue->enemyBlocked = false;}
                    break;    
                case "magStrong":
                    if ($enemyDefenseAction == 0) {$this->player->Attack($playerAttackAction, $this->enemy, true); $ReturnValue->enemyBlocked = true;} else
                    {$ReturnValue->playerDamageDealt = $this->player->Attack($playerAttackAction, $this->enemy, false); $ReturnValue->enemyBlocked = false;}
                    break;        
                }
        }
        if ($this->enemy->Getstat("currentHealth") > 0){
                switch($enemyAttackAction){
                    case "0":
                        if ($playerDefenseAction == "phys") {$this->enemy->Attack("phys", $this->player, true); $ReturnValue->playerBlocked = true;} else
                        {$ReturnValue->enemyDamageDealt = $this->enemy->Attack("phys", $this->player, false); $ReturnValue->playerBlocked = false;}
                        break;
                    case "1":
                        if ($playerDefenseAction == "mag") {$this->enemy->Attack("mag", $this->player, true); $ReturnValue->playerBlocked = true;} else
                        {$ReturnValue->enemyDamageDealt = $this->enemy->Attack("mag", $this->player, false); $ReturnValue->playerBlocked = false;}
                        break;
                    case "2":
                        if ($playerDefenseAction == "phys") {$this->enemy->Attack("physstrong", $this->player, true); $ReturnValue->playerBlocked = true;} else
                        {$ReturnValue->enemyDamageDealt = $this->enemy->Attack("physstrong", $this->player, false); $ReturnValue->playerBlocked = false;}
                        break;    
                    case "3":
                        if ($playerDefenseAction == "mag") {$this->enemy->Attack("magstrong", $this->player, true); $ReturnValue->playerBlocked = true;} else
                        {$ReturnValue->enemyDamageDealt = $this->enemy->Attack("magstrong", $this->player, false); $ReturnValue->playerBlocked = false;}
                        break;        
                }
        } 
        
        if ($this->enemy->Getstat("currentHealth") < 1) {  //on win get the loot, return a win
            $this->player->setAttribute("xp", $this->player->Getstat("xp")+$this->enemy->getLootXp()); 
            $this->player->setAttribute("money", $this->player->Getstat("money")+$this->enemy->getLootMoney());
            $ReturnValue->WinLooseContinue = "win";
        } else
        if ($this->player->Getstat("currentHealth") < 1) { //on loose get fucked
            $ReturnValue->WinLooseContinue = "loose";
        } else
        if (($this->player->Getstat("currentHealth") > 0 ) and ($this->enemy->Getstat("currentHealth") > 0)) { // again if both still have hp
            $ReturnValue->WinLooseContinue = "continue"; 
        } else  $ReturnValue->WinLooseContinue = "continue";
        
        return $ReturnValue;
    }
}