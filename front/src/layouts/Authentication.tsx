import AuthenticationContent from '../containers/AuthenticationContent';
import LoginContent from '../containers/LoginContent';
import BackgroundStyle from '../components/BackgroundStyle';

export default function Register() {
  return (
    <div className="relative flex h-screen">
      <BackgroundStyle/>
      <AuthenticationContent />
      <LoginContent />
      </div>
  );
}
