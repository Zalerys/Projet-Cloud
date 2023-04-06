import React from 'react';

export default function Button(props: any) {
  return <button className='h-10 px-6 py-2 rounded text-whiteViolet bg-violet'>{props.name}</button>;
}
