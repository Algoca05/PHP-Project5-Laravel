import { Tamagotchi } from './Tamagotchi';
import Contact from './Contact';

function App() {
  return (
    <div className="bg-gray-100 min-h-screen flex flex-col items-center">
      <Tamagotchi />
      <Contact />
    </div>
  );
}

export default App;
