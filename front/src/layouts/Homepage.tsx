import HomepageContent from '../containers/HomepageContent';
import Card from '../components/Card';
import CheckLog from '../controller/log';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

export default function Homepage() {
  const navigate = useNavigate();

  useEffect(() => {
    if (CheckLog() === false) {
      navigate('/authentication');
    }
  });
  return (
    <div className="mx-16">
      <HomepageContent />
      <div className="grid grid-cols-3 gap-10 mx-16 my-12">
        <Card />
        <Card />
        <Card />
        <Card />
      </div>
    </div>
  );
}
