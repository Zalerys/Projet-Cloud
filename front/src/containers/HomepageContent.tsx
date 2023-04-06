import ButtonWhite from "../components/ButtonWhite/ButtonWhite";
import Button from "../components/Button";
import { useNavigate } from "react-router-dom";

export default function HomepageContent() {
  const navigate = useNavigate();

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toProfil = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/profil');
  };

  return (
    <>
    <div className="flex justify-between">
      <div className="m-4">
        <ButtonWhite onClick={toProfil} name="Profil" />
      </div>
      <div className="m-4">
        <ButtonWhite onClick={toLogout} name="Déconnexion" />
      </div>
    </div>
    <div className="mt-10 text-center">
      <Button name='Create your server'/>
    </div>
    </>


  );
}
