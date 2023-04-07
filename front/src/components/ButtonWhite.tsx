import React from 'react';

interface Props {
  onClick: (event: React.MouseEvent<HTMLButtonElement>) => void;
  name?: string;
}

const ButtonWhite: React.FC<Props> = ({ onClick, name = 'Button' }) => {
  return (
    <button
      type="button"
      onClick={onClick}
      className="px-6 py-2 border-2 rounded shadow-md bg-whiteViolet border-violet focus:ring-opacity-75"
    >
      {name}
    </button>
  );
};

export default ButtonWhite;
