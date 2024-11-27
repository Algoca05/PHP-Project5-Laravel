
const updateStats = (updates, setters) => {
  const [setHunger, setHappiness, setHealth, setEnergy, setHygiene] = setters;
  const { hunger, happiness, health, energy, hygiene } = updates;

  if (hunger !== undefined) setHunger((prev) => Math.min(Math.max(prev + hunger, 0), 100));
  if (happiness !== undefined) setHappiness((prev) => Math.min(Math.max(prev + happiness, 0), 100));
  if (health !== undefined) setHealth((prev) => Math.min(Math.max(prev + health, 0), 100));
  if (energy !== undefined) setEnergy((prev) => Math.min(Math.max(prev + energy, 0), 100));
  if (hygiene !== undefined) setHygiene((prev) => Math.min(Math.max(prev + hygiene, 0), 100));
};

export const useItem = (itemType, setHunger, setHappiness, setHealth, setEnergy, setHygiene, setLevel) => {
  const setters = [setHunger, setHappiness, setHealth, setEnergy, setHygiene];

  console.log(`Using item: ${itemType}`); // Debug log

  switch (itemType) {
    case 'admin_tool':
      updateStats({ hunger: 100, happiness: 100, health: 100, energy: 100, hygiene: 100 }, setters);
      break;
    case 'troll_tool':
      setLevel((prev) => prev + 1);
      break;
    case 'junk_food':
      updateStats({ hunger: 30, happiness: 2, health: -5, energy: 2, hygiene: -5 }, setters);
      break;
    case 'tamagotchi':
      updateStats({ hunger: -10, happiness: 20, health: 5, energy: -5, hygiene: -5 }, setters);
      break;
    case 'ibuprofen':
      updateStats({ hunger: -5, happiness: 5, health: 30, energy: 5, hygiene: -5 }, setters);
      break;
    case 'soap':
    case 'toothbrush':
      updateStats({ hunger: -5, happiness: 5, health: 5, energy: -5, hygiene: 30 }, setters);
      break;
    case 'monster':
      updateStats({ hunger: 5, happiness: 5, health: -10, energy: 30, hygiene: -5 }, setters);
      break;
    case 'legendary_food':
      updateStats({ hunger: 40, happiness: 10, health: -5, energy: 10, hygiene: -5 }, setters);
      break;
    case 'legendary_tamagotchi':
      updateStats({ hunger: -10, happiness: 40, health: 10, energy: -10, hygiene: -10 }, setters);
      break;
    case 'legendary_toothbrush':
    case 'legendary_soap':
      updateStats({ hunger: -10, happiness: 10, health: 10, energy: -10, hygiene: 40 }, setters);
      break;
    case 'legendary_monster':
      updateStats({ hunger: 10, happiness: 10, health: -10, energy: 60, hygiene: -10 }, setters);
      break;
    case 'legendary_ibuprofen':
      updateStats({ hunger: -10, happiness: 10, health: 40, energy: 10, hygiene: -10 }, setters);
      break;
    case 'divine_food':
      updateStats({ hunger: 50, happiness: 20, health: -10, energy: 20, hygiene: -10 }, setters);
      break;
    case 'divine_tamagotchi':
      updateStats({ hunger: -10, happiness: 50, health: 20, energy: -10, hygiene: -10 }, setters);
      break;
    case 'divine_toothbrush':
    case 'divine_soap':
      updateStats({ hunger: -10, happiness: 20, health: 20, energy: -10, hygiene: 50 }, setters);
      break;
    case 'divine_monster':
      updateStats({ hunger: 10, happiness: 30, health: -20, energy: 80, hygiene: -20 }, setters);
      break;
    case 'divine_ibuprofen':
      updateStats({ hunger: -10, happiness: 20, health: 50, energy: 20, hygiene: -10 }, setters);
      break;
    case 'super_food':
      updateStats({ hunger: 50, happiness: 10, health: -5, energy: 10, hygiene: -5 }, setters);
      break;
    case 'mega_tamagotchi':
      updateStats({ hunger: -10, happiness: 30, health: 10, energy: -10, hygiene: -10 }, setters);
      break;
    case 'deluxe_toothbrush':
    case 'antibacterial_soap':
      updateStats({ hunger: -10, happiness: 10, health: 10, energy: -10, hygiene: 30 }, setters);
      break;
    case 'ultra_monster':
      updateStats({ hunger: 10, happiness: 10, health: -10, energy: 50, hygiene: -10 }, setters);
      break;
    case 'plus_ibuprofen':
      updateStats({ hunger: -10, happiness: 10, health: 30, energy: 10, hygiene: -10 }, setters);
      break;
    default:
      console.log(`Unknown item type: ${itemType}`);
  }
};