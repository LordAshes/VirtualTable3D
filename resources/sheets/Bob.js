//
// The "character" variable holds all the character values which are used in rolls
//
character =
{
	"Jack": 1,
	"PB": 2,
	"Expert": 4,
	
	"STR": 0,
	"DEX": 4,
	"CON": 2,
	"INT": 1,
	"WIS": 1,
	"CHA": 0,
	
	"STR.Save": 2,
	"DEX.Save": 4,
	"CON.Save": 2,
	"INT.Save": 1,
	"WIS.Save": 3,
	"CHA.Save": 0,
	
	"Athletics": 1,
	"Acrobatics": 1,
	"Slight Of Hand": 1,
	"Stealth": 1,
	"Arcana": 1,
	"History": 1,
	"Investigation": 1,
	"Nature": 1,
	"Religion": 1,
	"Animal Handling": 1,
	"Insight": 1,
	"Medicine": 1,
	"Perception": 1,
	"Survival": 1,
	"Deception": 1,
	"Intimidation": 1,
	"Performance": 1,
	"Persuasion": 1,
	
	"Attack": 9,
	"Spell.DC": 17
};

//
// The "roll" variable holds all the rolls that will be available to the user in the roll pulldown.
// Rolls can access character values by including the (case sensitive) value name in brace brackets.
// A roll surrounded by the Nor() function allows toggling of Disadvantage, Normal and Advantage rolling.
// The portion in the Nor() function will be rolled twice if the current roll option is Adv or Dis and
// either the higher or lower value will be taken depending on the roll option. Anything outside the
// Nor() function will be rolled/calculated only once.
//
rolls =
{
	"STR": "Nor(1D20)+{STR}",
	"DEX": "Nor(1D20)+{DEX}",
	"CON": "Nor(1D20)+{CON}",
	"INT": "Nor(1D20)+{INT}",
	"WIS": "Nor(1D20)+{WIS}",
	"CHA": "Nor(1D20)+{CHA}",
	
	"STR Save": "Nor(1D20)+{STR.Save}",
	"DEX Save": "Nor(1D20)+{DEX.Save}",
	"CON Save": "Nor(1D20)+{CON.Save}",
	"INT Save": "Nor(1D20)+{INT.Save}",
	"WIS Save": "Nor(1D20)+{WIS.Save}",
	"CHA Save": "Nor(1D20)+{CHA.Save}",
	
	"Athletics": "Nor(1D20)+{Athletics}",
	"Acrobatics": "Nor(1D20)+{PB}+{Acrobatics}",
	"Slight Of Hand": "Nor(1D20)+{PB}+{Slight Of Hand}",
	"Stealth": "Nor(1D20)+{Stealth}",
	"Arcana": "Nor(1D20)+{Arcana}",
	"History": "Nor(1D20)+{History}",
	"Investigation": "Nor(1D20)+{Investigation}",
	"Nature": "Nor(1D20)+{Nature}",
	"Religion": "Nor(1D20)+{Religion}",
	"Animal Handling": "Nor(1D20)+{PB}+{Animal Handling}",
	"Insight": "Nor(1D20)+{Insight}",
	"Medicine": "Nor(1D20)+{Medicine}",
	"Perception": "Nor(1D20)+{Perception}",
	"Survival": "Nor(1D20)+{Survival}",
	"Deception": "Nor(1D20)+{Deception}",
	"Intimidation": "Nor(1D20)+{PB}+{Intimidation}",
	"Performance": "Nor(1D20)+{Performance}",
	"Persuasion": "Nor(1D20)+{Persuasion}",
	
	"Attack": "Nor(1D20)+{Attack}",
	"Spell.DC": "{Spell.DC}",
	
	"Damage": "1D4+1"
}