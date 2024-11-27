import React from 'react';

export function Inventory({ inventory, useItem, isPaused }) {
  return (
    <div className="mt-4">
      <h2 className="text-xl font-bold mb-2">Inventario</h2>
      <div className="grid grid-cols-2 gap-2">
        {inventory.map((item, index) => (
          <button 
            key={index} 
            onClick={() => !isPaused && useItem(item.type)} 
            className={`bg-gray-200 p-2 rounded transition ${isPaused ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300'}`}
            disabled={isPaused}
          >
            {item.name}
          </button>
        ))}
      </div>
    </div>
  );
}
