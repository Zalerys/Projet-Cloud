import AuthenticationContent from '../containers/AuthenticationContent';
import LoginContent from '../containers/LoginContent';

export default function Register() {
  return (
    <div className="flex h-screen">
      <AuthenticationContent />
      <LoginContent/>
    </div>
  );
}
