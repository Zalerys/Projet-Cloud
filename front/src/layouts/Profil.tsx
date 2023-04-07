import ProfilContent from '../containers/ProfilContent';
import CheckLog from '../controller/log';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

export default function Profil() {
  const navigate = useNavigate();

  useEffect(() => {
    if (CheckLog() === false) {
      navigate('/authentication');
    }
  });
  return (
    <div className="mx-16">
      <ProfilContent />
    </div>
  );
}
