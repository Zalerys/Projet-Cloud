import AuthenticationContent from '../containers/AuthenticationContent';
import LoginContent from '../containers/LoginContent';
import BackgroundStyle from '../components/BackgroundStyle';

export default function Register() {
  return (
    <div className="relative flex flex-col h-screen sm:flex-row">
      <BackgroundStyle setBackground={1}/>
      <AuthenticationContent />
      <LoginContent />
      </div>
  );
}
