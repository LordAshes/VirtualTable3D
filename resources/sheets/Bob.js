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
//
rolls =
{
	"STR": "1D20+{STR}",
	"DEX": "1D20+{DEX}",
	"CON": "1D20+{CON}",
	"INT": "1D20+{INT}",
	"WIS": "1D20+{WIS}",
	"CHA": "1D20+{CHA}",
	
	"STR Save": "1D20+{STR.Save}",
	"DEX Save": "1D20+{DEX.Save}",
	"CON Save": "1D20+{CON.Save}",
	"INT Save": "1D20+{INT.Save}",
	"WIS Save": "1D20+{WIS.Save}",
	"CHA Save": "1D20+{CHA.Save}",
	
	"Athletics": "1D20+{Athletics}",
	"Acrobatics": "1D20+{PB}+{Acrobatics}",
	"Slight Of Hand": "1D20+{PB}+{Slight Of Hand}",
	"Stealth": "1D20+{Stealth}",
	"Arcana": "1D20+{Arcana}",
	"History": "1D20+{History}",
	"Investigation": "1D20+{Investigation}",
	"Nature": "1D20+{Nature}",
	"Religion": "1D20+{Religion}",
	"Animal Handling": "1D20+{PB}+{Animal Handling}",
	"Insight": "1D20+{Insight}",
	"Medicine": "1D20+{Medicine}",
	"Perception": "1D20+{Perception}",
	"Survival": "1D20+{Survival}",
	"Deception": "1D20+{Deception}",
	"Intimidation": "1D20+{PB}+{Intimidation}",
	"Performance": "1D20+{Performance}",
	"Persuasion": "1D20+{Persuasion}",
	
	"Attack": "1D20+{Attack}",
	"Spell.DC": "{Spell.DC}",
	
	"Damage": "1D4+1"
}