import React from 'react';

export function ProgressBar({ label, value, getProgressColor }) {
  return (
    <div className="mb-4">
      <label className="block font-medium mb-1">{label}:</label>
      <div className="bg-gray-300 h-4 rounded overflow-hidden">
        <div className={`${getProgressColor(value)} h-full`} style={{ width: `${value}%` }} />
      </div>
    </div>
  );
}
