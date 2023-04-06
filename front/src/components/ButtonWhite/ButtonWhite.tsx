import React from 'react';
import './ButtonWhite.css';

interface Props {
  onClick: (event: React.MouseEvent<HTMLButtonElement>) => void;
  name?: string;
}

const Button: React.FC<Props> = ({ onClick, name = 'Button' }) => {
  return (
    <button
      type="button"
      onClick={onClick}
      className="px-8 py-4 bg-whiteViolet font-semibold rounded-sm border-2 border-violet shadow-md focus:ring-opacity-75"
    >
      {name}
    </button>
  );
};

export default Button;
