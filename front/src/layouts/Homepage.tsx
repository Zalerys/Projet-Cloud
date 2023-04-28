import HomepageContent from '../containers/HomepageContent';
import Card from '../components/Card';
import CheckLog from '../controller/log';
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import BackgroundStyle from '../components/BackgroundStyle';
import { getFetch } from '../controller/getFetch';

interface Item {
  id: number;
  name: string;
}

export default function Homepage() {
  const navigate = useNavigate();

  const [items, setItems] = useState<Item[]>([]);

  useEffect(() => {
    const fetchData = async () => {
      const response = await getFetch(
        `/api/servers`,
        sessionStorage.getItem('user'),
      );
      setItems(response);

      if (CheckLog() === false) {
        navigate('/authentication');
      }
    };

    fetchData();
  }, []);

  return (
    <div className="relative w-full">
      <HomepageContent />
      <div className="grid gap-10 mx-16 my-12 md:grid-cols-2 lg:grid-cols-3">
        {items.map((item) => (
          <div key={item.id} className="z-50">
            <Card name={item.name} id={item.id} />
          </div>
        ))}
      </div>
      <BackgroundStyle setBackground={2} />
    </div>
  );
}
