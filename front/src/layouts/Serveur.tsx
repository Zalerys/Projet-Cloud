import ServeurContent from '../containers/ServeurContent';
import CheckLog from '../controller/log';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

export default function Serveur() {
  const navigate = useNavigate();

  useEffect(() => {
    if (CheckLog() === false) {
      navigate('/authentication');
    }
  });
  return (
    <div className="mx-16">
      <ServeurContent />
    </div>
  );
}
