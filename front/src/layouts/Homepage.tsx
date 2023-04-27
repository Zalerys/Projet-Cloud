import HomepageContent from '../containers/HomepageContent';
import Card from '../components/Card';
import CheckLog from '../controller/log';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import BackgroundStyle from '../components/BackgroundStyle';

export default function Homepage() {
  const navigate = useNavigate();

  useEffect(() => {
    if (CheckLog() === false) {
      navigate('/authentication');
    }
  });
  return (
    <div className="relative w-full">
      <HomepageContent />
      <div className="grid gap-10 mx-16 my-12 md:grid-cols-2 lg:grid-cols-3">
        <Card />
        <Card />
        <Card />
        <Card />
      </div>
      <BackgroundStyle setBackground={2}/>
    </div>
  );
}
