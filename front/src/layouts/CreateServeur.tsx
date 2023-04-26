import CreateServeurContent from '../containers/CreateServeurContent';
import CheckLog from '../controller/log';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

export default function CreateServeur() {
  const navigate = useNavigate();

  useEffect(() => {
    if (CheckLog() === false) {
      navigate('/authentication');
    }
  });
  return (
    <div className="sm:mx-16">
      <CreateServeurContent />
    </div>
  );
}
