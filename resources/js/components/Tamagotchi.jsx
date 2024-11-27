import { useState, useEffect } from 'react';
import happyImage from '../../assets/happy.png';
import sadImage from '../../assets/sad.png';
import hungryImage from '../../assets/hungry.png';
import sickImage from '../../assets/sick.png';
import deadImage from '../../assets/dead.png';
import { ProgressBar } from './ProgressBar';
import { Inventory } from './Inventory';
import { useItem } from '../../utils/useItem';
import itemsData from '../../data/items.json';

export function Tamagotchi() {
  const [hunger, setHunger] = useState(75);
  const [happiness, setHappiness] = useState(75);
  const [health, setHealth] = useState(100);
  const [hygiene, setHygiene] = useState(50);
  const [energy, setEnergy] = useState(100);
  const [level, setLevel] = useState(0);
  let [points, setPoints] = useState(1);
  const [inventory, setInventory] = useState([]);
  const [items, setItems] = useState(itemsData); // Load items from JSON
  const [isPaused, setIsPaused] = useState(false);

  const pointsToLevelUp = 100*level;

  const feed = () => {
    setHunger((prev) => Math.min(prev + 10, 100));
    setHealth((prev) => Math.min(prev + 5, 100));
    setHygiene((prev) => Math.min(prev + -5, 100));

  };

  const play = () => {
    setHappiness((prev) => Math.min(prev + 15, 100));
    setHunger((prev) => Math.max(prev - 15, 0));
    setHealth((prev) => Math.max(prev - 5, 0));
    setEnergy((prev) => Math.max(prev - 5, 0));
  };

  const sleep = () => {
    setHealth((prev) => Math.min(prev + 5, 100));
    setHappiness((prev) => Math.min(prev +5, 100));
    setEnergy((prev) => Math.min(prev + 20, 100));
    setHunger((prev) => Math.max(prev - 5, 0));
  };

  const clean = () => {
    setHygiene((prev) => Math.min(prev + 20, 100));
    setEnergy((prev) => Math.max(prev - 5, 0));
  };

  const resetGame = () => {
    setHunger(50);
    setHappiness(50);
    setHealth(100);
    setHygiene(50);
    setEnergy(100);
    setLevel(1);
    setPoints(0);
    setInventory([]);
    window.location.reload(); // Reload the page
  };

  const togglePause = () => {
    setIsPaused((prev) => !prev);
  };

  useEffect(() => {
    const timer = setInterval(() => {
      if (!isPaused) {
        setHunger((prev) => Math.max(prev - 0.1*(level*0.5), 0));
        setHappiness((prev) => Math.max(prev - 0.1*(level*0.5), 0));
        setHealth((prev) => Math.max(prev - 0.1*(level*0.5), 0));
        setHygiene((prev) => Math.max(prev - 0.1*(level*0.5), 0));
        setEnergy((prev) => Math.max(prev - 0.1*(level*0.5), 0));

        setPoints((prev) => prev + level*0.2 + 1);
        if (points >= 100*level) {
          setLevel((prev) => prev + 1);
          setPoints(0);
        }

        if (health === 0 || hunger === 0 || happiness === 0 || hygiene === 0 || energy === 0) {
          alert("💀 ¡Tu Tamagotchi ha muerto! 💀");
          resetGame();
        }
      }
    }, 100);

    return () => clearInterval(timer);
  }, [points, health, hunger, happiness, hygiene, energy, isPaused]);

  const getProgressColor = (value) => {
    if (value > 60) return "bg-green-500";
    if (value > 20) return "bg-yellow-500";
    return "bg-red-500";
  };

  const getTamagotchiImage = () => {
    if (health === 0 || hunger === 0 || happiness === 0 || hygiene === 0 || energy === 0) return deadImage;
    if (health < 20) return sickImage;
    if (hunger < 20) return hungryImage;
    if (happiness < 20) return sadImage;
    return happyImage;
  };

  const getStatusMessage = () => {
    if (health === 0 || hunger === 0 || happiness === 0 || hygiene === 0 || energy === 0) return "💀 ¡Tu Tamagotchi ha muerto! 💀";
    if (health < 20 && hunger < 20) return "🤒 Estoy enfermo y hambriento 🤒";
    if (health < 20 && happiness < 20) return "🤒 Estoy enfermo y triste 🤒";
    if (hunger < 20 && happiness < 20) return "😟 Estoy hambriento y triste 😟";
    if (hunger < 20 && energy < 20) return "😟 Estoy hambriento y cansado 😟";
    if (hunger < 20 && hygiene < 20) return "😟 Estoy hambriento y sucio 😟";
    if (happiness < 20 && energy < 20) return "😢 Estoy triste y cansado 😢";
    if (happiness < 20 && hygiene < 20) return "😢 Estoy triste y sucio 😢";
    if (energy < 20 && hygiene < 20) return "😴 Estoy cansado y sucio 😴";
    if (hunger < 20) return "😟 ¡Tengo hambre! 😟";
    if (happiness < 20) return "😢 Estoy triste 😢";
    if (health < 20) return "🤒 No me siento bien 🤒";
    if (energy < 20) return "😴 Estoy cansado 😴";
    if (hygiene < 20) return "🛁 Estoy sucio 🛁";
    return "😊¡Estoy feliz! 😊";
  };

  const buyItem = (item) => {
    if (points >= item.cost) {
      setPoints(points - item.cost);
      setInventory([...inventory, item]);
      setItems(items.filter((i) => i.name !== item.name)); // Remove item from store
    } else {
      alert('No tienes suficientes puntos');
    }
  };

  const getItemColor = (item) => {
    switch (item.type) {
      case 'food':
        return 'bg-green-200 hover:bg-green-300';
      case 'toy':
        return 'bg-blue-200 hover:bg-blue-300';
      case 'medicine':
        return 'bg-red-200 hover:bg-red-300';
      case 'cleaning':
        return 'bg-yellow-200 hover:bg-yellow-300';
      case 'energy':
        return 'bg-purple-200 hover:bg-purple-300';
      default:
        return 'bg-gray-200 hover:bg-gray-300';
    }
  };

  return (
    <div className="p-4 bg-white rounded-lg shadow-md w-full flex">
      <div className="w-1/2 p-4">
        <h1 className="text-3xl font-bold text-center mb-1">🐱 Tamagotchi 🐱</h1>
        <p className="text-center text-lg font-semibold mb-4">Nivel: {level}</p> {/* Add level indicator */}
        <p className="text-center text-sm mb-4">Puntos para subir de nivel: {Math.floor(pointsToLevelUp - points)}</p> {/* Add points to level up indicator */}
        <img src={getTamagotchiImage()} alt="Tamagotchi" className="mx-auto mb-4 w-32 h-32 rounded-full border-4 border-yellow-500" />
        <p className="text-center text-lg font-semibold mb-4">{getStatusMessage()}</p>
        <div className="h-70 overflow-y-auto"> {/* Add container with fixed height and overflow */}
          <ProgressBar label="Hambre" value={hunger} getProgressColor={getProgressColor} />
          <ProgressBar label="Felicidad" value={happiness} getProgressColor={getProgressColor} />
          <ProgressBar label="Salud" value={health} getProgressColor={getProgressColor} />
          <ProgressBar label="Higiene" value={hygiene} getProgressColor={getProgressColor} />
          <ProgressBar label="Energía" value={energy} getProgressColor={getProgressColor} />
        </div>
        <div className="flex space-x-2 mt-4">
          <button onClick={feed} disabled={isPaused} className={`flex-1 px-4 py-2 ${isPaused ? 'bg-gray-400' : 'bg-blue-500'} text-white rounded ${!isPaused && 'hover:bg-blue-600'} transition`}>Feed</button>
          <button onClick={play} disabled={isPaused} className={`flex-1 px-4 py-2 ${isPaused ? 'bg-gray-400' : 'bg-green-500'} text-white rounded ${!isPaused && 'hover:bg-green-600'} transition`}>Play</button>
          <button onClick={sleep} disabled={isPaused} className={`flex-1 px-4 py-2 ${isPaused ? 'bg-gray-400' : 'bg-purple-500'} text-white rounded ${!isPaused && 'hover:bg-purple-600'} transition`}>Sleep</button>
          <button onClick={clean} disabled={isPaused} className={`flex-1 px-4 py-2 ${isPaused ? 'bg-gray-400' : 'bg-yellow-500'} text-white rounded ${!isPaused && 'hover:bg-yellow-600'} transition`}>Clean</button>
        </div>
        <div className="flex space-x-2 mt-4">
          <button onClick={togglePause} className="flex-1 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
            {isPaused ? "Play" : "Pause"}
          </button>
        </div>
      </div>
      <div className="border-l border-black"></div>
      <div className="w-1/2 p-4">
        <div className="mb-4">
          <Inventory inventory={inventory} useItem={(itemType) => useItem(itemType, setHunger, setHappiness, setHealth, setEnergy, setHygiene, setLevel)} isPaused={isPaused} />
        </div>
        <div>
          <h2 className="text-xl font-bold mb-2">Tienda</h2>
          <p className="text-center mb-2">Puntos: {Math.floor(points)}</p>
          <div className="grid grid-cols-2 gap-2">
            {items.map((item, index) => (
              <button key={index} onClick={() => !isPaused && buyItem(item)} className={`${getItemColor(item)} p-2 rounded transition ${isPaused ? 'opacity-50 cursor-not-allowed' : ''}`} disabled={isPaused}>
                {item.name} - {item.cost} puntos
              </button>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
